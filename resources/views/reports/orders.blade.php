@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <div class="flex items-center mb-2">
            <div
                class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                <i class="bi bi-graph-up text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Orders Report</h1>
                <p class="text-gray-600 mt-1">Overview of your business performance</p>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <form method="GET" action="{{ route('reports.orders') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            <!-- Period Select -->
            <div class="md:col-span-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Period</label>
                <select name="period" id="periodSelect"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    onchange="toggleFilters()">
                    <option value="all" {{ $period == 'all' ? 'selected' : '' }}>All Time</option>
                    <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Daily</option>
                    <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Yearly</option>
                </select>
            </div>

            <!-- Month Filter -->
            <div id="monthFilter" class="hidden md:col-span-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Month</label>
                <select name="month"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Year Filter -->
            <div id="yearFilter" class="hidden md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                <select name="year"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @foreach(range(now()->year, now()->year - 5) as $y)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date Filter -->
            <div id="dateFilter" class="hidden md:col-span-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <!-- Actions -->
            <div class="md:col-span-2 flex space-x-2">
                <button type="submit"
                    class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-sm font-medium">
                    Filter
                </button>
                <a href="{{ route('reports.orders') }}"
                    class="px-4 py-2 bg-gray-100 text-gray-700 border border-gray-200 rounded-lg hover:bg-gray-200 transition-colors shadow-sm"
                    title="Reset">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>
    </div>

    <script>
        function toggleFilters() {
            const period = document.getElementById('periodSelect').value;
            const monthDiv = document.getElementById('monthFilter');
            const yearDiv = document.getElementById('yearFilter');
            const dateDiv = document.getElementById('dateFilter');

            if (period === 'monthly') {
                monthDiv.classList.remove('hidden');
                yearDiv.classList.remove('hidden');
                dateDiv.classList.add('hidden');
            } else if (period === 'yearly') {
                monthDiv.classList.add('hidden');
                yearDiv.classList.remove('hidden');
                dateDiv.classList.add('hidden');
            } else if (period === 'daily') {
                monthDiv.classList.add('hidden');
                yearDiv.classList.add('hidden');
                dateDiv.classList.remove('hidden');
            } else {
                monthDiv.classList.add('hidden');
                yearDiv.classList.add('hidden');
                dateDiv.classList.add('hidden');
            }
        }
        // Run on load
        document.addEventListener('DOMContentLoaded', function () {
            toggleFilters();
        });
    </script>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Orders -->
        <div
            class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-6 border border-indigo-200 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-indigo-600 mb-1">Total Orders</p>
                    <p class="text-3xl font-bold text-indigo-900">{{ $totalOrders }}</p>
                </div>
                <div class="w-14 h-14 bg-indigo-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-cart text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div
            class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-600 mb-1">Total Revenue</p>
                    <p class="text-3xl font-bold text-green-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="w-14 h-14 bg-green-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-cash-stack text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Completed Orders -->
        <div
            class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-600 mb-1">Completed</p>
                    <p class="text-3xl font-bold text-emerald-900">{{ $completedOrders }}</p>
                </div>
                <div class="w-14 h-14 bg-emerald-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-check-circle text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div
            class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-6 border border-yellow-200 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-yellow-600 mb-1">Pending</p>
                    <p class="text-3xl font-bold text-yellow-900">{{ $pendingOrders }}</p>
                </div>
                <div class="w-14 h-14 bg-yellow-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-clock text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- In Progress Orders -->
        <div
            class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-600 mb-1">In Progress</p>
                    <p class="text-3xl font-bold text-blue-900">{{ $inProgressOrders }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-arrow-repeat text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Delivered Orders -->
        <div
            class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-600 mb-1">Delivered</p>
                    <p class="text-3xl font-bold text-purple-900">{{ $deliveredOrders }}</p>
                </div>
                <div class="w-14 h-14 bg-purple-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-truck text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
            <i class="bi bi-bar-chart mr-2 text-indigo-600"></i>Order Status Summary
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="text-center p-6 bg-yellow-50 rounded-xl border border-yellow-200">
                <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="bi bi-clock text-white text-xl"></i>
                </div>
                <p class="text-2xl font-bold text-yellow-900">{{ $pendingOrders }}</p>
                <p class="text-sm text-yellow-600 mt-1">Pending</p>
                @if($totalOrders > 0)
                    <p class="text-xs text-yellow-500 mt-2">{{ number_format(($pendingOrders / $totalOrders) * 100, 1) }}%</p>
                @endif
            </div>

            <div class="text-center p-6 bg-blue-50 rounded-xl border border-blue-200">
                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="bi bi-arrow-repeat text-white text-xl"></i>
                </div>
                <p class="text-2xl font-bold text-blue-900">{{ $inProgressOrders }}</p>
                <p class="text-sm text-blue-600 mt-1">In Progress</p>
                @if($totalOrders > 0)
                    <p class="text-xs text-blue-500 mt-2">{{ number_format(($inProgressOrders / $totalOrders) * 100, 1) }}%</p>
                @endif
            </div>

            <div class="text-center p-6 bg-green-50 rounded-xl border border-green-200">
                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="bi bi-check-circle text-white text-xl"></i>
                </div>
                <p class="text-2xl font-bold text-green-900">{{ $completedOrders }}</p>
                <p class="text-sm text-green-600 mt-1">Completed</p>
                @if($totalOrders > 0)
                    <p class="text-xs text-green-500 mt-2">{{ number_format(($completedOrders / $totalOrders) * 100, 1) }}%</p>
                @endif
            </div>

            <div class="text-center p-6 bg-purple-50 rounded-xl border border-purple-200">
                <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="bi bi-truck text-white text-xl"></i>
                </div>
                <p class="text-2xl font-bold text-purple-900">{{ $deliveredOrders }}</p>
                <p class="text-sm text-purple-600 mt-1">Delivered</p>
                @if($totalOrders > 0)
                    <p class="text-xs text-purple-500 mt-2">{{ number_format(($deliveredOrders / $totalOrders) * 100, 1) }}%</p>
                @endif
            </div>
        </div>
    </div>
@endsection