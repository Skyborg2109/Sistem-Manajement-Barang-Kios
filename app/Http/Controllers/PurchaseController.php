<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = \App\Models\Purchase::with(['supplier', 'user'])->latest()->paginate(10);
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $products = \App\Models\Product::all();
        $suppliers = \App\Models\Supplier::all();
        return view('purchases.create', compact('products', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'cart' => 'required|string',
        ]);

        $cart = json_decode($request->cart, true);
        if (empty($cart)) {
            return back()->with('error', 'Daftar barang masuk kosong!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        \DB::beginTransaction();
        try {
            $purchase = \App\Models\Purchase::create([
                'user_id' => auth()->id(),
                'supplier_id' => $request->supplier_id,
                'total' => $total,
            ]);

            foreach ($cart as $item) {
                // The booted method in PurchaseDetail will handle stock increment and price update
                \App\Models\PurchaseDetail::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                ]);
            }

            \App\Models\Activity::log("Penerimaan barang baru dari " . $purchase->supplier->name . " berhasil dicatat.", 'purchase');
            \DB::commit();
            return redirect()->route('purchases.index')->with('success', 'Data barang masuk berhasil disimpan!');
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(\App\Models\Purchase $purchase)
    {
        $purchase->load(['details.product', 'supplier', 'user']);
        return view('purchases.show', compact('purchase'));
    }
}
