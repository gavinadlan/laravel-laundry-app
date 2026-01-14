@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center mb-2">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                    <i class="bi bi-credit-card text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Payment History</h1>
                    <p class="text-gray-600 mt-1">{{ $customer->name }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('customers.show', $customer) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200">
                    <i class="bi bi-arrow-left mr-2"></i>Back to Customer
                </a>
            </div>
        </div>
    </div>

    <!-- Customer Info Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 mb-6">
        <div class="flex items-center">
            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                <i class="bi bi-person-fill text-indigo-600 text-2xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $customer->name }}</h2>
                <div class="flex items-center space-x-4 mt-1">
                    @if($customer->email)
                        <span class="text-sm text-gray-600"><i class="bi bi-envelope mr-1"></i>{{ $customer->email }}</span>
                    @endif
                    @if($customer->phone)
                        <span class="text-sm text-gray-600"><i class="bi bi-telephone mr-1"></i>{{ $customer->phone }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($payments->count() > 0)
        <!-- Payments Table -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-indigo-600 to-purple-600">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Payment Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Invoice #</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Order Date</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-white uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Method</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Reference</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($payments as $payment)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $payment->payment_date ? date('M d, Y', strtotime($payment->payment_date)) : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-indigo-600">{{ $payment->order->invoice_number ?? 'N/A' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $payment->order->order_date ? date('M d, Y', strtotime($payment->order->order_date)) : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-green-600">
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $payment->method_label }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $payment->reference ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('payments.show', $payment) }}" class="text-indigo-600 hover:text-indigo-900" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('orders.show', $payment->order) }}" class="text-blue-600 hover:text-blue-900" title="View Order">
                                            <i class="bi bi-cart"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">TOTAL</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-green-600">
                                Rp {{ number_format($payments->sum('amount'), 0, ',', '.') }}
                            </td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $payments->links() }}
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-credit-card text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Payments Found</h3>
            <p class="text-gray-600">This customer has no payment history yet.</p>
        </div>
    @endif
@endsection
