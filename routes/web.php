<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DebtPaymentController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Modules for Admin only (in real app, should use middleware)
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/activities/mark-as-read', [ActivityController::class, 'markAsRead'])->name('activities.markAsRead');
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::resource('users', UserController::class);
    
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    
    // Modules for Admin and Kasir
    Route::resource('transactions', TransactionController::class);
    Route::resource('customers', CustomerController::class);
    Route::post('debts/{debt}/pay', [DebtController::class, 'pay'])->name('debts.pay');
    Route::get('debts/{debt}/payments', [DebtPaymentController::class, 'index'])->name('debts.payments');
    Route::resource('debts', DebtController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
