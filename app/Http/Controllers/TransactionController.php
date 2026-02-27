<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = \App\Models\Transaction::with(['user', 'customer'])->latest()->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = \App\Models\Product::where('stock', '>', 0)->get();
        $customers = \App\Models\Customer::all();
        return view('transactions.create', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cart' => 'required|string',
            'payment' => 'required|numeric|min:0',
            'customer_id' => 'nullable|exists:customers,id',
        ]);

        $cart = json_decode($request->cart, true);
        if (empty($cart)) {
            return back()->with('error', 'Keranjang belanja kosong!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $payment = $request->payment;
        $change = $payment - $total;
        $status = $payment >= $total ? 'paid' : 'debt';

        if ($status === 'debt' && !$request->customer_id) {
            return back()->with('error', 'Untuk transaksi hutang (pembayaran kurang), pelanggan harus dipilih!');
        }

        \DB::beginTransaction();
        try {
            $transaction = \App\Models\Transaction::create([
                'user_id' => auth()->id(),
                'customer_id' => $request->customer_id,
                'total' => $total,
                'payment' => $payment,
                'change' => $change > 0 ? $change : 0,
                'status' => $status,
            ]);

            foreach ($cart as $item) {
                // Ensure sufficient stock
                $product = \App\Models\Product::find($item['id']);
                if (!$product || $product->stock < $item['qty']) {
                    throw new \Exception("Stok {$item['name']} tidak mencukupi!");
                }

                \App\Models\TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['qty'],
                ]);
            }

            // If debt, insert to debts table
            if ($status === 'debt') {
                \App\Models\Debt::create([
                    'customer_id' => $request->customer_id,
                    'transaction_id' => $transaction->id,
                    'amount' => $total - $payment,
                    'status' => 'unpaid',
                ]);
            }

            \App\Models\Activity::log("Transaksi baru " . $transaction->invoice_code . " sebesar Rp " . number_format($total, 0, ',', '.') . " berhasil disimpan.", 'transaction');
            \DB::commit();
            return redirect()->route('transactions.show', $transaction->id)->with('success', 'Transaksi berhasil disimpan!');

        } catch (\Exception $e) {
            \DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(\App\Models\Transaction $transaction)
    {
        $transaction->load(['details.product', 'user', 'customer']);
        return view('transactions.show', compact('transaction'));
    }
}
