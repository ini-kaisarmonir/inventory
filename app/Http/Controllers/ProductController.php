<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $products = ProductResource::collection($this->service->getAll());
            return view('admin.products.index', compact('products'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to load products: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(ProductRequest $request)
    {
        try {
            $this->service->store($request->all());
            return redirect()->route('products.index')
                ->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create product: ' . $e->getMessage()])->withInput();
        }
    }
}
