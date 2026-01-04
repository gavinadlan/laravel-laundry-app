@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 mb-2 flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                    <i class="bi bi-speedometer2 text-white text-lg"></i>
                </div>
                Dashboard
            </h1>
            <p class="text-gray-600 mt-1">Welcome back, {{ Auth::user()->name }}! Here's what's happening today.</p>
        </div>
        <div class="flex items-center space-x-3">
            <span class="text-sm text-gray-500">
                <i class="bi bi-calendar3 mr-1"></i>{{ now()->format('l, d M Y') }}
            </span>
        </div>
    </div>

    <!-- Stats Grid - Revenue -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Revenue -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-600 mb-1">Total Revenue</p>
                    <p class="text-2xl font-bold text-green-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-cash-stack text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-600 font-medium">
                    <i class="bi bi-arrow-up mr-1"></i>Rp {{ number_format($todayRevenue, 0, ',', '.') }}
                </span>
                <span class="text-gray-500 ml-2">today</span>
            </div>
        </div>

        <!-- Month Revenue -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-600 mb-1">This Month</p>
                    <p class="text-2xl font-bold text-blue-900">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-calendar-month text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-blue-600 font-medium">
                    <i class="bi bi-graph-up mr-1"></i>{{ $newCustomersThisMonth }} new
                </span>
                <span class="text-gray-500 ml-2">customers</span>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-6 border border-indigo-200 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-indigo-600 mb-1">Total Orders</p>
                    <p class="text-2xl font-bold text-indigo-900">{{ $totalOrders }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-cart-check text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-indigo-600 font-medium">{{ $completedOrders }}</span>
                <span class="text-gray-500 ml-2">completed</span>
            </div>
        </div>

        <!-- Total Customers -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-600 mb-1">Total Customers</p>
                    <p class="text-2xl font-bold text-purple-900">{{ $totalCustomers }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-people text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-purple-600 font-medium">
                    <i class="bi bi-person-plus mr-1"></i>{{ $newCustomersThisMonth }}
                </span>
                <span class="text-gray-500 ml-2">this month</span>
            </div>
        </div>
    </div>

    <!-- Order Status Overview -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-200 text-center">
            <div class="w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-2">
                <i class="bi bi-clock text-white"></i>
            </div>
            <p class="text-2xl font-bold text-yellow-900">{{ $pendingOrders }}</p>
            <p class="text-sm text-yellow-600">Pending</p>
        </div>
        <div class="bg-blue-50 rounded-xl p-4 border border-blue-200 text-center">
            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-2">
                <i class="bi bi-arrow-repeat text-white"></i>
            </div>
            <p class="text-2xl font-bold text-blue-900">{{ $inProgressOrders }}</p>
            <p class="text-sm text-blue-600">In Progress</p>
        </div>
        <div class="bg-green-50 rounded-xl p-4 border border-green-200 text-center">
            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-2">
                <i class="bi bi-check-circle text-white"></i>
            </div>
            <p class="text-2xl font-bold text-green-900">{{ $completedOrders }}</p>
            <p class="text-sm text-green-600">Completed</p>
        </div>
        <div class="bg-purple-50 rounded-xl p-4 border border-purple-200 text-center">
            <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-2">
                <i class="bi bi-truck text-white"></i>
            </div>
            <p class="text-2xl font-bold text-purple-900">{{ $deliveredOrders }}</p>
            <p class="text-sm text-purple-600">Delivered</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Recent Orders -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <i class="bi bi-clock-history mr-2 text-indigo-600"></i>Recent Orders
                </h2>
                <a href="{{ route('orders.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                    View All <i class="bi bi-arrow-right ml-1"></i>
                </a>
            </div>
            
            @if($recentOrders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Order</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Customer</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($recentOrders as $order)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3">
                                        <a href="{{ route('orders.show', $order) }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800">
                                            #{{ $order->id }}
                                        </a>
                                        <div class="text-xs text-gray-500">{{ $order->order_date }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $order->customer->name }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $statusConfig = [
                                                'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                                                'in_progress' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                                                'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
                                                'delivered' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800'],
                                            ];
                                            $config = $statusConfig[$order->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800'];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $config['bg'] }} {{ $config['text'] }}">
                                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-sm font-bold text-green-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-inbox text-3xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-500">No orders yet</p>
                    <a href="{{ route('orders.create') }}" class="inline-flex items-center mt-4 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                        <i class="bi bi-plus-circle mr-2"></i>Create Order
                    </a>
                </div>
            @endif
        </div>

        <!-- Orders Needing Attention -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <i class="bi bi-exclamation-triangle mr-2 text-red-600"></i>Needs Attention
                </h2>
            </div>
            
            @if($attentionOrders->count() > 0)
                <div class="space-y-3">
                    @foreach($attentionOrders as $order)
                        <a href="{{ route('orders.show', $order) }}" class="block p-4 bg-red-50 rounded-xl border border-red-100 hover:bg-red-100 transition-colors">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-sm font-bold text-indigo-600">#{{ $order->id }}</span>
                                    <span class="text-sm text-gray-600 ml-2">{{ $order->customer->name }}</span>
                                </div>
                                <span class="text-xs font-medium px-2 py-1 rounded-full 
                                    {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </div>
                            <div class="mt-2 text-xs text-gray-500">
                                <i class="bi bi-calendar mr-1"></i>{{ $order->order_date }}
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-check-circle text-3xl text-green-500"></i>
                    </div>
                    <p class="text-gray-600 font-medium">All clear!</p>
                    <p class="text-sm text-gray-500 mt-1">No orders need attention</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Bottom Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Customers -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <i class="bi bi-star-fill mr-2 text-yellow-500"></i>Top Customers
                </h2>
            </div>
            
            @if($topCustomers->count() > 0)
                <div class="space-y-3">
                    @foreach($topCustomers as $index => $customer)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-sm font-bold text-indigo-600">{{ $index + 1 }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $customer->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $customer->orders_count }} orders</p>
                                </div>
                            </div>
                            @if($index < 3)
                                <span class="text-xs font-medium px-2 py-1 rounded-full 
                                    {{ $index == 0 ? 'bg-yellow-100 text-yellow-700' : ($index == 1 ? 'bg-gray-100 text-gray-600' : 'bg-orange-100 text-orange-700') }}">
                                    @if($index == 0)<i class="bi bi-trophy-fill mr-1"></i>@endif
                                    Top {{ $index + 1 }}
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6">
                    <p class="text-gray-500">No customer data yet</p>
                </div>
            @endif
        </div>

        <!-- Popular Services -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <i class="bi bi-fire mr-2 text-orange-500"></i>Popular Services
                </h2>
            </div>
            
            @if($popularServices->count() > 0)
                <div class="space-y-3">
                    @foreach($popularServices as $index => $service)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-sm font-bold text-purple-600">{{ $index + 1 }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $service->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $service->orders_count }} orders</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-green-600">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6">
                    <p class="text-gray-500">No service data yet</p>
                </div>
            @endif
        </div>
    </div>
@endsection

