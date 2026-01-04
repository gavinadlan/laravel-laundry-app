<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Controller for managing services offered by the laundry.
 */
class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::with('category')->latest()->paginate(10);
        return view('services.index', compact('services'));
    }

    public function create(): View
    {
        $categories = ServiceCategory::where('is_active', true)->orderBy('name')->get();
        return view('services.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:service_categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'pricing_tier' => 'nullable|in:regular,express,premium',
            'duration_minutes' => 'nullable|integer|min:0',
            'is_available' => 'boolean',
        ]);

        $validated['is_available'] = $request->boolean('is_available', true);
        Service::create($validated);
        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }

    public function show(Service $service): View
    {
        $service->load('category');
        return view('services.show', compact('service'));
    }

    public function edit(Service $service): View
    {
        $categories = ServiceCategory::where('is_active', true)->orderBy('name')->get();
        return view('services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:service_categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'pricing_tier' => 'nullable|in:regular,express,premium',
            'duration_minutes' => 'nullable|integer|min:0',
            'is_available' => 'boolean',
        ]);

        $validated['is_available'] = $request->boolean('is_available', true);
        $service->update($validated);
        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }
}
