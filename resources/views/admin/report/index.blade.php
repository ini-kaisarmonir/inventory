@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
@can('view-dashboard')
<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Sales & Expenses Report</h2>
    </div>

    <form method="GET" class="mb-8 flex items-center gap-4">
        <label for="date" class="text-sm font-medium text-gray-700">Date:</label>
        <input type="date" id="date" name="date" value="{{ $date }}" class="border border-gray-300 rounded px-3 py-2">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">Filter</button>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white shadow rounded-xl p-8 border border-gray-100 flex flex-col items-center">
            <div class="text-lg text-gray-500 mb-2">Total Sale</div>
            <div class="text-3xl font-bold text-green-600">${{ number_format($totalSale, 2) }}</div>
        </div>
        <div class="bg-white shadow rounded-xl p-8 border border-gray-100 flex flex-col items-center">
            <div class="text-lg text-gray-500 mb-2">Total Expense</div>
            <div class="text-3xl font-bold text-red-600">${{ number_format($totalExpense, 2) }}</div>
        </div>
    </div>
</div>
@else
<p class="text-red-600">You are not authorized to view this dashboard.</p>
@endcan
@endsection