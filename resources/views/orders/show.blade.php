@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center mb-2">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                    <i class="bi bi-cart-check text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Order #{{ $order->id }}</h1>
                    <p class="text-gray-600 mt-1">Order details and information</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('orders.edit', $order) }}" class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-700 font-semibold rounded-xl hover:bg-yellow-200 transition-colors duration-200">
                    <i class="bi bi-pencil mr-2"></i>Edit
                </a>
                <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200">
                    <i class="bi bi-arrow-left mr-2"></i>Back
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Summary -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-indigo-100 text-sm font-medium">Order Total</p>
                            <p class="text-4xl font-bold text-white mt-2">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </p>
                        </div>
                        <div>
                            @php
                                $statusConfig = [
                                    'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => 'clock'],
                                    'in_progress' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => 'arrow-repeat'],
                                    'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => 'check-circle'],
                                    'delivered' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'icon' => 'truck']
                                ];
                                $config = $statusConfig[$order->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'icon' => 'circle'];
                            @endphp
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $config['bg'] }} {{ $config['text'] }}">
                                <i class="bi bi-{{ $config['icon'] }} mr-2"></i>
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="bi bi-calendar-event text-indigo-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Order Date</p>
                                    <p class="text-lg font-semibold text-gray-900 mt-1">
                                        {{ date('M d, Y', strtotime($order->order_date)) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="bi bi-calendar-check text-indigo-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Delivery Date</p>
                                    <p class="text-lg font-semibold text-gray-900 mt-1">
                                        {{ $order->delivery_date ? date('M d, Y', strtotime($order->delivery_date)) : '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($order->notes)
                    <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="bi bi-sticky text-blue-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-blue-600 mb-2">Notes</p>
                                <p class="text-gray-900">{{ $order->notes }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Services Table -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-4">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <i class="bi bi-list-check mr-2"></i>Services
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Service</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($order->services as $service)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">{{ $service->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-semibold text-gray-900">{{ $service->pivot->quantity }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-bold text-green-600">Rp {{ number_format($service->price * $service->pivot->quantity, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right text-sm font-bold text-gray-700">Total:</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-lg font-bold text-indigo-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Customer Info -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="bi bi-person mr-2 text-indigo-600"></i>Customer
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Name</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $order->customer->name }}</p>
                    </div>
                    @if($order->customer->phone)
                    <div>
                        <p class="text-sm text-gray-500">Phone</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $order->customer->phone }}</p>
                    </div>
                    @endif
                    @if($order->customer->email)
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $order->customer->email }}</p>
                    </div>
                    @endif
                    @if($order->customer->address)
                    <div>
                        <p class="text-sm text-gray-500">Address</p>
                        <p class="text-sm text-gray-900">{{ $order->customer->address }}</p>
                    </div>
                    @endif
                    <div class="pt-4 border-t border-gray-200">
                        <a href="{{ route('customers.show', $order->customer) }}" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                            <i class="bi bi-arrow-right mr-2"></i>View Customer Details
                        </a>
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="bi bi-credit-card mr-2 text-indigo-600"></i>Payment
                </h3>
                @if ($order->payment)
                    <div class="space-y-4">
                        <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                            <p class="text-sm text-green-600 font-medium mb-1">Amount Paid</p>
                            <p class="text-2xl font-bold text-green-700">
                                Rp {{ number_format($order->payment->amount, 0, ',', '.') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Payment Date</p>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ date('M d, Y', strtotime($order->payment->payment_date)) }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Method</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $order->payment->method }}</p>
                        </div>
                        @if($order->payment->reference)
                        <div>
                            <p class="text-sm text-gray-500">Reference</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $order->payment->reference }}</p>
                        </div>
                        @endif
                        <div class="pt-4 border-t border-gray-200">
                            <a href="{{ route('payments.show', $order->payment) }}" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                <i class="bi bi-arrow-right mr-2"></i>View Payment Details
                            </a>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="bi bi-exclamation-circle text-yellow-600 text-2xl"></i>
                        </div>
                        <p class="text-gray-600 mb-4">No payment recorded yet</p>
                        <a href="{{ route('payments.create') }}?order_id={{ $order->id }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <i class="bi bi-plus-circle mr-2"></i>Record Payment
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection