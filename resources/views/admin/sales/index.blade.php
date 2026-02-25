@extends('admin.layouts.app')

@section('title', 'Sales List')

@section('content')
<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Sales List</h2>
        <a href="{{ route('sales.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition shadow-sm">
            + Add Sale
        </a>
    </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Invoice No</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer Name</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Due</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($sales as $sale)
                <tr>
                    <td class="px-4 py-3">{{ $sale->invoice_no }}</td>
                    <td class="px-4 py-3">{{ $sale->customer->name ?? '-' }}</td>
                    <td class="px-4 py-3">${{ number_format($sale->total, 2) }}</td>
                    <td class="px-4 py-3">${{ number_format($sale->due, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-gray-400">No sales found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-6">
            {{ $sales->links() }}
        </div>
    </div>
</div>
@endsection
