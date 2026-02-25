<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Customer;
use App\Services\SaleService;
use App\Http\Requests\SaleRequest;

class SaleController extends Controller
{
    public function index()
    {
        try {
            $sales = Sale::with('customer')->orderByDesc('id')->paginate(20);
            return view('admin.sales.index', compact('sales'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to load sales: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        try {
            $products = Product::with('stock')->get();
            $customers = Customer::all();

            return view('admin.sales.create', compact('products', 'customers'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to load sale form: ' . $e->getMessage()]);
        }
    }

    public function store(SaleRequest $request, SaleService $service)
    {
        try {
            $service->store($request->all());
            return redirect()->route('sales.index')->with('success', 'Sale completed successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to complete sale: ' . $e->getMessage()]);
        }
    }
}
