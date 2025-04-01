<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Customer;
use App\Models\Region;
use Illuminate\Http\Request;

class CustomerController extends Controller
{


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $customers = Customer::query()->with('region')->paginate(15);

        return view('customers.index', compact('customers'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Customer::create($request->validate([
            'organization_name' => 'nullable|string|max:255',
            'organization_INN' => 'required|string|max:255',
            'director_name' => 'nullable|string|max:255',
            'counter_address' => 'required|string|max:255',
            'phone_number' => 'nullable|numeric',
            'personal_account_number' => 'nullable|numeric',
        ]));

        return redirect()->back()->with('success', 'Customer added successfully.');
    }

    /**
     * @param Customer $customer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->back()->with('success', 'Customer added successfully.');
    }

    /**
     * @param Customer $customer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit($id)
    {
        $customer = Customer::query()->findOrFail($id);
        $counters = Counter::query()->select('id','imei','serial_number','created_at')->where('customer_id', $id)->paginate(10);
        $regions = Region::all();

        return view('customers.edit', compact('customer','regions','counters'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'organization_name' => 'required|string|max:255',
            'personal_account_number' => 'required|string|max:50',
            'organization_INN' => 'required|numeric|digits_between:9,14',
            'director_name' => 'required|string|max:255',
            'region' => 'required|exists:regions,id',
            'phone_number' => 'required|numeric|digits_between:7,15',
        ]);

        $customer->update([
            'organization_name' => $validated['organization_name'],
            'personal_account_number' => $validated['personal_account_number'],
            'organization_INN' => $validated['organization_INN'],
            'director_name' => $validated['director_name'],
            'region_id' => $validated['region'],
            'phone_number' => $validated['phone_number'],
        ]);

        return redirect()->route('customers.index')->with('success', "Mijoz muvaffaqiyatli yangilandi.");
    }
}
