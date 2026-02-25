<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'name',
        'type',
        'code',
        'is_active',
    ];

    public function journalEntries()
    {
        return $this->hasMany(JournalEntry::class);
    }
}
