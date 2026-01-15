<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->invoice_number ?? $order->id }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 14px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            background: #fff;
        }

        /* Header */
        .header-table {
            width: 100%;
            margin-bottom: 40px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }

        .brand-name {
            font-size: 28px;
            font-weight: bold;
            color: #4f46e5;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            color: #ccc;
            text-align: right;
            text-transform: uppercase;
        }

        /* Details Section */
        .details-table {
            width: 100%;
            margin-bottom: 40px;
        }

        .details-box {
            vertical-align: top;
        }

        .client-label {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 5px;
        }

        .client-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
        }

        .meta-table td {
            padding: 5px 0;
            text-align: right;
        }

        .meta-label {
            color: #888;
            padding-right: 15px;
        }

        .meta-value {
            font-weight: bold;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table th {
            background-color: #f8f9fa;
            color: #555;
            font-weight: bold;
            padding: 12px 15px;
            text-align: left;
            border-bottom: 2px solid #ddd;
            font-size: 12px;
            text-transform: uppercase;
        }

        .items-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .item-name {
            font-weight: bold;
        }

        .item-desc {
            font-size: 12px;
            color: #777;
            margin-top: 4px;
        }

        /* Totals */
        .totals-table {
            width: 40%;
            margin-left: auto;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 8px 0;
            text-align: right;
        }

        .total-label {
            color: #777;
            padding-right: 20px;
        }

        .total-value {
            font-weight: bold;
            font-size: 15px;
        }

        .grand-total {
            border-top: 2px solid #4f46e5;
            padding-top: 10px !important;
        }

        .grand-total .total-value {
            font-size: 18px;
            color: #4f46e5;
        }

        /* Status Badge */
        .status {
            display: inline-block;
            margin-top: 5px;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-paid {
            background: #d1fae5;
            color: #065f46;
        }

        .status-unpaid {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-partial {
            background: #fef3c7;
            color: #92400e;
        }

        /* Footer */
        .footer {
            margin-top: 50px;
            border-top: 1px solid #eee;
            padding-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <table class="header-table">
            <tr>
                <td style="vertical-align: middle;">
                    <div class="brand-name">{{ config('app.name', 'Laundry App') }}</div>
                    <div style="color: #666; font-size: 12px; margin-top: 5px;">
                        Professional Laundry Services
                    </div>
                </td>
                <td style="text-align: right; vertical-align: middle;">
                    <div class="invoice-title">INVOICE</div>
                    <div style="color: #666; margin-top: 5px;">#{{ $order->invoice_number ?? $order->id }}</div>
                    <div class="status status-{{ $order->payment_status }}">
                        {{ ucfirst($order->payment_status) }}
                    </div>
                </td>
            </tr>
        </table>

        <!-- Details -->
        <table class="details-table">
            <tr>
                <td class="details-box" style="width: 55%;">
                    <div class="client-label">Billed To</div>
                    <div class="client-name">{{ $order->customer->name }}</div>
                    <div style="color: #555;">
                        @if($order->customer->address)
                            {{ $order->customer->address }}<br>
                        @endif
                        @if($order->customer->email)
                            {{ $order->customer->email }}<br>
                        @endif
                        @if($order->customer->phone)
                            {{ $order->customer->phone }}
                        @endif
                    </div>
                </td>
                <td class="details-box" style="width: 45%;">
                    <table class="meta-table">
                        <tr>
                            <td class="meta-label">Order Date:</td>
                            <td class="meta-value">
                                {{ $order->order_date ? date('M d, Y', strtotime($order->order_date)) : '-' }}</td>
                        </tr>
                        @if($order->delivery_date)
                            <tr>
                                <td class="meta-label">Due Date:</td>
                                <td class="meta-value">{{ date('M d, Y', strtotime($order->delivery_date)) }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td class="meta-label">Payment ID:</td>
                            <td class="meta-value">
                                @if($order->payments->isNotEmpty())
                                    {{ $order->payments->first()->id }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Items -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 45%;">Service Description</th>
                    <th class="text-center" style="width: 15%;">Qty</th>
                    <th class="text-right" style="width: 15%;">Rate</th>
                    <th class="text-right" style="width: 20%;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->services as $index => $service)
                    <tr>
                        <td style="color: #888;">{{ $index + 1 }}</td>
                        <td>
                            <div class="item-name">{{ $service->name }}</div>
                            @if($service->description)
                                <div class="item-desc">{{ $service->description }}</div>
                            @endif
                        </td>
                        <td class="text-center">{{ $service->pivot->quantity }}</td>
                        <td class="text-right">Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                        <td class="text-right">Rp
                            {{ number_format($service->price * $service->pivot->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <table class="totals-table">
            <tr>
                <td class="total-label">Subtotal:</td>
                <td class="total-value">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
            </tr>
            @if($order->total_paid > 0)
                <tr>
                    <td class="total-label">Amount Paid:</td>
                    <td class="total-value" style="color: #065f46;">(-) Rp
                        {{ number_format($order->total_paid, 0, ',', '.') }}</td>
                </tr>
            @endif
            <tr class="grand-total">
                <td class="total-label" style="padding-top: 10px; color: #333; font-weight: bold;">Amount Due:</td>
                <td class="total-value">Rp {{ number_format($order->outstanding, 0, ',', '.') }}</td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p style="margin-bottom: 5px;">Thank you for your business!</p>
            @if($order->notes)
                <p style="font-style: italic; margin-top: 10px;">Note: {{ $order->notes }}</p>
            @endif
            <p style="margin-top: 20px; font-size: 11px;">
                {{ config('app.name', 'Laundry App') }} &bull; Generated on {{ date('d M Y, H:i') }}
            </p>
        </div>
    </div>
</body>

</html>