<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DebtPaymentController extends Controller
{
    public function index(\App\Models\Debt $debt)
    {
        $payments = $debt->payments()->latest()->get();
        return view('debt_payments.index', compact('debt', 'payments'));
    }
}
