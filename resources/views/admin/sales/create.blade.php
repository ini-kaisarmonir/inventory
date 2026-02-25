@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
@can('view-dashboard')

<div class="container">
    <h2>Create Sale</h2>

    <form method="POST" action="{{ route('sales.store') }}" class="bg-white shadow-lg rounded-xl p-6 border border-gray-100">
        @csrf

        <div class="mb-8 p-4 bg-blue-50 rounded-lg border border-blue-100">
            <label class="block text-sm font-bold text-blue-900 mb-2 uppercase tracking-wide">Customer Selection</label>
            <select name="customer_id" class="w-full px-4 py-2.5 bg-white border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700" required>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">
                        {{ $customer->name }} — (Due: {{ number_format($customer->balance, 2) }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="overflow-x-auto mb-8">
            <table class="w-full text-left border-collapse" id="items">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Select Product</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase w-32">Qty</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase w-40">Price</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase w-40">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($products as $product)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-4">
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="checkbox" name="products[{{ $product->id }}][selected]" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">{{ $product->name }}</span>
                            </label>
                        </td>
                        <td class="px-4 py-4">
                            <input type="number" step="0.01" name="products[{{ $product->id }}][qty]" 
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-md focus:ring-1 focus:ring-blue-500 focus:outline-none text-sm"
                                placeholder="0.00">
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-600 font-mono">
                            {{ number_format($product->sell_price, 2) }}
                            <input type="hidden" name="products[{{ $product->id }}][price]" value="{{ $product->sell_price }}">
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-400">—</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 bg-gray-50 rounded-xl border border-gray-200">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Discount Amount</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-gray-400">$</span>
                    <input type="number" step="0.01" name="discount" value="0" 
                        class="w-full pl-7 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">VAT %</label>
                <div class="relative">
                    <input type="number" step="0.01" name="vat_percent" value="5" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none">
                    <span class="absolute right-3 top-2 text-gray-400">%</span>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Paid Amount</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-gray-400">$</span>
                    <input type="number" step="0.01" name="paid" value="0" 
                        class="w-full pl-7 pr-4 py-2 border border-gray-300 rounded-lg border-green-500 bg-green-50 focus:ring-2 focus:ring-green-600 focus:outline-none font-bold text-green-700">
                </div>
            </div>
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transition-all transform active:scale-[0.98]">
                Complete Sale & Generate Invoice
            </button>
        </div>
    </form>
</div>
@else
<p class="text-red-600">You are not authorized to view this dashboard.</p>
@endcan
@endsection
