<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Controller for managing orders. Handles creation of orders with associated
 * services and customers.
 */
class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with('customer', 'services', 'payments');

        // Search by customer name or invoice number
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            // This will be handled after loading
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('order_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('order_date', '<=', $request->date_to);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        $orders = $query->paginate(15)->withQueryString();

        // Filter by payment status if needed (after loading)
        if ($request->filled('payment_status')) {
            $orders->getCollection()->transform(function ($order) use ($request) {
                if ($order->payment_status !== $request->payment_status) {
                    return null;
                }
                return $order;
            })->filter();
        }

        return view('orders.index', compact('orders'));
    }

    public function create(): View
    {
        $customers = Customer::all();
        $services = Service::all();
        return view('orders.create', compact('customers', 'services'));
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate basic order fields
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'delivery_date' => 'nullable|date|after_or_equal:order_date',
            'status' => 'required|string',
            'notes' => 'nullable|string',
            'services' => 'required|array',
            'services.*.service_id' => 'required|exists:services,id',
            'services.*.quantity' => 'nullable|integer|min:0',
        ]);

        // Create order record
        $order = Order::create([
            'customer_id' => $validated['customer_id'],
            'order_date' => $validated['order_date'],
            'delivery_date' => $validated['delivery_date'] ?? null,
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Filter out services with zero quantity and attach with quantities
        $serviceData = [];
        foreach ($validated['services'] as $serviceItem) {
            $qty = $serviceItem['quantity'] ?? 0;
            if ($qty > 0) {
                $serviceData[$serviceItem['service_id']] = ['quantity' => $qty];
            }
        }
        if (!empty($serviceData)) {
            $order->services()->attach($serviceData);
        }

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order): View
    {
        $order->load('customer', 'services', 'payments');
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order): View
    {
        $customers = Customer::all();
        $services = Service::all();
        $order->load('services');
        return view('orders.edit', compact('order', 'customers', 'services'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        // Validate
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'delivery_date' => 'nullable|date|after_or_equal:order_date',
            'status' => 'required|string',
            'notes' => 'nullable|string',
            'services' => 'required|array',
            'services.*.service_id' => 'required|exists:services,id',
            'services.*.quantity' => 'nullable|integer|min:0',
        ]);

        $order->update([
            'customer_id' => $validated['customer_id'],
            'order_date' => $validated['order_date'],
            'delivery_date' => $validated['delivery_date'] ?? null,
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Sync services with new quantities (exclude zero quantities)
        $serviceData = [];
        foreach ($validated['services'] as $serviceItem) {
            $qty = $serviceItem['quantity'] ?? 0;
            if ($qty > 0) {
                $serviceData[$serviceItem['service_id']] = ['quantity' => $qty];
            }
        }
        $order->services()->sync($serviceData);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}