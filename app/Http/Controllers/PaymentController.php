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
    public function index(): View
    {
        $payments = Payment::with('order.customer')->latest()->paginate(10);
        return view('payments.index', compact('payments'));
    }

    public function create(Request $request): View
    {
        // Only orders without payments should be payable
        $orders = Order::doesntHave('payment')->with('customer')->get();
        
        // Pre-select order if order_id is provided in query string
        $selectedOrderId = $request->query('order_id');
        
        return view('payments.create', compact('orders', 'selectedOrderId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'method' => 'required|string|max:100',
            'reference' => 'nullable|string|max:255',
        ]);
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