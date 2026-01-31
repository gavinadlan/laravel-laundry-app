<!DOCTYPE html>
<html>

<head>
    <title>Invoice from {{ config('app.name') }}</title>
</head>

<body style="font-family: Arial, sans-serif;">
    <h2>Hello {{ $order->customer->name }},</h2>

    <p>Thank you for using our service. Attached is your invoice for Order #{{ $order->invoice_number }}.</p>

    <p><strong>Order Details:</strong></p>
    <ul>
        <li>Date: {{ $order->order_date }}</li>
        <li>Total Amount: {{ number_format($order->total_price, 0, ',', '.') }}</li>
        <li>Status: {{ ucfirst($order->payment_status) }}</li>
    </ul>

    <p>If you have any questions, please contact us.</p>

    <p>Best regards,<br>
        {{ config('app.name') }}</p>
</body>

</html>