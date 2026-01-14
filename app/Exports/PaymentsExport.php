<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PaymentsExport implements FromCollection, WithHeadings, WithMapping
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
        $query = Payment::with('order.customer');

        if (isset($this->filters['date_from'])) {
            $query->where('payment_date', '>=', $this->filters['date_from']);
        }
        if (isset($this->filters['date_to'])) {
            $query->where('payment_date', '<=', $this->filters['date_to']);
        }
        if (isset($this->filters['method'])) {
            $query->where('method', $this->filters['method']);
        }
        if (isset($this->filters['customer_id'])) {
            $query->whereHas('order', function ($q) {
                $q->where('customer_id', $this->filters['customer_id']);
            });
        }

        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Payment Date',
            'Invoice Number',
            'Customer Name',
            'Amount',
            'Method',
            'Reference',
            'Created At',
        ];
    }

    /**
     * @param Payment $payment
     * @return array
     */
    public function map($payment): array
    {
        return [
            $payment->payment_date?->format('Y-m-d') ?? 'N/A',
            $payment->order->invoice_number ?? 'N/A',
            $payment->order->customer->name ?? 'N/A',
            number_format($payment->amount, 2),
            $payment->method_label,
            $payment->reference ?? '',
            $payment->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
