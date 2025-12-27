@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 mb-2 flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                    <i class="bi bi-people text-white text-lg"></i>
                </div>
                Customers
            </h1>
            <p class="text-gray-600 mt-1">Manage your customer database</p>
        </div>
        <a href="{{ route('customers.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
            <i class="bi bi-plus-circle mr-2 text-lg"></i>
            New Customer
        </a>
    </div>
    
    @if($customers->count() > 0)
        <!-- Stats Card -->
        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl p-6 border border-indigo-100 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-indigo-600">Total Customers</p>
                    <p class="text-3xl font-bold text-indigo-900 mt-1">{{ $customers->total() }}</p>
                </div>
                <div class="w-16 h-16 bg-indigo-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-people-fill text-white text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-indigo-600 to-purple-600">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-person mr-2"></i>Name
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-envelope mr-2"></i>Email
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-telephone mr-2"></i>Phone
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-geo-alt mr-2"></i>Address
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-gear mr-2"></i>Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($customers as $customer)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="bi bi-person-fill text-indigo-600"></i>
                                    </div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $customer->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($customer->email)
                                    <div class="flex items-center text-sm text-gray-900">
                                        <i class="bi bi-envelope text-gray-400 mr-2"></i>
                                        {{ $customer->email }}
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($customer->phone)
                                    <div class="flex items-center text-sm text-gray-900">
                                        <i class="bi bi-telephone text-gray-400 mr-2"></i>
                                        {{ $customer->phone }}
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($customer->address)
                                    <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $customer->address }}">
                                        <i class="bi bi-geo-alt text-gray-400 mr-2"></i>
                                        {{ $customer->address }}
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('customers.show', $customer) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('customers.edit', $customer) }}" class="inline-flex items-center px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors duration-200" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this customer?')" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors duration-200" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $customers->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="bi bi-people text-5xl text-indigo-500"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">No customers yet</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">Get started by adding your first customer. They'll be able to place orders once added!</p>
            <a href="{{ route('customers.create') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                <i class="bi bi-plus-circle mr-2 text-xl"></i>
                Add First Customer
            </a>
        </div>
    @endif
@endsection