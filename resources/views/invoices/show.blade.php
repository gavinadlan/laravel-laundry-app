@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center mb-2">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                    <i class="bi bi-receipt text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Invoice {{ $order->invoice_number ?? 'N/A' }}</h1>
                    <p class="text-gray-600 mt-1">Order #{{ $order->id }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('invoices.download', $order) }}" class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 font-semibold rounded-xl hover:bg-green-200 transition-colors duration-200">
                    <i class="bi bi-download mr-2"></i>Download PDF
                </a>
                @if($order->customer->email)
                <form action="{{ route('invoices.email', $order) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 font-semibold rounded-xl hover:bg-blue-200 transition-colors duration-200">
                        <i class="bi bi-envelope mr-2"></i>Email Invoice
                    </button>
                </form>
                @endif
                <a href="{{ route('invoices.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200">
                    <i class="bi bi-arrow-left mr-2"></i>Back
                </a>
            </div>
        </div>
    </div>

    <!-- Invoice Content -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <!-- Invoice Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">INVOICE</h2>
                    <p class="text-indigo-100">Invoice #{{ $order->invoice_number ?? 'N/A' }}</p>
                </div>
                <div class="text-right text-white">
                    <p class="text-sm text-indigo-100">Order Date</p>
                    <p class="text-lg font-semibold">{{ $order->order_date ? date('M d, Y', strtotime($order->order_date)) : '-' }}</p>
                </div>
            </div>
        </div>

        <div class="p-8">
            <!-- Customer & Order Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Bill To</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900 text-lg">{{ $order->customer->name }}</p>
                        @if($order->customer->email)
                            <p class="text-sm text-gray-600 mt-1"><i class="bi bi-envelope mr-2"></i>{{ $order->customer->email }}</p>
                        @endif
                        @if($order->customer->phone)
                            <p class="text-sm text-gray-600 mt-1"><i class="bi bi-telephone mr-2"></i>{{ $order->customer->phone }}</p>
                        @endif
                        @if($order->customer->address)
                            <p class="text-sm text-gray-600 mt-1"><i class="bi bi-geo-alt mr-2"></i>{{ $order->customer->address }}</p>
                        @endif
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Order Information</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-sm text-gray-600">Order ID:</span>
                            <span class="text-sm font-semibold text-gray-900">#{{ $order->id }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm text-gray-600">Status:</span>
                            @php
                                $statusConfig = [
                                    'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                                    'in_progress' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                                    'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
                                    'delivered' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800'],
                                ];
                                $config = $statusConfig[$order->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800'];
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold {{ $config['bg'] }} {{ $config['text'] }}">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </div>
                        @if($order->delivery_date)
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Delivery Date:</span>
                            <span class="text-sm font-semibold text-gray-900">{{ date('M d, Y', strtotime($order->delivery_date)) }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Services Table -->
            <div class="mb-8">
                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Services</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($order->services as $service)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">{{ $service->name }}</div>
                                        @if($service->description)
                                            <div class="text-xs text-gray-500">{{ $service->description }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900">
                                        {{ $service->pivot->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900">
                                        Rp {{ number_format($service->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold text-gray-900">
                                        Rp {{ number_format($service->price * $service->pivot->quantity, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Payments -->
            @if($order->payments->count() > 0)
            <div class="mb-8">
                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Payments</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($order->payments as $payment)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $payment->payment_date ? date('M d, Y', strtotime($payment->payment_date)) : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $payment->method_label }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $payment->reference ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold text-green-600">
                                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Totals -->
            <div class="flex justify-end">
                <div class="w-full md:w-1/3">
                    <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Subtotal:</span>
                            <span class="text-sm font-semibold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Total Paid:</span>
                            <span class="text-sm font-semibold text-green-600">Rp {{ number_format($order->total_paid, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between pt-2 border-t border-gray-200">
                            <span class="text-base font-semibold text-gray-900">Outstanding:</span>
                            <span class="text-base font-bold text-red-600">Rp {{ number_format($order->outstanding, 0, ',', '.') }}</span>
                        </div>
                        <div class="pt-2 border-t border-gray-200">
                            @php
                                $statusConfig = [
                                    'paid' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => 'check-circle'],
                                    'partial' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => 'clock'],
                                    'unpaid' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => 'x-circle'],
                                ];
                                $config = $statusConfig[$order->payment_status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'icon' => 'circle'];
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $config['bg'] }} {{ $config['text'] }}">
                                <i class="bi bi-{{ $config['icon'] }} mr-1"></i>
                                Payment Status: {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            @if($order->notes)
            <div class="mt-8">
                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Notes</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-700">{{ $order->notes }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
