<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\JournalEntry;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function getReport($date)
    {
        $totalSale = Sale::whereDate('sale_date', $date)->sum('total');

        $totalExpense = JournalEntry::whereHas('account', function ($q) {
            $q->where('type', 'expense');
        })
            ->whereHas('voucher', function ($q) use ($date) {
                $q->whereDate('voucher_date', $date);
            })
            ->selectRaw('SUM(debit - credit) as total')
            ->value('total') ?? 0;

        return [
            'totalSale' => $totalSale,
            'totalExpense' => $totalExpense,
        ];
    }
}
