<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Handles payment creation and listing.
 */
class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Payment::with('order.customer');

        // Filter by customer if provided
        if ($request->filled('customer_id')) {
            $query->whereHas('order', function ($q) use ($request) {
                $q->where('customer_id', $request->customer_id);
            });
        }

        // Filter by payment method
        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('payment_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('payment_date', '<=', $request->date_to);
        }

        $payments = $query->latest()->paginate(10);
        $customers = \App\Models\Customer::orderBy('name')->get();

        return view('payments.index', compact('payments', 'customers'));
    }

    public function create(Request $request): View
    {
        // Get all orders (now supports multiple payments)
        $orders = Order::with('customer', 'payments')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Pre-select order if order_id is provided in query string
        $selectedOrderId = $request->query('order_id');
        
        return view('payments.create', compact('orders', 'selectedOrderId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'method' => 'required|string|in:cash,transfer,e_wallet,credit_card,debit_card',
            'reference' => 'nullable|string|max:255',
        ]);

        $order = Order::with('payments')->findOrFail($validated['order_id']);
        $totalPaid = $order->total_paid;
        $orderTotal = $order->total;
        $newPaymentAmount = $validated['amount'];

        // Check if payment exceeds order total
        if (($totalPaid + $newPaymentAmount) > $orderTotal) {
            return back()->withErrors([
                'amount' => 'Payment amount cannot exceed order total. Outstanding amount: ' . number_format($orderTotal - $totalPaid, 2)
            ])->withInput();
        }

        Payment::create($validated);
        
        // Redirect back to order if came from order page, otherwise to payments index
        if ($request->has('return_to_order')) {
            return redirect()->route('orders.show', $validated['order_id'])->with('success', 'Payment recorded successfully.');
        }
        
        return redirect()->route('payments.index')->with('success', 'Payment recorded successfully.');
    }

    public function show(Payment $payment): View
    {
        $payment->load('order.customer');
        return view('payments.show', compact('payment'));
    }

    public function destroy(Payment $payment): RedirectResponse
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }
}