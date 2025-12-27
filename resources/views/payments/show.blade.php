@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center mb-2">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                    <i class="bi bi-credit-card text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Payment #{{ $payment->id }}</h1>
                    <p class="text-gray-600 mt-1">Payment details and information</p>
                </div>
            </div>
            <a href="{{ route('payments.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200">
                <i class="bi bi-arrow-left mr-2"></i>Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Payment Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Payment Amount</p>
                            <p class="text-4xl font-bold text-white mt-2">
                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur">
                            <i class="bi bi-check-circle-fill text-white text-3xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="bi bi-calendar-event text-indigo-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Payment Date</p>
                                    <p class="text-lg font-semibold text-gray-900 mt-1">
                                        {{ date('M d, Y', strtotime($payment->payment_date)) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="bi bi-wallet2 text-indigo-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Payment Method</p>
                                    <p class="text-lg font-semibold text-gray-900 mt-1">
                                        {{ $payment->method }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if($payment->reference)
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 md:col-span-2">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="bi bi-receipt text-indigo-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Reference Number</p>
                                    <p class="text-lg font-semibold text-gray-900 mt-1">
                                        {{ $payment->reference }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Info Sidebar -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="bi bi-cart mr-2 text-indigo-600"></i>Order Information
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Order ID</p>
                        <a href="{{ route('orders.show', $payment->order) }}" class="text-lg font-semibold text-indigo-600 hover:text-indigo-800">
                            #{{ $payment->order->id }}
                        </a>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Customer</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $payment->order->customer->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Order Total</p>
                        <p class="text-lg font-semibold text-gray-900">
                            Rp {{ number_format($payment->order->total, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection