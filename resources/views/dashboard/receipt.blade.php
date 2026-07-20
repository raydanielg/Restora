<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt {{ $order->order_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Courier New', monospace; font-size: 12px; color: #000; background: #f5f5f5; display: flex; justify-content: center; padding: 20px; }
        .receipt { background: white; width: 300px; padding: 20px 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .lg { font-size: 15px; }
        .sm { font-size: 10px; color: #555; }
        .divider { border-top: 1px dashed #999; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 2px 0; vertical-align: top; }
        .right { text-align: right; }
        .totals td { padding: 1px 0; }
        @media print {
            body { background: white; padding: 0; }
            .receipt { box-shadow: none; width: 100%; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
<div class="receipt">
    <div class="center">
        <div class="bold lg">{{ $order->restaurant->name }}</div>
        <div class="sm">{{ $order->restaurant->address }}</div>
        <div class="sm">Tel: {{ $order->restaurant->phone }}</div>
        @if($order->restaurant->tin_number)
        <div class="sm">TIN: {{ $order->restaurant->tin_number }}</div>
        @endif
    </div>

    <div class="divider"></div>

    <table>
        <tr><td>Receipt:</td><td class="right bold">{{ $order->order_number }}</td></tr>
        <tr><td>Date:</td><td class="right">{{ now()->format('d/m/Y H:i') }}</td></tr>
        @if($order->table)
        <tr><td>Table:</td><td class="right">{{ $order->table->table_number }}</td></tr>
        @endif
        @if($order->customer_name && $order->customer_name !== 'Guest')
        <tr><td>Customer:</td><td class="right">{{ $order->customer_name }}</td></tr>
        @endif
    </table>

    <div class="divider"></div>

    <table>
        @foreach($order->items as $item)
        <tr>
            <td>{{ $item->quantity }}x {{ $item->menu_item_name }}</td>
            <td class="right">{{ number_format($item->price * $item->quantity) }}</td>
        </tr>
        @endforeach
    </table>

    <div class="divider"></div>

    <table class="totals">
        <tr><td>Subtotal</td><td class="right">{{ number_format($order->subtotal) }}</td></tr>
        <tr><td>Tax</td><td class="right">{{ number_format($order->tax_amount) }}</td></tr>
        @if($order->service_charge > 0)
        <tr><td>Service Charge</td><td class="right">{{ number_format($order->service_charge) }}</td></tr>
        @endif
        <tr class="bold lg"><td>TOTAL</td><td class="right">{{ $order->restaurant->currency }} {{ number_format($order->total) }}</td></tr>
    </table>

    @if($order->payments->where('status', 'confirmed')->isNotEmpty())
    <div class="divider"></div>
    <table>
        @foreach($order->payments->where('status', 'confirmed') as $payment)
        <tr>
            <td>Paid ({{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }})</td>
            <td class="right">{{ number_format($payment->amount) }}</td>
        </tr>
        @endforeach
    </table>
    @endif

    <div class="divider"></div>

    <div class="center sm">
        <p>Thank you for dining with us!</p>
        <p style="margin-top: 6px;">Powered by Restora OS</p>
    </div>

    <div class="no-print center" style="margin-top: 16px;">
        <button onclick="window.print()" style="padding: 8px 24px; background: #024938; color: white; border: none; border-radius: 6px; font-family: sans-serif; font-weight: bold; cursor: pointer;">Print Receipt</button>
    </div>
</div>
</body>
</html>
