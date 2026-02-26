<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\JournalEntry;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function getReport($request)
    {
        $date = $request->get('date');

        $totalSale = Sale::query()
            ->when($date, function ($query) use ($date) {
                $query->whereDate('sale_date', $date);
            })
            ->sum('total');

        $totalExpense = JournalEntry::whereHas('account', function ($q) {
            $q->where('type', 'expense');
        })
            ->when($date, function ($query) use ($date) {
                $query->whereHas('voucher', function ($q) use ($date) {
                    $q->whereDate('voucher_date', $date);
                });
            })
            ->selectRaw('SUM(debit - credit) as total')
            ->value('total') ?? 0;

        return [
            'totalSale' => $totalSale,
            'totalExpense' => $totalExpense,
            'date' => $date,
        ];
    }
}
