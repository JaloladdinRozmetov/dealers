<?php

namespace App\Http\Controllers;

use App\Jobs\ImportJob;
use App\Jobs\ImportPhoneJob;
use App\Models\Counter;
use App\Models\Customer;
use App\Models\Dealer;
use App\Services\CounterConnectService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CounterController extends Controller
{
    protected $counterService;

    public function __construct(CounterConnectService $counterService)
    {
        $this->counterService = $counterService;
    }

    public function index(Request $request)
    {

        $query = Counter::query();

        // Apply search filter if present
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('serial_number', 'like', '%' . $request->search . '%')
                    ->orWhere('caliber', 'like', '%' . $request->search . '%')
                    ->orWhere('imei', 'like', '%' . $request->search . '%')
                    ->orWhere('iccid', 'like', '%' . $request->search . '%')
                    ->orWhere('phone_number', 'like', '%' . $request->search . '%');
            });
        }

        // Apply filter based on status, default to "sold"
        if ($request->status === 'notSold') {
            $query->whereNull('dealer_id')->whereNull('customer_id');
        } else {
            $query->whereHas('dealer'); // Default to "sold" if no status specified
        }

        // Paginate results
        $counters = $query->paginate(10);

        return view('counters.index', compact('counters'));
    }


    public function search(Request $request)
    {
        $query = Counter::query()->with('dealer');

        if ($request->filled('search')) {
            $query->where('serial_number', 'like', '%' . $request->search);
        }else{
            $counter = [];
            return view('search',compact('counter'));
        }

        $counter = $query->first();

        if ($counter){
            try {
               $status_counter = $this->counterService->fetchMeters(0,1,$counter->serial_number);
               if($status_counter['data']['meters'][0]){
                   $counter['status'] = $status_counter['data']['meters'][0]['status'];
               }else{
                   $counter['status'] = null;
               }
            }catch (\Exception $exception){
                $counter['status'] = null;
            }
            return view('search', compact('counter'));
        }else{
            return redirect()->route('search')->withErrors(['error'=>'Bu seriya raqamidagi hisoblagich topilmadi!']);
        }
    }
    /**
     * Show the form for creating a new counter.
     */
    public function create()
    {
        return view('counters.create');
    }


    /**
     * Store a newly created counter in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'serial_number' => 'required|unique:counters|integer|max:99999999999999',
            'caliber' => 'required|string|max:255',
            'imei' => 'required|integer|max:999999999999999',
            'iccid' => 'required|integer|max:9999999999999999999',
            'phone_number' => 'nullable|integer|max:999999999',
            'dealer_id' => 'nullable|exists:dealers,id'
        ]);

        Counter::create($validatedData);

        return redirect()->route('counters')->with('success', 'Counter created successfully.');
    }

    /**
     * Display the specified counter.
     */
    public function show($id)
    {
        $counter = Counter::query()->with('customer', 'dealer')->findOrFail($id);

        return view('counters.show', compact('counter'));
    }

    /**
     * Show the form for editing the specified counter.
     */
    public function edit(Counter $counter)
    {
        $counter = $counter->with('dealer')->firstOrFail();
        return view('counters.edit', compact('counter'));
    }

    /**
     * Update the specified counter in storage.
     */
    public function update(Request $request, Counter $counter)
    {
        $validatedData = $request->validate([
            'serial_number' => 'required|integer|max:99999999999999',
            'caliber' => 'required|string|max:255',
            'imei' => 'required|integer|max:999999999999999',
            'iccid' => 'required|integer|max:9999999999999999999',
            'phone_number' => 'nullable|integer|max:999999999',
            'dealer_id' => 'nullable|exists:dealers,id'
        ]);

        $counter->update($validatedData);

        return redirect()->route('counters')->with('success', 'Counter updated successfully.');
    }

    /**
     * Remove the specified counter from storage.
     */
    public function destroy(Counter $counter)
    {
        $counter->delete();

        return redirect()->route('counters')->with('success', 'Counter deleted successfully.');
    }

    public function soldCounter(Request $request)
    {
        $request->validate([
            'organization_INN' => 'required|string',
            'organization_name' => 'string|nullable',
            'director_name' => 'string|nullable',
            'counter_address' => 'string|nullable',
            'phone_number' => 'string|nullable|max:9',
        ]);

        $customer = Customer::query()->firstOrCreate(['organization_INN' => $request->organization_INN],
            [
                'organization_name' => $request->organization_name,
                'director_name' => $request->director_name,
                'counter_address' => $request->counter_address,
                'phone_number' => $request->phone_number,
            ]);
        $dealer = Dealer::query()->where('user_id',auth()->user()->id)->first();
        if (auth()->user()->role == 'dealer'){
            Counter::query()->where('id',$request->counter_id)->update([
                'dealer_id' => $dealer->id,
                'customer_id' => $customer->id
            ]);

            return redirect()->route('search')->with('success', 'Customer added and counter updated successfully.');
        }else{
            return redirect()->route('search')->with('error', 'You are is admin only dealer can update!');
        }
    }

    public function counterImport()
    {
        return view('counters.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
            'type' => 'required|in:data,phone_number',
        ]);

        $fileType = $request->input('type');
        $filePath = $request->file('file')->store('imports');

        if ($fileType === 'data') {
            ImportJob::dispatch($filePath);

        } elseif ($fileType === 'phone_number') {
            ImportPhoneJob::dispatch($filePath);
        }

        return back()->with('success', 'Data Imported Successfully');

    }
}
