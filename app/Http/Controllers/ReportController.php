<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-t');

        // Total penjualan (Sales)
        $totalSales = \App\Models\Transaction::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                                            ->where('status', 'paid')
                                            ->sum('total');
                                            
        // Total hutang (Unpaid Sales)
        $totalDebt = \App\Models\Debt::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                                     ->where('status', 'unpaid')
                                     ->sum('amount');

        // Total pembelian (Restock)
        $totalPurchases = \App\Models\Purchase::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->sum('total');

        // Keuntungan bersih dari penjualan (Total Jual - Total Modal Barang Terjual)
        $totalModal = 0;
        $transactionDetails = \App\Models\TransactionDetail::whereHas('transaction', function($q) use ($start_date, $end_date) {
            $q->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
        })->with('product')->get();

        foreach($transactionDetails as $detail) {
            // buy_price might be from product, idealnya disimpan di detail juga, 
            // tapi karena Kios kecil, ambil dari master product saat ini
            $totalModal += ($detail->product->buy_price ?? 0) * $detail->quantity;
        }

        // Hitung Keuntungan dari semua transaksi (Lunas / Hutang)
        $semuaTotalJual = \App\Models\Transaction::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->sum('total');
        $totalProfit = $semuaTotalJual - $totalModal;

        return view('reports.index', compact('start_date', 'end_date', 'totalSales', 'totalPurchases', 'totalProfit', 'totalDebt'));
    }
}
