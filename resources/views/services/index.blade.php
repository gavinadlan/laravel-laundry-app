@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 mb-2 flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                    <i class="bi bi-list-check text-white text-lg"></i>
                </div>
                Services
            </h1>
            <p class="text-gray-600 mt-1">Manage your laundry service catalog</p>
        </div>
        <a href="{{ route('services.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
            <i class="bi bi-plus-circle mr-2 text-lg"></i>
            New Service
        </a>
    </div>
    
    @if($services->count() > 0)
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-600">Total Services</p>
                        <p class="text-2xl font-bold text-blue-900">{{ $services->total() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                        <i class="bi bi-list-check text-white text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-600">Average Price</p>
                        <p class="text-2xl font-bold text-green-900">
                            Rp {{ number_format($services->avg('price'), 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                        <i class="bi bi-currency-dollar text-white text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-purple-600">Highest Price</p>
                        <p class="text-2xl font-bold text-purple-900">
                            Rp {{ number_format($services->max('price'), 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                        <i class="bi bi-arrow-up-circle text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-indigo-600 to-purple-600">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-tag mr-2"></i>Service Name
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-folder mr-2"></i>Category
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-layers mr-2"></i>Tier
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-clock mr-2"></i>Duration
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-currency-dollar mr-2"></i>Price
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-gear mr-2"></i>Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($services as $service)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="bi bi-check-circle text-indigo-600"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $service->name }}</div>
                                        @if($service->description)
                                            <div class="text-xs text-gray-500 max-w-xs truncate">{{ $service->description }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($service->category)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                          style="background-color: {{ $service->category->color }}20; color: {{ $service->category->color }};">
                                        <i class="bi bi-{{ $service->category->icon ?? 'folder' }} mr-1"></i>
                                        {{ $service->category->name }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-400 italic">Uncategorized</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($service->pricing_tier == 'express') bg-blue-100 text-blue-800
                                    @elseif($service->pricing_tier == 'premium') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $service->pricing_tier_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-600">{{ $service->duration_minutes ?: '-' }} min</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <div class="text-sm font-bold text-green-600">
                                        Rp {{ number_format($service->price, 0, ',', '.') }}
                                    </div>
                                    <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded text-xs font-semibold {{ $service->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        <i class="bi bi-{{ $service->is_available ? 'check-circle' : 'x-circle' }} mr-1"></i>
                                        {{ $service->is_available ? 'Available' : 'Unavailable' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('services.show', $service) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('services.edit', $service) }}" class="inline-flex items-center px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors duration-200" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('services.destroy', $service) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this service?')" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors duration-200" title="Delete">
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
            {{ $services->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="bi bi-list-check text-5xl text-indigo-500"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">No services yet</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">Create your first service to start accepting orders. Services like washing, dry cleaning, ironing, etc.</p>
            <a href="{{ route('services.create') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                <i class="bi bi-plus-circle mr-2 text-xl"></i>
                Create First Service
            </a>
        </div>
    @endif
@endsection