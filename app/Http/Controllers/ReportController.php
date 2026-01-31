<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;
use App\Exports\PaymentsExport;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * Generates simple reports such as order and revenue summaries.
 */
class ReportController extends Controller
{
    /**
     * Display a summary of orders and revenue.
     */
    public function orders(Request $request): View
    {
        $period = $request->get('period', 'all'); // all, daily, monthly, yearly
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $query = Order::query();
        $paymentQuery = Payment::query();

        // Apply date filters
        if ($period === 'daily' || $dateFrom) {
            $date = $dateFrom ?: today()->toDateString();
            $query->whereDate('order_date', $date);
            $paymentQuery->whereDate('payment_date', $date);
        } elseif ($period === 'monthly') {
            $month = $request->get('month', now()->month);
            $year = $request->get('year', now()->year);
            $query->whereMonth('order_date', $month)->whereYear('order_date', $year);
            $paymentQuery->whereMonth('payment_date', $month)->whereYear('payment_date', $year);
        } elseif ($period === 'yearly') {
            $year = $request->get('year', now()->year);
            $query->whereYear('order_date', $year);
            $paymentQuery->whereYear('payment_date', $year);
        }

        if ($dateFrom && $dateTo) {
            $query->whereBetween('order_date', [$dateFrom, $dateTo]);
            $paymentQuery->whereBetween('payment_date', [$dateFrom, $dateTo]);
        }

        $totalOrders = $query->count();
        $completedOrders = (clone $query)->where('status', Order::STATUS_COMPLETED)->count();
        $inProgressOrders = (clone $query)->where('status', Order::STATUS_IN_PROGRESS)->count();
        $pendingOrders = (clone $query)->where('status', Order::STATUS_PENDING)->count();
        $deliveredOrders = (clone $query)->where('status', Order::STATUS_DELIVERED)->count();

        $totalRevenue = $paymentQuery->sum('amount');

        return view('reports.orders', [
            'totalOrders' => $totalOrders,
            'completedOrders' => $completedOrders,
            'inProgressOrders' => $inProgressOrders,
            'pendingOrders' => $pendingOrders,
            'deliveredOrders' => $deliveredOrders,
            'totalRevenue' => $totalRevenue,
            'period' => $period,
            'month' => $request->get('month', now()->month),
            'year' => $request->get('year', now()->year),
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }

    /**
     * Display report per customer.
     */
    public function perCustomer(Request $request): View
    {
        $customerId = $request->get('customer_id');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $query = Order::with('customer', 'services', 'payments');

        if ($customerId) {
            $query->where('customer_id', $customerId);
        }

        if ($dateFrom && $dateTo) {
            $query->whereBetween('order_date', [$dateFrom, $dateTo]);
        }

        $orders = $query->latest()->paginate(15);
        $customers = Customer::orderBy('name')->get();

        // Calculate totals
        $totalRevenue = Payment::whereHas('order', function ($q) use ($customerId, $dateFrom, $dateTo) {
            if ($customerId) {
                $q->where('customer_id', $customerId);
            }
            if ($dateFrom && $dateTo) {
                $q->whereBetween('order_date', [$dateFrom, $dateTo]);
            }
        })->sum('amount');

        return view('reports.per-customer', compact('orders', 'customers', 'totalRevenue', 'customerId', 'dateFrom', 'dateTo'));
    }

    /**
     * Display report per service.
     */
    public function perService(Request $request): View
    {
        $serviceId = $request->get('service_id');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $query = DB::table('order_service')
            ->join('orders', 'order_service.order_id', '=', 'orders.id')
            ->join('services', 'order_service.service_id', '=', 'services.id')
            ->select(
                'services.id',
                'services.name',
                DB::raw('SUM(order_service.quantity) as total_quantity'),
                DB::raw('SUM(order_service.quantity * services.price) as total_revenue'),
                DB::raw('COUNT(DISTINCT orders.id) as order_count')
            )
            ->groupBy('services.id', 'services.name');

        if ($serviceId) {
            $query->where('services.id', $serviceId);
        }

        if ($dateFrom && $dateTo) {
            $query->whereBetween('orders.order_date', [$dateFrom, $dateTo]);
        }

        $services = $query->get();
        $allServices = Service::orderBy('name')->get();

        return view('reports.per-service', compact('services', 'allServices', 'serviceId', 'dateFrom', 'dateTo'));
    }

    /**
     * Display revenue and trend charts.
     */
    public function revenue(Request $request): View
    {
        $period = $request->get('period', 'monthly'); // daily, monthly, yearly
        $months = $request->get('months', 6);

        if ($period === 'daily') {
            $revenue = Payment::select(
                DB::raw('DATE(payment_date) as date'),
                DB::raw('SUM(amount) as total')
            )
                ->where('payment_date', '>=', now()->subDays($months * 30))
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        } elseif ($period === 'yearly') {
            $revenue = Payment::select(
                DB::raw('YEAR(payment_date) as year'),
                DB::raw('SUM(amount) as total')
            )
                ->where('payment_date', '>=', now()->subYears($months))
                ->groupBy('year')
                ->orderBy('year')
                ->get();
        } else {
            // Monthly
            $revenue = Payment::select(
                DB::raw('MONTH(payment_date) as month'),
                DB::raw('YEAR(payment_date) as year'),
                DB::raw('SUM(amount) as total')
            )
                ->where('payment_date', '>=', now()->subMonths($months))
                ->groupBy('month', 'year')
                ->orderBy('year')
                ->orderBy('month')
                ->get();
        }

        return view('reports.revenue', compact('revenue', 'period', 'months'));
    }

    /**
     * Display accounts receivable report (outstanding payments).
     */
    public function accountsReceivable(Request $request): View
    {
        $customers = Customer::with([
            'orders' => function ($q) {
                $q->with('services', 'payments');
            }
        ])->get();

        $receivables = $customers->map(function ($customer) {
            $outstanding = $customer->orders->sum(function ($order) {
                return $order->outstanding;
            });

            return [
                'customer' => $customer,
                'outstanding' => $outstanding,
                'unpaid_orders_count' => $customer->orders->filter(fn($o) => $o->payment_status !== 'paid')->count(),
            ];
        })->filter(fn($item) => $item['outstanding'] > 0)
            ->sortByDesc('outstanding');

        $totalReceivable = $receivables->sum('outstanding');

        return view('reports.accounts-receivable', compact('receivables', 'totalReceivable'));
    }

    /**
     * Export orders to Excel.
     */
    public function exportOrders(Request $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new OrdersExport($request->all()), 'orders-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Export payments to Excel.
     */
    public function exportPayments(Request $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new PaymentsExport($request->all()), 'payments-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Export report to PDF.
     */
    public function exportPdf(Request $request): Response
    {
        $type = $request->get('type', 'orders'); // orders, payments, revenue
        $data = [];

        if ($type === 'orders') {
            $data['orders'] = Order::with('customer', 'services', 'payments')
                ->latest()
                ->take(100)
                ->get();
        } elseif ($type === 'payments') {
            $data['payments'] = Payment::with('order.customer')
                ->latest()
                ->take(100)
                ->get();
        }

        $pdf = Pdf::loadView('reports.pdf.' . $type, $data);
        return $pdf->download('report-' . $type . '-' . date('Y-m-d') . '.pdf');
    }
}