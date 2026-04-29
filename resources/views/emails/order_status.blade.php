<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order #{{ $order->id }}</title>
</head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:'Segoe UI',Arial,sans-serif;color:#000;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f3f4f6;padding:20px 10px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:560px;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.06);">
                    {{-- Header --}}
                    <tr>
                        <td style="background:linear-gradient(135deg,#1B5E20,#2E7D32);padding:28px;text-align:center;">
                            <div style="display:inline-block;width:56px;height:56px;background:#FFC107;border-radius:50%;line-height:56px;font-size:30px;text-align:center;margin-bottom:10px;">🫓</div>
                            <h1 style="margin:0;color:#fff;font-size:22px;font-weight:700;">Haji Quetta Paratha</h1>
                            <div style="color:rgba(255,255,255,0.85);font-size:13px;margin-top:4px;">{{ $statusEmoji }} {{ $statusLabel }}</div>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:28px;color:#000;">
                            <p style="margin:0 0 6px 0;font-size:14px;color:#000;">Hi {{ $order->customer_name }},</p>
                            <h2 style="margin:0 0 14px 0;font-size:20px;color:#1B5E20;">Order #{{ $order->id }}</h2>
                            <p style="margin:0 0 18px 0;font-size:15px;line-height:1.55;color:#000;">{{ $mainMessage }}</p>

                            @if ($order->admin_message)
                                <div style="background:#dbeafe;border-left:4px solid #3b82f6;padding:14px;border-radius:6px;margin-bottom:18px;">
                                    <div style="font-size:11px;font-weight:700;color:#1e40af;letter-spacing:0.05em;margin-bottom:4px;">MESSAGE FROM RESTAURANT</div>
                                    <div style="color:#000;font-size:14px;">{{ $order->admin_message }}</div>
                                </div>
                            @endif

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f9fafb;border-radius:8px;padding:0;margin-bottom:18px;">
                                <tr>
                                    <td style="padding:14px;">
                                        <div style="font-size:11px;font-weight:700;color:#000;letter-spacing:0.05em;margin-bottom:8px;">YOUR ORDER</div>
                                        @php $items = is_array($order->items) ? $order->items : (json_decode($order->items, true) ?: []); @endphp
                                        @foreach ($items as $line)
                                            <table role="presentation" width="100%" style="border-collapse:collapse;font-size:14px;">
                                                <tr>
                                                    <td style="padding:4px 0;color:#000;">{{ $line['name'] ?? '' }} × {{ $line['quantity'] ?? 1 }}</td>
                                                    <td style="padding:4px 0;text-align:right;color:#000;">Rs. {{ (int) (($line['price'] ?? 0) * ($line['quantity'] ?? 1)) }}</td>
                                                </tr>
                                            </table>
                                        @endforeach
                                        <div style="border-top:1px solid #e5e7eb;margin-top:8px;padding-top:8px;display:flex;justify-content:space-between;">
                                            <table role="presentation" width="100%"><tr>
                                                <td style="font-weight:700;color:#000;font-size:15px;">Total</td>
                                                <td style="text-align:right;font-weight:700;color:#1B5E20;font-size:17px;">Rs. {{ (int) $order->total }}</td>
                                            </tr></table>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <div style="font-size:13px;color:#000;line-height:1.6;">
                                <strong>Type:</strong> {{ ucfirst($order->order_type) }}<br>
                                <strong>Phone:</strong> {{ $order->customer_phone }}<br>
                                @if ($order->customer_address)
                                    <strong>Address:</strong> {{ $order->customer_address }}<br>
                                @endif
                            </div>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background:#f9fafb;padding:18px 28px;text-align:center;font-size:12px;color:#000;border-top:1px solid #e5e7eb;">
                            <div style="margin-bottom:6px;">Need help? Call us at <a href="tel:+923127882163" style="color:#1B5E20;text-decoration:none;font-weight:600;">+92 312 7882163</a></div>
                            <div style="color:#6b7280;">Haji Quetta Paratha · New Lahore City</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
