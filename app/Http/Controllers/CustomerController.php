<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function store(Request $request)
    {
        Customer::create($request->validate([
            'organization_name' => 'nullable|string|max:255',
            'organization_INN' => 'required|string|max:255',
            'director_name' => 'nullable|string|max:255',
            'counter_address' => 'required|string|max:255',
            'phone_number' => 'nullable|numeric',
        ]));

        return redirect()->back()->with('success', 'Customer added successfully.');
    }
}
