<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function index()
    {
        $debts = \App\Models\Debt::with(['customer', 'transaction'])->latest()->paginate(10);
        return view('debts.index', compact('debts'));
    }

    public function update(Request $request, \App\Models\Debt $debt)
    {
        \DB::beginTransaction();
        try {
            $debt->status = 'paid';
            $debt->save();

            // Update transaction status as well
            $transaction = $debt->transaction;
            $transaction->status = 'paid';
            $transaction->payment = $transaction->total;
            $transaction->change = 0;
            $transaction->save();
            
            \App\Models\Activity::log("Pelunasan piutang " . $transaction->invoice_code . " atas nama " . $debt->customer->name . " berhasil.", 'debt');
            \DB::commit();
            return back()->with('success', 'Hutang berhasil dilunasi!');
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->with('error', 'Gagal melunasi hutang: ' . $e->getMessage());
        }
    }
    public function pay(Request $request, \App\Models\Debt $debt)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $debt->amount,
            'note' => 'nullable|string|max:255',
        ]);

        \DB::beginTransaction();
        try {
            $paymentAmount = $request->amount;
            
            // Record payment
            \App\Models\DebtPayment::create([
                'debt_id' => $debt->id,
                'amount' => $paymentAmount,
                'note' => $request->note,
            ]);

            // Update debt amount
            $debt->amount -= $paymentAmount;
            if ($debt->amount <= 0) {
                $debt->status = 'paid';
                $debt->amount = 0;
            }
            $debt->save();

            // Update transaction payment info
            $transaction = $debt->transaction;
            $transaction->payment += $paymentAmount;
            if ($transaction->payment >= $transaction->total) {
                $transaction->status = 'paid';
                $transaction->payment = $transaction->total;
                $transaction->change = 0;
            }
            $transaction->save();
            
            \App\Models\Activity::log("Pembayaran cicilan piutang " . $transaction->invoice_code . " sebesar Rp " . number_format($paymentAmount, 0, ',', '.') . " dari " . $debt->customer->name . " berhasil.", 'debt');
            
            \DB::commit();
            return back()->with('success', 'Pembayaran cicilan berhasil dicatat!');
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->with('error', 'Gagal mencatat pembayaran: ' . $e->getMessage());
        }
    }
}
