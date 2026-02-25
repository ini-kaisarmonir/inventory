<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Services\SaleService;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function create()
    {
        $products = Product::with('stock')->get();
        $customers = Customer::all();

        return view('admin.sales.create', compact('products','customers'));
    }

    public function store(Request $request, SaleService $service)
    {
        $service->store($request->all());

        return redirect()->route('sales.create')
            ->with('success','Sale completed');
    }
}
