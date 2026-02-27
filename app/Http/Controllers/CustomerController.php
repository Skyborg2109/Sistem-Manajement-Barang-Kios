<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = \App\Models\Customer::latest()->paginate(10);
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $customer = \App\Models\Customer::create($request->all());
        \App\Models\Activity::log("Menambahkan pelanggan baru: " . $customer->name, 'customer');
        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit(\App\Models\Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, \App\Models\Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $customer->update($request->all());
        \App\Models\Activity::log("Memperbarui data pelanggan: " . $customer->name, 'customer');
        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function destroy(\App\Models\Customer $customer)
    {
        $name = $customer->name;
        $customer->delete();
        \App\Models\Activity::log("Menghapus data pelanggan: " . $name, 'customer');
        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
