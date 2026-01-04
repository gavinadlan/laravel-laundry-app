@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <div class="flex items-center mb-2">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                <i class="bi bi-plus-circle text-white text-lg"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Create New Service</h1>
        </div>
        <p class="text-gray-600">Add a new laundry service to your catalog</p>
    </div>

    <form action="{{ route('services.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Service Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="bi bi-tag mr-2 text-indigo-600"></i>Service Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name') }}" 
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none @error('name') border-red-500 @enderror"
                       placeholder="e.g., Wash & Fold, Dry Cleaning">
                @error('name')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="bi bi-folder mr-2 text-indigo-600"></i>Category
                </label>
                <select name="category_id" id="category_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none @error('category_id') border-red-500 @enderror">
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="bi bi-currency-dollar mr-2 text-indigo-600"></i>Price (Rp) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                    <input type="number" 
                           step="0.01" 
                           name="price" 
                           id="price" 
                           value="{{ old('price') }}" 
                           required
                           class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none @error('price') border-red-500 @enderror"
                           placeholder="0.00">
                </div>
                @error('price')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Pricing Tier -->
            <div>
                <label for="pricing_tier" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="bi bi-layers mr-2 text-indigo-600"></i>Pricing Tier
                </label>
                <select name="pricing_tier" id="pricing_tier"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none @error('pricing_tier') border-red-500 @enderror">
                    <option value="regular" {{ old('pricing_tier', 'regular') == 'regular' ? 'selected' : '' }}>Regular</option>
                    <option value="express" {{ old('pricing_tier') == 'express' ? 'selected' : '' }}>Express (+50%)</option>
                    <option value="premium" {{ old('pricing_tier') == 'premium' ? 'selected' : '' }}>Premium (+100%)</option>
                </select>
                @error('pricing_tier')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Duration -->
            <div>
                <label for="duration_minutes" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="bi bi-clock mr-2 text-indigo-600"></i>Duration (minutes)
                </label>
                <input type="number" 
                       name="duration_minutes" 
                       id="duration_minutes" 
                       value="{{ old('duration_minutes') }}" 
                       min="0"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none @error('duration_minutes') border-red-500 @enderror"
                       placeholder="e.g., 60">
                @error('duration_minutes')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="bi bi-file-text mr-2 text-indigo-600"></i>Description
            </label>
            <textarea name="description" 
                      id="description" 
                      rows="4"
                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none resize-none @error('description') border-red-500 @enderror"
                      placeholder="Describe the service details...">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600 flex items-center">
                    <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Status -->
        <div class="flex items-center">
            <input type="checkbox" 
                   name="is_available" 
                   id="is_available" 
                   value="1" 
                   {{ old('is_available', true) ? 'checked' : '' }}
                   class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
            <label for="is_available" class="ml-2 text-sm font-semibold text-gray-700">
                <i class="bi bi-check-circle mr-1 text-indigo-600"></i>Service is available
            </label>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('services.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition duration-200">
                <i class="bi bi-x-circle mr-2"></i>Cancel
            </a>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                <i class="bi bi-check-circle mr-2"></i>Save Service
            </button>
        </div>
    </form>
@endsection
