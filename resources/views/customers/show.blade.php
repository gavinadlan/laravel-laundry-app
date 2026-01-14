@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center mb-2">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                    <i class="bi bi-person text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Customer Details</h1>
                    <p class="text-gray-600 mt-1">View customer information</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('customers.payments', $customer) }}" class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 font-semibold rounded-xl hover:bg-green-200 transition-colors duration-200">
                    <i class="bi bi-credit-card mr-2"></i>Payment History
                </a>
                <a href="{{ route('customers.edit', $customer) }}" class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-700 font-semibold rounded-xl hover:bg-yellow-200 transition-colors duration-200">
                    <i class="bi bi-pencil mr-2"></i>Edit
                </a>
                <a href="{{ route('customers.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200">
                    <i class="bi bi-arrow-left mr-2"></i>Back
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mr-4 shadow-lg">
                    <i class="bi bi-person-fill text-indigo-600 text-3xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white">{{ $customer->name }}</h2>
                    <p class="text-indigo-100 mt-1">Customer Information</p>
                </div>
            </div>
        </div>
        
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="bi bi-envelope text-indigo-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Email Address</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">
                                {{ $customer->email ?: '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="bi bi-telephone text-indigo-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Phone Number</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">
                                {{ $customer->phone ?: '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 md:col-span-2">
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="bi bi-geo-alt text-indigo-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 mb-2">Address</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $customer->address ?: '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection