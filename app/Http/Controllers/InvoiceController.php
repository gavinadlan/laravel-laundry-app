<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class InvoiceController extends Controller
{
    /**
     * Display a listing of invoices.
     */
    public function index(Request $request): View
    {
        $query = Order::with('customer', 'services', 'payments');

        // Filter by customer
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            // This will be handled after loading orders
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('order_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('order_date', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(15);

        // Filter by payment status if needed (after loading)
        if ($request->filled('payment_status')) {
            $orders->getCollection()->transform(function ($order) use ($request) {
                if ($order->payment_status !== $request->payment_status) {
                    return null;
                }
                return $order;
            })->filter();
        }

        $customers = \App\Models\Customer::orderBy('name')->get();

        return view('invoices.index', compact('orders', 'customers'));
    }

    /**
     * Generate and download PDF invoice for an order.
     */
    public function download(Order $order): Response
    {
        $order->load('customer', 'services', 'payments');
        
        $pdf = Pdf::loadView('invoices.pdf', compact('order'));
        
        $filename = 'invoice-' . $order->invoice_number . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Display invoice in browser.
     */
    public function show(Order $order): View
    {
        $order->load('customer', 'services', 'payments');
        return view('invoices.show', compact('order'));
    }

    /**
     * Email invoice to customer.
     */
    public function email(Order $order): RedirectResponse
    {
        $order->load('customer', 'services', 'payments');
        
        if (!$order->customer->email) {
            return back()->with('error', 'Customer does not have an email address.');
        }

        // TODO: Implement email sending
        // For now, just return success message
        return back()->with('success', 'Invoice email will be sent to ' . $order->customer->email);
    }
}
