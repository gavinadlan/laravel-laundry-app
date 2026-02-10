@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center mb-2">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                        <i class="bi bi-credit-card text-white text-lg"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Payment Checkout</h1>
                </div>
                <p class="text-gray-600">Complete your payment securely with Midtrans</p>
            </div>
            <a href="{{ route('orders.show', $order) }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200">
                <i class="bi bi-arrow-left mr-2"></i>Back to Order
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Order Summary -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <i class="bi bi-receipt mr-2 text-indigo-600"></i>Order Summary
            </h2>

            <div class="space-y-4">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Invoice Number</span>
                    <span class="font-semibold text-gray-900">{{ $order->invoice_number }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Customer</span>
                    <span class="font-semibold text-gray-900">{{ $order->customer->name }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Total Amount</span>
                    <span class="font-semibold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Already Paid</span>
                    <span class="font-semibold text-green-600">Rp
                        {{ number_format($order->total_paid, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2 bg-indigo-50 px-3 rounded-lg mt-2">
                    <span class="text-indigo-800 font-semibold">Amount to Pay</span>
                    <span class="font-bold text-indigo-800">Rp {{ number_format($order->outstanding, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Action -->
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center items-center text-center">
            <div class="mb-6">
                <img src="https://docs.midtrans.com/asset/image/main/midtrans-logo.png" alt="Midtrans"
                    class="h-12 mx-auto mb-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Secure Payment Gateway</h3>
                <p class="text-gray-500 text-sm max-w-xs mx-auto">
                    You can pay using GoPay, ShopeePay, Bank Transfer, Credit Card, and more via QRIS.
                </p>
            </div>

            <button id="pay-button"
                class="w-full max-w-sm px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center">
                <i class="bi bi-shield-lock mr-2"></i>Pay Now
            </button>
            <p class="mt-4 text-xs text-gray-400">
                <i class="bi bi-lock-fill mr-1"></i>Payments are secure and encrypted.
            </p>
        </div>
    </div>

    <!-- Midtrans Snap Script -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function () {
            // SnapToken acquired from previous step
            snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    // Redirect to completion handler to verify status
                    window.location.href = "{{ route('payments.complete') }}?order_id=" + result.order_id;
                },
                onPending: function (result) {
                    // Redirect to completion handler to verify status
                    window.location.href = "{{ route('payments.complete') }}?order_id=" + result.order_id;
                },
                onError: function (result) {
                    alert("Payment failed!");
                    console.log(result);
                }
            });
        };
    </script>
@endsection