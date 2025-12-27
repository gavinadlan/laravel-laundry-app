<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Generates simple reports such as order and revenue summaries.
 */
class ReportController extends Controller
{
    /**
     * Display a summary of orders and revenue.
     */
    public function orders(): View
    {
        $totalOrders = Order::count();
        $completedOrders = Order::where('status', Order::STATUS_COMPLETED)->count();
        $inProgressOrders = Order::where('status', Order::STATUS_IN_PROGRESS)->count();
        $pendingOrders = Order::where('status', Order::STATUS_PENDING)->count();
        $deliveredOrders = Order::where('status', Order::STATUS_DELIVERED)->count();

        $totalRevenue = Payment::sum('amount');

        return view('reports.orders', [
            'totalOrders' => $totalOrders,
            'completedOrders' => $completedOrders,
            'inProgressOrders' => $inProgressOrders,
            'pendingOrders' => $pendingOrders,
            'deliveredOrders' => $deliveredOrders,
            'totalRevenue' => $totalRevenue,
        ]);
    }
}