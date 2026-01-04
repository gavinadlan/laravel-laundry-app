<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with real-time statistics.
     */
    public function index(): View
    {
        // Order statistics
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', Order::STATUS_PENDING)->count();
        $inProgressOrders = Order::where('status', Order::STATUS_IN_PROGRESS)->count();
        $completedOrders = Order::where('status', Order::STATUS_COMPLETED)->count();
        $deliveredOrders = Order::where('status', Order::STATUS_DELIVERED)->count();

        // Financial statistics
        $totalRevenue = Payment::sum('amount');
        $todayRevenue = Payment::whereDate('payment_date', today())->sum('amount');
        $monthRevenue = Payment::whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount');

        // Customer statistics
        $totalCustomers = Customer::count();
        $newCustomersThisMonth = Customer::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Recent orders
        $recentOrders = Order::with('customer', 'services')
            ->latest()
            ->take(5)
            ->get();

        // Orders needing attention (pending or in_progress for more than 2 days)
        $attentionOrders = Order::whereIn('status', [Order::STATUS_PENDING, Order::STATUS_IN_PROGRESS])
            ->where('order_date', '<', now()->subDays(2))
            ->with('customer')
            ->take(5)
            ->get();

        // Top customers by order count
        $topCustomers = Customer::withCount('orders')
            ->orderByDesc('orders_count')
            ->take(5)
            ->get();

        // Popular services
        $popularServices = Service::withCount('orders')
            ->orderByDesc('orders_count')
            ->take(5)
            ->get();

        // Monthly revenue chart data (last 6 months)
        $monthlyRevenue = Payment::select(
                DB::raw('MONTH(payment_date) as month'),
                DB::raw('YEAR(payment_date) as year'),
                DB::raw('SUM(amount) as total')
            )
            ->where('payment_date', '>=', now()->subMonths(6))
            ->groupBy('month', 'year')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Orders by status for pie chart
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('dashboard.index', compact(
            'totalOrders',
            'pendingOrders',
            'inProgressOrders',
            'completedOrders',
            'deliveredOrders',
            'totalRevenue',
            'todayRevenue',
            'monthRevenue',
            'totalCustomers',
            'newCustomersThisMonth',
            'recentOrders',
            'attentionOrders',
            'topCustomers',
            'popularServices',
            'monthlyRevenue',
            'ordersByStatus'
        ));
    }
}

