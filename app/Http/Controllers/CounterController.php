<?php

namespace App\Http\Controllers;

use App\Jobs\ImportJob;
use App\Models\Counter;
use App\Models\Customer;
use App\Models\Dealer;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CounterController extends Controller
{

    public function index(Request $request)
    {

        $query = Counter::query();

        if ($request->filled('search')) {
            $query->where('serial_number', 'like', '%' . $request->search.'%')
            ->orWhere('phone_number', 'like', '%' . $request->search.'%')
            ->orWhere('imei','like','%'.$request->search.'%');
        }else{
            $counters = $query->paginate(30);
            return view('counters.index',compact('counters'));
        }

        $counters = $query->paginate(1);

        return view('counters.index', compact('counters'));
    }


    public function search(Request $request)
    {

        $query = Counter::query()->whereNull('dealer_id')->whereNull('customer_id')->with('dealer');

        if ($request->filled('search')) {
            $query->where('serial_number', 'like', '%' . $request->search);
        }else{
            $counter = [];
            return view('search',compact('counter'));
        }

        $counter = $query->first();

        return view('search', compact('counter'));
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
            'serial_number' => 'required|integer|max:99999999999999',
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
    public function show(Counter $counter)
    {
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
            'phone_number' => 'string|nullable',
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
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $filePath = $request->file('file')->store('imports');

        ImportJob::dispatch($filePath);

        return back()->with('success', 'Data Imported Successfully');
    }
}
