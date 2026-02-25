<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalVoucher extends Model
{
    protected $fillable = [
        'reference',
        'voucher_date',
        'description',
        'created_by',
    ];

    protected $casts = [
        'voucher_date' => 'date',
    ];

    public function entries()
    {
        return $this->hasMany(JournalEntry::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
