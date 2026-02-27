<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Transaction;
use App\Models\Product;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        $salesToday = Transaction::whereDate('created_at', $today)->sum('total');
        
        // Approximation of profit (Total Sales - Total Costs). In reality, needs cost mapping
        // We will just do a mock or fetch from details.
        // Assuming we calculate from details directly:
        // Profit = subtotal - (buy_price * quantity) Let's keep it simple
        $profitToday = \DB::table('transaction_details')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->whereDate('transactions.created_at', $today)
            ->select(\DB::raw('SUM(transaction_details.subtotal - (products.buy_price * transaction_details.quantity)) as total_profit'))
            ->first()->total_profit ?? 0;

        $lowStockProducts = Product::whereColumn('stock', '<=', 'min_stock')->get();
        
        $topProducts = \DB::table('transaction_details')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->select('products.name', \DB::raw('SUM(transaction_details.quantity) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        return view('dashboard', compact('salesToday', 'profitToday', 'lowStockProducts', 'topProducts'));
    }
}
