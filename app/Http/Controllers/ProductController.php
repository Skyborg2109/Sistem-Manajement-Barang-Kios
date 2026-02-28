<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = \App\Models\Product::with('category')->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'buy_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
        ]);

        $product = \App\Models\Product::create($request->all());
        \App\Models\Activity::log("Menambahkan barang baru: " . $product->name, 'inventory');
        return redirect()->route('products.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Request $request, \App\Models\Product $product)
    {
        $categories = \App\Models\Category::all();
        $page = $request->query('page', 1);
        return view('products.edit', compact('product', 'categories', 'page'));
    }

    public function update(Request $request, \App\Models\Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'buy_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
        ]);

        $product->update($request->all());
        \App\Models\Activity::log("Memperbarui data barang: " . $product->name, 'inventory');
        
        return redirect()->route('products.index', ['page' => $request->page])
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Request $request, \App\Models\Product $product)
    {
        // Prevent deletion if associated with transactions or purchases
        // For simplicity, we just delete
        $name = $product->name;
        $product->delete();
        \App\Models\Activity::log("Menghapus barang: " . $name, 'inventory');
        
        return redirect()->route('products.index', ['page' => $request->page])
            ->with('success', 'Barang berhasil dihapus.');
    }
}
