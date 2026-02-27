<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['invoice_code', 'user_id', 'customer_id', 'total', 'payment', 'change', 'status'];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    protected static function booted()
    {
        static::creating(function ($transaction) {
            if (empty($transaction->invoice_code)) {
                $date = now()->format('Ymd');
                $lastTransaction = static::whereDate('created_at', today())->latest()->first();
                
                $sequence = 1;
                if ($lastTransaction && preg_match('/-(\d{4})$/', $lastTransaction->invoice_code, $matches)) {
                    $sequence = intval($matches[1]) + 1;
                }
                
                $transaction->invoice_code = 'INV-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
