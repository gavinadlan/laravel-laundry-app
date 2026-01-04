@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="mb-4 sm:mb-0">
            <div class="flex items-center mb-2">
                <a href="{{ route('service-categories.index') }}" class="mr-4 text-gray-500 hover:text-gray-700">
                    <i class="bi bi-arrow-left text-xl"></i>
                </a>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-4" style="background-color: {{ $category->color }}20;">
                        <i class="bi bi-{{ $category->icon ?? 'folder' }} text-2xl" style="color: {{ $category->color }};"></i>
                    </div>
                    {{ $category->name }}
                </h1>
            </div>
            <p class="text-gray-600 mt-1 ml-16">Category details and associated services</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('service-categories.edit', $category) }}" class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-700 font-medium rounded-lg hover:bg-yellow-200 transition-colors">
                <i class="bi bi-pencil mr-2"></i>Edit
            </a>
            <form action="{{ route('service-categories.destroy', $category) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure you want to delete this category?')" class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 font-medium rounded-lg hover:bg-red-200 transition-colors">
                    <i class="bi bi-trash mr-2"></i>Delete
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Category Info -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Category Information</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-sm text-gray-500">Description</label>
                        <p class="text-gray-900">{{ $category->description ?: 'No description' }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm text-gray-500">Status</label>
                        <div class="mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                <i class="bi bi-{{ $category->is_active ? 'check-circle' : 'x-circle' }} mr-1.5"></i>
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    
                    <div>
                        <label class="text-sm text-gray-500">Sort Order</label>
                        <p class="text-gray-900">{{ $category->sort_order }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm text-gray-500">Created</label>
                        <p class="text-gray-900">{{ $category->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm text-gray-500">Last Updated</label>
                        <p class="text-gray-900">{{ $category->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services in this Category -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Services in this Category</h3>
                    <span class="text-sm text-gray-500">{{ $category->services->count() }} services</span>
                </div>
                
                @if($category->services->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tier</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Duration</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($category->services as $service)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-4">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                                    <i class="bi bi-box-seam text-indigo-600"></i>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-semibold text-gray-900">{{ $service->name }}</div>
                                                    @if($service->description)
                                                        <div class="text-xs text-gray-500 truncate max-w-xs">{{ $service->description }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <span class="text-sm font-bold text-green-600">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="px-4 py-4">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $service->pricing_tier_label }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4">
                                            <span class="text-sm text-gray-600">{{ $service->duration_minutes ?: '-' }} min</span>
                                        </td>
                                        <td class="px-4 py-4">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold {{ $service->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $service->is_available ? 'Available' : 'Unavailable' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="bi bi-inbox text-3xl text-gray-400"></i>
                        </div>
                        <h4 class="text-lg font-medium text-gray-900 mb-2">No services yet</h4>
                        <p class="text-gray-500 mb-4">This category doesn't have any services assigned.</p>
                        <a href="{{ route('services.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-100 text-indigo-700 font-medium rounded-lg hover:bg-indigo-200 transition-colors">
                            <i class="bi bi-plus mr-2"></i>Add Service
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

