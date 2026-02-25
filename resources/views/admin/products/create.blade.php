@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
@can('view-dashboard')
<div class=" mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-3xl font-bold mb-8 text-gray-800">Create New Product</h2>

<form action="{{ route('products.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Product Name</label>
            <input type="text" name="name" 
                class="w-full placeholder:text-gray-400 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-200" 
                placeholder="e.g. Wireless Mouse" required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">SKU</label>
            <input type="text" name="sku" 
                class="w-full placeholder:text-gray-400 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-200" 
                placeholder="PROD-12345">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Purchase Price</label>
                <input type="number" step="0.01" name="purchase_price" 
                    class="w-full placeholder:text-gray-400 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                    placeholder="0.00" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Selling Price</label>
                <input type="number" step="0.01" name="sell_price" 
                    class="w-full placeholder:text-gray-400 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                    placeholder="0.00" required>
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Opening Stock Quantity</label>
            <input type="number" step="0.01" name="opening_stock" 
                class="w-full placeholder:text-gray-400 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                placeholder="0" required>
        </div>

        <div class="pt-4">
            <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out shadow-sm transform active:scale-95">
                Save Product
            </button>
        </div>
    </form>
</div>
@else
<p class="text-red-600">You are not authorized to view this dashboard.</p>
@endcan
@endsection