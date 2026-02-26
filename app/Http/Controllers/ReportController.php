<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use App\Models\JournalEntry;
use App\Models\Account;
use App\Models\Sale;

class ReportController extends Controller
{
    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index(\Illuminate\Http\Request $request)
    {
        try {
            $report = app(\App\Services\ReportService::class)->getReport($request);
            return view('admin.report.index', $report);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to generate report: ' . $e->getMessage()]);
        }
    }
}
