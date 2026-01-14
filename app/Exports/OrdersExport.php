<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Order::with('customer', 'services', 'payments');

        if (isset($this->filters['date_from'])) {
            $query->where('order_date', '>=', $this->filters['date_from']);
        }
        if (isset($this->filters['date_to'])) {
            $query->where('order_date', '<=', $this->filters['date_to']);
        }
        if (isset($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Invoice Number',
            'Customer Name',
            'Customer Email',
            'Customer Phone',
            'Order Date',
            'Delivery Date',
            'Status',
            'Total Amount',
            'Total Paid',
            'Outstanding',
            'Payment Status',
            'Services',
            'Notes',
        ];
    }

    /**
     * @param Order $order
     * @return array
     */
    public function map($order): array
    {
        $services = $order->services->map(function ($service) {
            return $service->name . ' (x' . $service->pivot->quantity . ')';
        })->implode(', ');

        return [
            $order->invoice_number ?? 'N/A',
            $order->customer->name ?? 'N/A',
            $order->customer->email ?? 'N/A',
            $order->customer->phone ?? 'N/A',
            $order->order_date?->format('Y-m-d') ?? 'N/A',
            $order->delivery_date?->format('Y-m-d') ?? 'N/A',
            ucfirst($order->status),
            number_format($order->total, 2),
            number_format($order->total_paid, 2),
            number_format($order->outstanding, 2),
            ucfirst($order->payment_status),
            $services,
            $order->notes ?? '',
        ];
    }
}
