<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'invoice_no',
        'customer_name',
        'subtotal',
        'discount',
        'vat_percent',
        'vat_amount',
        'total',
        'paid',
        'due',
        'sale_date',
        'created_by',
    ];

    protected $casts = [
        'sale_date' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}