@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center mb-2">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                    <i class="bi bi-list-check text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Service Details</h1>
                    <p class="text-gray-600 mt-1">View service information</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('services.edit', $service) }}" class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-700 font-semibold rounded-xl hover:bg-yellow-200 transition-colors duration-200">
                    <i class="bi bi-pencil mr-2"></i>Edit
                </a>
                <a href="{{ route('services.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200">
                    <i class="bi bi-arrow-left mr-2"></i>Back
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mr-4 shadow-lg">
                    <i class="bi bi-check-circle-fill text-indigo-600 text-3xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white">{{ $service->name }}</h2>
                    <p class="text-indigo-100 mt-1">Service Information</p>
                </div>
            </div>
        </div>
        
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
                    <div class="flex items-center mb-3">
                        <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mr-4">
                            <i class="bi bi-currency-dollar text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-green-600">Price</p>
                            <p class="text-3xl font-bold text-green-900 mt-1">
                                Rp {{ number_format($service->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                    <div class="flex items-center mb-3">
                        <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mr-4">
                            <i class="bi bi-info-circle text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-blue-600">Status</p>
                            <p class="text-xl font-bold text-blue-900 mt-1">Active</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 md:col-span-2">
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="bi bi-file-text text-indigo-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 mb-2">Description</p>
                            <p class="text-lg text-gray-900">
                                {{ $service->description ?: 'No description provided' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection