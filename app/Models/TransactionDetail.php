<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = ['transaction_id', 'product_id', 'quantity', 'price', 'subtotal'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    protected static function booted()
    {
        static::created(function ($detail) {
            $product = $detail->product;
            if ($product) {
                $product->decrement('stock', $detail->quantity);
            }
        });

        static::deleted(function ($detail) {
            $product = $detail->product;
            if ($product) {
                $product->increment('stock', $detail->quantity);
            }
        });
    }
}
