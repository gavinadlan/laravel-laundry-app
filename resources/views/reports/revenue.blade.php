@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center mb-2">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                    <i class="bi bi-graph-up text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Revenue & Trend Report</h1>
                    <p class="text-gray-600 mt-1">View revenue trends over time</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('reports.orders') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200">
                    <i class="bi bi-arrow-left mr-2"></i>Back
                </a>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 mb-6">
        <form method="GET" action="{{ route('reports.revenue') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Period</label>
                <select name="period" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="daily" {{ request('period') == 'daily' ? 'selected' : '' }}>Daily</option>
                    <option value="monthly" {{ request('period') == 'monthly' || !request('period') ? 'selected' : '' }}>Monthly</option>
                    <option value="yearly" {{ request('period') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Months/Years</label>
                <input type="number" name="months" value="{{ request('months', 6) }}" min="1" max="24" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div class="md:col-span-3 flex items-center space-x-2">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <i class="bi bi-search mr-2"></i>Filter
                </button>
                <a href="{{ route('reports.revenue') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    <i class="bi bi-arrow-counterclockwise mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    @if($revenue->count() > 0)
        <!-- Revenue Table -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-indigo-600 to-purple-600">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                @if($period == 'daily')
                                    Date
                                @elseif($period == 'yearly')
                                    Year
                                @else
                                    Month/Year
                                @endif
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-white uppercase tracking-wider">Total Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($revenue as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($period == 'daily')
                                        <span class="text-sm font-semibold text-gray-900">{{ $item->date }}</span>
                                    @elseif($period == 'yearly')
                                        <span class="text-sm font-semibold text-gray-900">{{ $item->year }}</span>
                                    @else
                                        <span class="text-sm font-semibold text-gray-900">
                                            {{ date('F Y', mktime(0, 0, 0, $item->month, 1, $item->year)) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-green-600">
                                    Rp {{ number_format($item->total, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">TOTAL</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-green-600">
                                Rp {{ number_format($revenue->sum('total'), 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl shadow-lg p-6 border border-green-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-600">Total Revenue</p>
                        <p class="text-3xl font-bold text-green-900 mt-2">Rp {{ number_format($revenue->sum('total'), 0, ',', '.') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                        <i class="bi bi-currency-dollar text-white text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-lg p-6 border border-blue-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-600">Average Revenue</p>
                        <p class="text-3xl font-bold text-blue-900 mt-2">Rp {{ number_format($revenue->avg('total'), 0, ',', '.') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                        <i class="bi bi-graph-up text-white text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl shadow-lg p-6 border border-purple-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-purple-600">Periods</p>
                        <p class="text-3xl font-bold text-purple-900 mt-2">{{ $revenue->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                        <i class="bi bi-calendar text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-inbox text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Revenue Data Found</h3>
            <p class="text-gray-600">No revenue data matches your filter criteria.</p>
        </div>
    @endif
@endsection
