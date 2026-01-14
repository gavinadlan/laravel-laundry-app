<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->invoice_number ?? 'N/A' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 30px;
            border-radius: 8px 8px 0 0;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .info-box {
            width: 48%;
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        .info-box h3 {
            margin: 0 0 10px 0;
            font-size: 12px;
            text-transform: uppercase;
            color: #6b7280;
        }
        .info-box p {
            margin: 5px 0;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            background: #f3f4f6;
            padding: 10px;
            text-align: left;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            color: #6b7280;
            border-bottom: 2px solid #e5e7eb;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 12px;
        }
        .text-right {
            text-align: right;
        }
        .totals {
            width: 300px;
            margin-left: auto;
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }
        .totals-row.total {
            border-top: 2px solid #e5e7eb;
            margin-top: 10px;
            padding-top: 10px;
            font-weight: bold;
            font-size: 14px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
        }
        .status-paid {
            background: #d1fae5;
            color: #065f46;
        }
        .status-partial {
            background: #fef3c7;
            color: #92400e;
        }
        .status-unpaid {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
        <p>Invoice #{{ $order->invoice_number ?? 'N/A' }}</p>
    </div>

    <div class="info-section">
        <div class="info-box">
            <h3>Bill To</h3>
            <p><strong>{{ $order->customer->name }}</strong></p>
            @if($order->customer->email)
                <p>{{ $order->customer->email }}</p>
            @endif
            @if($order->customer->phone)
                <p>{{ $order->customer->phone }}</p>
            @endif
            @if($order->customer->address)
                <p>{{ $order->customer->address }}</p>
            @endif
        </div>
        <div class="info-box">
            <h3>Order Information</h3>
            <p><strong>Order ID:</strong> #{{ $order->id }}</p>
            <p><strong>Order Date:</strong> {{ $order->order_date ? date('M d, Y', strtotime($order->order_date)) : '-' }}</p>
            @if($order->delivery_date)
                <p><strong>Delivery Date:</strong> {{ date('M d, Y', strtotime($order->delivery_date)) }}</p>
            @endif
            <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $order->status)) }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Service</th>
                <th class="text-right">Quantity</th>
                <th class="text-right">Price</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->services as $service)
                <tr>
                    <td>
                        <strong>{{ $service->name }}</strong>
                        @if($service->description)
                            <br><small style="color: #6b7280;">{{ $service->description }}</small>
                        @endif
                    </td>
                    <td class="text-right">{{ $service->pivot->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                    <td class="text-right"><strong>Rp {{ number_format($service->price * $service->pivot->quantity, 0, ',', '.') }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if($order->payments->count() > 0)
    <h3 style="font-size: 14px; font-weight: 600; margin-bottom: 10px; color: #6b7280;">PAYMENTS</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Method</th>
                <th>Reference</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->payments as $payment)
                <tr>
                    <td>{{ $payment->payment_date ? date('M d, Y', strtotime($payment->payment_date)) : '-' }}</td>
                    <td>{{ $payment->method_label }}</td>
                    <td>{{ $payment->reference ?? '-' }}</td>
                    <td class="text-right">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="totals">
        <div class="totals-row">
            <span>Subtotal:</span>
            <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
        </div>
        <div class="totals-row">
            <span>Total Paid:</span>
            <span style="color: #059669;">Rp {{ number_format($order->total_paid, 0, ',', '.') }}</span>
        </div>
        <div class="totals-row total">
            <span>Outstanding:</span>
            <span style="color: #dc2626;">Rp {{ number_format($order->outstanding, 0, ',', '.') }}</span>
        </div>
        <div style="margin-top: 10px; text-align: center;">
            <span class="status-badge status-{{ $order->payment_status }}">
                Payment Status: {{ ucfirst($order->payment_status) }}
            </span>
        </div>
    </div>

    @if($order->notes)
    <div style="margin-top: 30px; padding: 15px; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb;">
        <h3 style="font-size: 12px; font-weight: 600; margin-bottom: 10px; color: #6b7280; text-transform: uppercase;">Notes</h3>
        <p style="margin: 0; font-size: 12px;">{{ $order->notes }}</p>
    </div>
    @endif
</body>
</html>
