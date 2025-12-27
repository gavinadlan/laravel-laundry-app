@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center mb-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                        <i class="bi bi-credit-card text-white text-lg"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Record Payment</h1>
                </div>
                <p class="text-gray-600">Record a payment for an order</p>
            </div>
            @if(request()->has('order_id'))
                <a href="{{ route('orders.show', request('order_id')) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200">
                    <i class="bi bi-arrow-left mr-2"></i>Back to Order
                </a>
            @endif
        </div>
    </div>

    <form action="{{ route('payments.store') }}" method="POST" class="space-y-6">
        @csrf
        @if(request()->has('order_id'))
            <input type="hidden" name="return_to_order" value="1">
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Order -->
            <div>
                <label for="order_id" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="bi bi-cart mr-2 text-indigo-600"></i>Order <span class="text-red-500">*</span>
                </label>
                <select name="order_id" 
                        id="order_id" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none bg-white @error('order_id') border-red-500 @enderror"
                        onchange="updateOrderInfo(this)">
                    <option value="">Select an order</option>
                    @foreach ($orders as $order)
                        <option value="{{ $order->id }}" 
                                data-total="{{ $order->total }}"
                                data-customer="{{ $order->customer->name }}"
                                {{ old('order_id', $selectedOrderId ?? '') == $order->id ? 'selected' : '' }}>
                            #{{ $order->id }} - {{ $order->customer->name }} (Rp {{ number_format($order->total, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
                @error('order_id')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
                <div id="orderInfo" class="mt-2 p-3 bg-blue-50 rounded-lg border border-blue-200 hidden">
                    <p class="text-sm text-blue-800">
                        <i class="bi bi-info-circle mr-1"></i>
                        <span id="orderTotal"></span>
                    </p>
                </div>
            </div>

            <!-- Amount -->
            <div>
                <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="bi bi-currency-dollar mr-2 text-indigo-600"></i>Amount (Rp) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                    <input type="number" 
                           step="0.01" 
                           name="amount" 
                           id="amount" 
                           value="{{ old('amount') }}" 
                           required
                           class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none @error('amount') border-red-500 @enderror"
                           placeholder="0.00">
                </div>
                @error('amount')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Payment Date -->
            <div>
                <label for="payment_date" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="bi bi-calendar-event mr-2 text-indigo-600"></i>Payment Date <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       name="payment_date" 
                       id="payment_date" 
                       value="{{ old('payment_date', date('Y-m-d')) }}" 
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none @error('payment_date') border-red-500 @enderror">
                @error('payment_date')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Payment Method -->
            <div>
                <label for="method" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="bi bi-wallet2 mr-2 text-indigo-600"></i>Payment Method <span class="text-red-500">*</span>
                </label>
                <select name="method" 
                        id="method" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none bg-white @error('method') border-red-500 @enderror">
                    <option value="">Select payment method</option>
                    <option value="Cash" {{ old('method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                    <option value="Bank Transfer" {{ old('method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="Credit Card" {{ old('method') == 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                    <option value="Debit Card" {{ old('method') == 'Debit Card' ? 'selected' : '' }}>Debit Card</option>
                    <option value="E-Wallet" {{ old('method') == 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option>
                    <option value="Other" {{ old('method') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('method')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Reference -->
        <div>
            <label for="reference" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="bi bi-receipt mr-2 text-indigo-600"></i>Reference Number
            </label>
            <input type="text" 
                   name="reference" 
                   id="reference" 
                   value="{{ old('reference') }}"
                   class="w-full md:w-1/2 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none @error('reference') border-red-500 @enderror"
                   placeholder="Transaction ID, Receipt Number, etc.">
            @error('reference')
                <p class="mt-1 text-sm text-red-600 flex items-center">
                    <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
            <p class="mt-1 text-xs text-gray-500">Optional: Enter transaction ID or receipt number for reference</p>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
            @if(request()->has('order_id'))
                <a href="{{ route('orders.show', request('order_id')) }}" class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition duration-200">
                    <i class="bi bi-x-circle mr-2"></i>Cancel
                </a>
            @else
                <a href="{{ route('payments.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition duration-200">
                    <i class="bi bi-x-circle mr-2"></i>Cancel
                </a>
            @endif
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                <i class="bi bi-check-circle mr-2"></i>Record Payment
            </button>
        </div>
    </form>

    <script>
        function updateOrderInfo(select) {
            const option = select.options[select.selectedIndex];
            const orderInfo = document.getElementById('orderInfo');
            const orderTotal = document.getElementById('orderTotal');
            
            if (option.value && option.dataset.total) {
                const total = parseFloat(option.dataset.total);
                orderTotal.textContent = 'Order Total: Rp ' + total.toLocaleString('id-ID');
                orderInfo.classList.remove('hidden');
                
                // Auto-fill amount with order total
                document.getElementById('amount').value = total;
            } else {
                orderInfo.classList.add('hidden');
            }
        }
    </script>
@endsection