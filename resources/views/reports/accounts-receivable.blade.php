@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center mb-2">
                <div
                    class="w-10 h-10 bg-gradient-to-br from-red-500 to-pink-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                    <i class="bi bi-wallet2 text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Accounts Receivable</h1>
                    <p class="text-gray-600 mt-1">Outstanding payments from customers</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('reports.orders') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200">
                    <i class="bi bi-arrow-left mr-2"></i>Back
                </a>
            </div>
        </div>
    </div>

    @if($receivables->count() > 0)
        <!-- Summary Card -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl shadow-lg p-6 border border-red-200 col-span-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-red-600">Total Outstanding</p>
                        <p class="text-3xl font-bold text-red-900 mt-2">Rp {{ number_format($totalReceivable, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center">
                        <i class="bi bi-exclamation-circle text-white text-xl"></i>
                    </div>
                </div>
            </div>
            <div
                class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl shadow-lg p-6 border border-orange-200 col-span-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-orange-600">Customers Owing</p>
                        <p class="text-3xl font-bold text-orange-900 mt-2">{{ $receivables->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center">
                        <i class="bi bi-people text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Receivables Table -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-red-600 to-pink-600">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Customer
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Contact
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Unpaid
                                Orders</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-white uppercase tracking-wider">
                                Outstanding Amount</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-white uppercase tracking-wider">Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($receivables as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $item['customer']->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $item['customer']->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $item['customer']->phone }}</div>
                                    <div class="text-xs text-gray-500 truncate max-w-xs">{{ $item['customer']->address }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        {{ $item['unpaid_orders_count'] }} Orders
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-red-600">
                                    Rp {{ number_format($item['outstanding'], 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('invoices.index', ['customer_id' => $item['customer']->id, 'payment_status' => 'unpaid']) }}"
                                        class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                        View Invoices
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-12 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-check-lg text-green-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Outstanding Payments</h3>
            <p class="text-gray-600">Great job! All customers have paid their dues.</p>
        </div>
    @endif
@endsection