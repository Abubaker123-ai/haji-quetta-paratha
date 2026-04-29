@extends('admin.layout', ['title' => 'Orders'])

@section('content')
    <div class="page-head">
        <div>
            <h2>Orders</h2>
            <div class="sub"><span class="live-dot"></span><span id="lastUpdate">Live — auto-refreshing every 10s</span></div>
        </div>
        <button class="btn btn-secondary" onclick="window.location.reload()">↻ Refresh</button>
    </div>

    <div class="filter-tabs">
        <a href="{{ route('admin.orders') }}" class="{{ $filter === 'all' ? 'active' : '' }}">All</a>
        <a href="{{ route('admin.orders', ['filter' => 'pending']) }}" class="{{ $filter === 'pending' ? 'active' : '' }}">Pending</a>
        <a href="{{ route('admin.orders', ['filter' => 'preparing']) }}" class="{{ $filter === 'preparing' ? 'active' : '' }}">Preparing</a>
        <a href="{{ route('admin.orders', ['filter' => 'ready']) }}" class="{{ $filter === 'ready' ? 'active' : '' }}">Ready</a>
        <a href="{{ route('admin.orders', ['filter' => 'completed']) }}" class="{{ $filter === 'completed' ? 'active' : '' }}">Completed</a>
        <a href="{{ route('admin.orders', ['filter' => 'cancelled']) }}" class="{{ $filter === 'cancelled' ? 'active' : '' }}">Cancelled</a>
    </div>

    <div id="ordersList">
        @forelse ($orders as $order)
            @php
                $borderColor = match($order->status) {
                    'completed' => '#10b981',
                    'ready'     => '#3b82f6',
                    'preparing' => '#f59e0b',
                    'cancelled' => '#ef4444',
                    default     => '#eab308',
                };
                $items = is_array($order->items) ? $order->items : (json_decode($order->items, true) ?: []);
            @endphp
            <div class="card" style="margin-bottom:14px;border-left:4px solid {{ $borderColor }};">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;">
                    <div>
                        <div style="font-size:16px;font-weight:700;color:#000;">Order #{{ $order->id }}
                            <span class="badge badge-{{ $order->status }}" style="margin-left:8px;">{{ $order->status }}</span>
                            <span class="badge" style="background:#e0f2fe;color:#075985;margin-left:4px;">{{ ucfirst($order->order_type) }}</span>
                        </div>
                        <div style="font-size:12px;color:#374151;margin-top:4px;font-weight:500;">{{ $order->created_at->format('M d, Y g:i A') }} ({{ $order->created_at->diffForHumans() }})</div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:11px;color:#374151;font-weight:600;">TOTAL</div>
                        <div style="font-size:20px;font-weight:800;color:#1B5E20;">Rs. {{ (int) $order->total }}</div>
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;font-size:14px;margin-bottom:12px;padding:14px;background:#f9fafb;border-radius:8px;color:#000;">
                    <div>
                        <div style="font-weight:700;font-size:15px;color:#000;">👤 {{ $order->customer_name }}</div>
                        <a href="tel:{{ $order->customer_phone }}" style="color:#1B5E20;font-weight:700;text-decoration:none;display:inline-block;margin-top:6px;font-size:15px;">
                            📞 {{ $order->customer_phone }}
                        </a>
                        {{-- WhatsApp quick call button --}}
                        <a href="https://wa.me/{{ preg_replace('/^0/', '92', preg_replace('/\D/', '', $order->customer_phone)) }}"
                           target="_blank"
                           style="display:inline-block;margin-top:6px;margin-left:8px;background:#25D366;color:#fff;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:700;text-decoration:none;">
                            💬 WhatsApp
                        </a>
                        @if ($order->customer_email)
                            <div style="margin-top:4px;"><a href="mailto:{{ $order->customer_email }}" style="color:#1976d2;text-decoration:none;font-size:13px;font-weight:600;">✉️ {{ $order->customer_email }}</a></div>
                        @endif
                    </div>
                    @if ($order->order_type === 'delivery' && $order->customer_address)
                        <div>
                            <div style="font-weight:700;color:#000;">📍 Delivery Address</div>
                            <div style="margin-top:4px;line-height:1.5;color:#000;">{{ $order->customer_address }}</div>
                            @if ($order->latitude && $order->longitude)
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $order->latitude }},{{ $order->longitude }}" target="_blank" class="btn btn-sm" style="background:#1976d2;margin-top:8px;display:inline-block;">
                                    🗺️ Open on Google Maps
                                </a>
                            @else
                                <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($order->customer_address) }}" target="_blank" class="btn btn-sm btn-secondary" style="margin-top:8px;display:inline-block;">
                                    🗺️ Search on Maps
                                </a>
                            @endif
                        </div>
                    @endif
                    @if ($order->notes)
                        <div style="grid-column:1/-1;padding:10px;background:#fef3c7;border-radius:6px;">
                            <strong style="color:#000;">📝 Customer Note:</strong> <span style="color:#000;">{{ $order->notes }}</span>
                        </div>
                    @endif
                </div>

                @if (!empty($items))
                    <table style="margin-bottom:12px;width:100%;">
                        <tbody>
                            @foreach ($items as $line)
                                <tr>
                                    <td style="padding:6px 0;border:none;color:#000;font-weight:500;">{{ $line['name'] ?? '?' }} × {{ $line['quantity'] ?? 1 }}</td>
                                    <td style="padding:6px 0;border:none;text-align:right;color:#000;font-weight:600;">Rs. {{ (int) (($line['price'] ?? 0) * ($line['quantity'] ?? 1)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if ($order->admin_message)
                    <div style="margin-bottom:12px;padding:12px;background:#dbeafe;border-radius:8px;border-left:4px solid #3b82f6;">
                        <div style="font-size:11px;font-weight:700;color:#1e40af;letter-spacing:0.05em;margin-bottom:4px;">YOUR MESSAGE TO CUSTOMER</div>
                        <div style="color:#000;font-size:14px;font-weight:500;">{{ $order->admin_message }}</div>
                    </div>
                @endif

                @if (!in_array($order->status, ['cancelled']))
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" style="margin-top:8px;background:#f9fafb;padding:14px;border-radius:8px;">
                        @csrf
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px;">
                            <div>
                                <label style="font-size:11px;font-weight:700;color:#000;display:block;margin-bottom:4px;">UPDATE STATUS</label>
                                <select name="status" style="width:100%;padding:9px;border:1px solid #d1d5db;border-radius:6px;font-size:14px;font-weight:600;color:#000;">
                                    <option value="pending"   {{ $order->status==='pending'?'selected':'' }}>🟡 Pending — Order received</option>
                                    <option value="preparing" {{ $order->status==='preparing'?'selected':'' }}>🟠 Preparing — Cooking now</option>
                                    <option value="ready"     {{ $order->status==='ready'?'selected':'' }}>🔵 Ready — For pickup/delivery</option>
                                    <option value="completed" {{ $order->status==='completed'?'selected':'' }}>🟢 Completed — Order delivered</option>
                                    <option value="cancelled" {{ $order->status==='cancelled'?'selected':'' }}>🔴 Cancelled</option>
                                </select>
                            </div>
                            <div>
                                <label style="font-size:11px;font-weight:700;color:#000;display:block;margin-bottom:4px;">QUICK MESSAGE TEMPLATES</label>
                                <select onchange="if(this.value) document.getElementById('msg-{{ $order->id }}').value=this.value; this.selectedIndex=0;" style="width:100%;padding:9px;border:1px solid #d1d5db;border-radius:6px;font-size:13px;color:#000;">
                                    <option value="">Choose a template...</option>
                                    <option value="Aapka order 15-20 minute mein ready ho jayega. Shukriya!">Ready in 15-20 minutes (Urdu)</option>
                                    <option value="Aapka order 25-30 minute mein ready ho jayega.">Ready in 25-30 minutes (Urdu)</option>
                                    <option value="Aapka order ready hai! Kripya pickup ke liye tashreef layen.">Ready for pickup (Urdu)</option>
                                    <option value="Aapka order aa raha hai. Driver 10-15 minute mein pohonch jayega.">On the way (Urdu)</option>
                                    <option value="Your order will be ready in 15-20 minutes. Thank you!">Ready in 15-20 min (English)</option>
                                    <option value="Your order is ready! Please come for pickup.">Ready for pickup (English)</option>
                                    <option value="Your order is on the way. Driver will arrive in 10-15 minutes.">On the way (English)</option>
                                    <option value="Sorry — one item is out of stock. Please contact us.">Item out of stock</option>
                                </select>
                            </div>
                        </div>

                        <label style="font-size:11px;font-weight:700;color:#000;display:block;margin-bottom:4px;">MESSAGE TO CUSTOMER</label>
                        <textarea id="msg-{{ $order->id }}" name="admin_message" rows="2"
                            placeholder="Type your message — then click Send WhatsApp or Save..."
                            style="width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px;font-family:inherit;font-size:14px;resize:vertical;color:#000;">{{ $order->admin_message }}</textarea>

                        {{-- Two action buttons --}}
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:10px;">
                            {{-- WhatsApp Send Button --}}
                            @php
                                $waItems = collect($items)->map(fn($l) =>
                                    '• ' . ($l['name'] ?? '?') . ' x' . ($l['quantity'] ?? 1)
                                )->implode("\n");
                                $waAddress = ($order->order_type === 'delivery' && $order->customer_address)
                                    ? $order->customer_address : 'Pickup';
                            @endphp
                            <button type="button"
                                onclick="sendWhatsApp('{{ $order->customer_phone }}', '{{ $order->id }}', `{{ addslashes($waItems) }}`, '{{ (int)$order->total }}', '{{ addslashes($waAddress) }}')"
                                style="background:#25D366;color:#fff;border:none;padding:12px;border-radius:8px;font-size:14px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="white">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                Send WhatsApp
                            </button>

                            {{-- Save Status Button --}}
                            <button type="submit"
                                style="background:#1B5E20;color:#fff;border:none;padding:12px;border-radius:8px;font-size:14px;font-weight:700;cursor:pointer;">
                                💾 Save Status
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        @empty
            <div class="card" style="text-align:center;padding:50px;color:#374151;">
                <div style="font-size:50px;margin-bottom:12px;">📭</div>
                <div style="font-weight:600;font-size:16px;">No orders to show.</div>
            </div>
        @endforelse
    </div>
@endsection

@push('scripts')
<script>
    let lastPendingCount = {{ $orders->where('status', 'pending')->count() }};
    let beepAudio = new Audio('data:audio/wav;base64,UklGRl9vT19XQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQ==');
    let isReloading = false;

    function formatPkPhone(phone) {
        let clean = phone.replace(/\D/g, '');
        if (clean.startsWith('0')) clean = '92' + clean.substring(1);
        else if (!clean.startsWith('92')) clean = '92' + clean;
        return clean;
    }

    function sendWhatsApp(phone, orderId, items, total, address) {
        const customMsg = document.getElementById('msg-' + orderId).value.trim();
        if (!customMsg) {
            alert('Pehle message likho — phir WhatsApp button dabao.');
            return;
        }
        const fullMsg = customMsg
            + '\n\n━━━━━━━━━━━━━━━'
            + '\n🧾 *Order #' + orderId + ' Details*'
            + '\n' + items
            + '\n\n💰 *Total:* Rs. ' + total
            + '\n📍 *' + (address === 'Pickup' ? 'Pickup' : 'Address') + ':* ' + address
            + '\n━━━━━━━━━━━━━━━'
            + '\n\n— Haji Quetta Paratha';
        const intlPhone = formatPkPhone(phone);
        const url = 'https://wa.me/' + intlPhone + '?text=' + encodeURIComponent(fullMsg);
        window.open(url, '_blank');
    }

    async function pollOrders() {
        if (isReloading) return;
        try {
            const res = await fetch('{{ route('admin.orders.json', ['filter' => $filter]) }}', {
                headers: { 'Accept': 'application/json', 'Cache-Control': 'no-cache' }
            });
            if (!res.ok) return;
            const data = await res.json();

            // Update sidebar badge instantly
            const badge = document.getElementById('sidebar-pending-badge');
            if (badge) badge.textContent = data.pending_count;

            document.getElementById('lastUpdate').textContent =
                'Live — last updated ' + new Date().toLocaleTimeString();

            // New pending orders: reload once
            if (data.pending_count > lastPendingCount) {
                isReloading = true;
                try { beepAudio.play(); } catch(e) {}
                setTimeout(() => window.location.reload(), 500);
            }
            lastPendingCount = data.pending_count;
        } catch (e) {
            // silent fail — network issue
        }
    }

    // Poll every 8 seconds (slightly faster)
    setInterval(pollOrders, 8000);
</script>
@endpush
