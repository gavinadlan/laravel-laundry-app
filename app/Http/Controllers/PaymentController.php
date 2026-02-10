<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

/**
 * Handles payment creation and listing.
 */
class PaymentController extends Controller
{
    public function complete(Request $request)
    {
        // Ensure Midtrans Config is set
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $midtransOrderId = $request->query('order_id');

        if (!$midtransOrderId) {
            return redirect()->route('orders.index')->with('error', 'No order ID provided.');
        }

        $order = null; // Initialize $order to null for catch block scope

        try {
            // Check transaction status from Midtrans API
            $transaction = (object) Transaction::status($midtransOrderId);
            $type = $transaction->payment_type;
            $fraud = $transaction->fraud_status;
            $status = $transaction->transaction_status;

            // Extract invoice number from midtrans order_id
            $lastDash = strrpos($midtransOrderId, '-');
            $invoiceNumber = substr($midtransOrderId, 0, $lastDash);
            $order = Order::where('invoice_number', $invoiceNumber)->first();

            if (!$order) {
                return redirect()->route('orders.index')->with('error', 'Order not found.');
            }

            // Mock request object to reuse createMidtransPayment logic
            $mockRequest = new Request([
                'transaction_id' => $transaction->transaction_id,
                'gross_amount' => $transaction->gross_amount,
                'payment_type' => $type,
            ]);

            if ($status == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        return redirect()->route('orders.show', $order)->with('warning', 'Payment is challenged. Please wait for approval.');
                    } else {
                        $this->createMidtransPayment($order, $mockRequest);
                        return redirect()->route('orders.show', $order)->with('success', 'Payment successful! (Capture)');
                    }
                }
            } else if ($status == 'settlement' || ($status == 'pending' && !config('midtrans.is_production'))) {
                // In Sandbox, we treat pending as success for easier testing if user clicks finish
                $this->createMidtransPayment($order, $mockRequest);
                return redirect()->route('orders.show', $order)->with('success', 'Payment successful! (' . ucfirst($status) . ')');
            } else if ($status == 'pending') {
                return redirect()->route('orders.show', $order)->with('info', 'Payment is pending. Please complete the payment.');
            } else {
                return redirect()->route('orders.show', $order)->with('error', 'Payment status: ' . $status);
            }

            return redirect()->route('orders.show', $order);

        } catch (\Exception $e) {
            return redirect()->route('orders.show', $order ?? 'orders.index')->with('error', 'Error checking payment status: ' . $e->getMessage());
        }
    }
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }
    public function index(Request $request): View
    {
        $query = Payment::with('order.customer');

        // Filter by customer if provided
        if ($request->filled('customer_id')) {
            $query->whereHas('order', function ($q) use ($request) {
                $q->where('customer_id', $request->input('customer_id'));
            });
        }

        // Filter by payment method
        if ($request->filled('method')) {
            $query->where('method', $request->input('method'));
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('payment_date', '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->where('payment_date', '<=', $request->input('date_to'));
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

    public function checkout(Order $order): View|RedirectResponse
    {
        if ($order->payment_status === 'paid') {
            return redirect()->route('orders.show', $order)->with('info', 'Order is already paid.');
        }

        // Create a unique order ID for Midtrans
        $midtransOrderId = $order->invoice_number . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => $midtransOrderId,
                'gross_amount' => (int) $order->outstanding,
            ],
            'customer_details' => [
                'first_name' => $order->customer->name,
                'email' => $order->customer->email,
                'phone' => $order->customer->phone,
            ],
            'enabled_payments' => ['gopay', 'shopeepay', 'bank_transfer', 'credit_card', 'qris', 'other_qris'],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return view('payments.checkout', compact('order', 'snapToken'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error generating payment token: ' . $e->getMessage());
        }
    }

    public function notification(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->input('order_id') . $request->input('status_code') . $request->input('gross_amount') . $serverKey);

        if ($hashed == $request->input('signature_key')) {
            $status = $request->input('transaction_status');
            $type = $request->input('payment_type');
            $fraud = $request->input('fraud_status');

            // Extract invoice number from midtrans order_id (INV-xxxx-timestamp)
            $midtransOrderId = $request->input('order_id');
            // Assuming invoice number format INV-YYYYMM-XXXX
            // We append -timestamp, so we can split by - and take all but last part?
            // Actually, invoice number itself has dashes.
            // Let's rely on the fact we appended '-' . time() which is -1234567890 (11 chars)
            $lastDash = strrpos($midtransOrderId, '-');
            $invoiceNumber = substr($midtransOrderId, 0, $lastDash);

            $order = Order::where('invoice_number', $invoiceNumber)->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            if ($status == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        // Handle challenge
                    } else {
                        $this->createMidtransPayment($order, $request);
                    }
                }
            } else if ($status == 'settlement') {
                $this->createMidtransPayment($order, $request);
            }

            return response()->json(['message' => 'Success']);
        }

        return response()->json(['message' => 'Invalid signature'], 403);
    }

    private function createMidtransPayment($order, $request)
    {
        // Avoid duplicate payments
        if (Payment::where('reference', $request->input('transaction_id'))->exists()) {
            return;
        }

        Payment::create([
            'order_id' => $order->id,
            'amount' => $request->input('gross_amount'),
            'payment_date' => now(),
            'method' => 'midtrans_' . $request->input('payment_type'),
            'reference' => $request->input('transaction_id'),
        ]);

        if ($order->status === Order::STATUS_PENDING) {
            $order->update(['status' => Order::STATUS_IN_PROGRESS]);
        }
    }
}