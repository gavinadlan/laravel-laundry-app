@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <div class="flex items-center mb-2">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                <i class="bi bi-pencil-square text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Order #{{ $order->id }}</h1>
                <p class="text-gray-600 mt-1">Update order information</p>
            </div>
        </div>
    </div>

    <form action="{{ route('orders.update', $order) }}" method="POST" class="space-y-6" id="orderForm">
        @csrf
        @method('PUT')
        
        <!-- Customer & Dates Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Customer -->
            <div>
                <label for="customer_id" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="bi bi-person mr-2 text-indigo-600"></i>Customer <span class="text-red-500">*</span>
                </label>
                <select name="customer_id" 
                        id="customer_id" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none bg-white @error('customer_id') border-red-500 @enderror">
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id', $order->customer_id) == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }} @if($customer->phone) - {{ $customer->phone }} @endif
                        </option>
                    @endforeach
                </select>
                @error('customer_id')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Order Date -->
            <div>
                <label for="order_date" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="bi bi-calendar-event mr-2 text-indigo-600"></i>Order Date <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       name="order_date" 
                       id="order_date" 
                       value="{{ old('order_date', $order->order_date) }}" 
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none @error('order_date') border-red-500 @enderror">
                @error('order_date')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Delivery Date -->
            <div>
                <label for="delivery_date" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="bi bi-calendar-check mr-2 text-indigo-600"></i>Delivery Date
                </label>
                <input type="date" 
                       name="delivery_date" 
                       id="delivery_date" 
                       value="{{ old('delivery_date', $order->delivery_date) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none @error('delivery_date') border-red-500 @enderror">
                @error('delivery_date')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Status -->
        <div>
            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="bi bi-info-circle mr-2 text-indigo-600"></i>Status <span class="text-red-500">*</span>
            </label>
            <select name="status" 
                    id="status" 
                    required
                    class="w-full md:w-1/3 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none bg-white @error('status') border-red-500 @enderror">
                @foreach ([\App\Models\Order::STATUS_PENDING, \App\Models\Order::STATUS_IN_PROGRESS, \App\Models\Order::STATUS_COMPLETED, \App\Models\Order::STATUS_DELIVERED] as $status)
                    <option value="{{ $status }}" {{ old('status', $order->status) == $status ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <p class="mt-1 text-sm text-red-600 flex items-center">
                    <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Services Section -->
        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <label class="block text-sm font-semibold text-gray-700">
                    <i class="bi bi-list-check mr-2 text-indigo-600"></i>Services <span class="text-red-500">*</span>
                </label>
                <span class="text-xs text-gray-500">Enter quantity for each service (0 to exclude)</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 bg-white rounded-lg overflow-hidden">
                    <thead class="bg-gradient-to-r from-indigo-600 to-purple-600">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Service</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Price</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($services as $index => $service)
                            @php
                                $currentQuantity = 0;
                                foreach ($order->services as $os) {
                                    if ($os->id === $service->id) {
                                        $currentQuantity = $os->pivot->quantity;
                                        break;
                                    }
                                }
                            @endphp
                            <tr class="service-row hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <input type="hidden" name="services[{{ $index }}][service_id]" value="{{ $service->id }}">
                                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="bi bi-check-circle text-indigo-600"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $service->name }}</div>
                                            @if($service->description)
                                                <div class="text-xs text-gray-500">{{ Str::limit($service->description, 40) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="number" 
                                           name="services[{{ $index }}][quantity]" 
                                           value="{{ old('services.' . $index . '.quantity', $currentQuantity) }}" 
                                           min="0"
                                           data-price="{{ $service->price }}"
                                           class="quantity-input w-24 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none text-center"
                                           onchange="calculateTotal()">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="subtotal text-sm font-semibold text-green-600">Rp {{ number_format($currentQuantity * $service->price, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-sm font-bold text-gray-700">Total:</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span id="totalAmount" class="text-lg font-bold text-indigo-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Notes -->
        <div>
            <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="bi bi-sticky mr-2 text-indigo-600"></i>Notes
            </label>
            <textarea name="notes" 
                      id="notes" 
                      rows="3"
                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none resize-none @error('notes') border-red-500 @enderror"
                      placeholder="Add any special instructions or notes for this order...">{{ old('notes', $order->notes) }}</textarea>
            @error('notes')
                <p class="mt-1 text-sm text-red-600 flex items-center">
                    <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('orders.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition duration-200">
                <i class="bi bi-x-circle mr-2"></i>Cancel
            </a>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                <i class="bi bi-check-circle mr-2"></i>Update Order
            </button>
        </div>
    </form>

    <script>
        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.quantity-input').forEach(input => {
                const quantity = parseInt(input.value) || 0;
                const price = parseFloat(input.dataset.price) || 0;
                const subtotal = quantity * price;
                
                const row = input.closest('tr');
                const subtotalElement = row.querySelector('.subtotal');
                subtotalElement.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
                
                total += subtotal;
            });
            
            document.getElementById('totalAmount').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
        
        // Calculate on page load
        document.addEventListener('DOMContentLoaded', calculateTotal);
    </script>
@endsection