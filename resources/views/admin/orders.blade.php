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
                        <div style="font-size:16px;font-weight:700;">Order #{{ $order->id }}
                            <span class="badge badge-{{ $order->status }}" style="margin-left:8px;">{{ $order->status }}</span>
                            <span class="badge" style="background:#e0f2fe;color:#075985;margin-left:4px;">{{ ucfirst($order->order_type) }}</span>
                        </div>
                        <div style="font-size:12px;color:#6b7280;margin-top:4px;">{{ $order->created_at->format('M d, Y g:i A') }} ({{ $order->created_at->diffForHumans() }})</div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:11px;color:#6b7280;">TOTAL</div>
                        <div style="font-size:20px;font-weight:800;color:#1B5E20;">Rs. {{ (int) $order->total }}</div>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;font-size:14px;margin-bottom:12px;padding:14px;background:#f9fafb;border-radius:8px;color:#000;">
                    <div>
                        <div style="font-weight:700;font-size:15px;">👤 {{ $order->customer_name }}</div>
                        <a href="tel:{{ $order->customer_phone }}" style="color:#1B5E20;font-weight:600;text-decoration:none;display:inline-block;margin-top:6px;">
                            📞 {{ $order->customer_phone }}
                        </a>
                    </div>
                    @if ($order->order_type === 'delivery' && $order->customer_address)
                        <div>
                            <div style="font-weight:600;">📍 Address</div>
                            <div style="margin-top:4px;line-height:1.5;">{{ $order->customer_address }}</div>
                            @if ($order->latitude && $order->longitude)
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $order->latitude }},{{ $order->longitude }}" target="_blank" class="btn btn-sm" style="background:#1976d2;margin-top:8px;display:inline-block;">
                                    🗺️ Open on Google Maps
                                </a>
                            @else
                                <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($order->customer_address) }}" target="_blank" class="btn btn-sm btn-secondary" style="margin-top:8px;display:inline-block;">
                                    🗺️ Search Address on Maps
                                </a>
                            @endif
                        </div>
                    @endif
                    @if ($order->notes)
                        <div style="grid-column:1/-1;padding:10px;background:#fef3c7;border-radius:6px;">
                            <strong>📝 Customer Note:</strong> {{ $order->notes }}
                        </div>
                    @endif
                </div>
                @if (!empty($items))
                    <table style="margin-bottom:12px;">
                        <tbody>
                            @foreach ($items as $line)
                                <tr>
                                    <td style="padding:6px 0;border:none;">{{ $line['name'] ?? '?' }} × {{ $line['quantity'] ?? 1 }}</td>
                                    <td style="padding:6px 0;border:none;text-align:right;">Rs. {{ (int) (($line['price'] ?? 0) * ($line['quantity'] ?? 1)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                @if ($order->admin_message)
                    <div style="margin-bottom:12px;padding:12px;background:#dbeafe;border-radius:8px;border-left:4px solid #3b82f6;">
                        <div style="font-size:11px;font-weight:700;color:#1e40af;letter-spacing:0.05em;margin-bottom:4px;">YOUR MESSAGE TO CUSTOMER</div>
                        <div style="color:#000;font-size:14px;">{{ $order->admin_message }}</div>
                    </div>
                @endif
                @if (!in_array($order->status, ['cancelled']))
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" style="margin-top:8px;background:#f9fafb;padding:14px;border-radius:8px;">
                        @csrf
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px;">
                            <div>
                                <label style="font-size:11px;font-weight:700;color:#000;display:block;margin-bottom:4px;">UPDATE STATUS</label>
                                <select name="status" style="width:100%;padding:9px;border:1px solid #d1d5db;border-radius:6px;font-size:14px;font-weight:600;">
                                    <option value="pending"   {{ $order->status==='pending'?'selected':'' }}>🟡 Pending — Order received</option>
                                    <option value="preparing" {{ $order->status==='preparing'?'selected':'' }}>🟠 Preparing — Cooking now</option>
                                    <option value="ready"     {{ $order->status==='ready'?'selected':'' }}>🔵 Ready — Ready for pickup/delivery</option>
                                    <option value="completed" {{ $order->status==='completed'?'selected':'' }}>🟢 Completed — Order delivered</option>
                                    <option value="cancelled" {{ $order->status==='cancelled'?'selected':'' }}>🔴 Cancelled</option>
                                </select>
                            </div>
                            <div>
                                <label style="font-size:11px;font-weight:700;color:#000;display:block;margin-bottom:4px;">QUICK MESSAGE TEMPLATES</label>
                                <select onchange="if(this.value) document.getElementById('msg-{{ $order->id }}').value=this.value;" style="width:100%;padding:9px;border:1px solid #d1d5db;border-radius:6px;font-size:13px;">
                                    <option value="">Choose a template...</option>
                                    <option value="Your order will be ready in 15-20 minutes.">Ready in 15-20 minutes</option>
                                    <option value="Your order will be ready in 25-30 minutes.">Ready in 25-30 minutes</option>
                                    <option value="Your order is ready! Please come for pickup.">Ready for pickup</option>
                                    <option value="Your order is on the way. Driver will arrive in 10-15 minutes.">On the way (10-15 min)</option>
                                    <option value="Sorry — we are currently out of one of the items. Please contact us.">Item out of stock</option>
                                </select>
                            </div>
                        </div>
                        <label style="font-size:11px;font-weight:700;color:#000;display:block;margin-bottom:4px;">MESSAGE TO CUSTOMER (optional)</label>
                        <textarea id="msg-{{ $order->id }}" name="admin_message" rows="2" placeholder="Type a message your customer will see in the app..." style="width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px;font-family:inherit;font-size:14px;resize:vertical;">{{ $order->admin_message }}</textarea>
                        <button type="submit" class="btn" style="width:100%;margin-top:10px;padding:11px;font-size:14px;">💾 Save Status & Message</button>
                    </form>
                @endif
            </div>
        @empty
            <div class="card" style="text-align:center;padding:50px;color:#6b7280;">
                <div style="font-size:50px;margin-bottom:12px;">📭</div>
                <div>No orders to show.</div>
            </div>
        @endforelse
    </div>
@endsection

@push('scripts')
<script>
    let lastPendingCount = {{ $orders->where('status', 'pending')->count() }};
    let beepAudio = new Audio('data:audio/wav;base64,UklGRl9vT19XQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQ==');

    // Poll for new orders every 10s — reload page if pending count changes
    async function pollOrders() {
        try {
            const res = await fetch('{{ route('admin.orders.json', ['filter' => $filter]) }}', {
                headers: { 'Accept': 'application/json' }
            });
            if (!res.ok) return;
            const data = await res.json();
            const badge = document.getElementById('sidebar-pending-badge');
            if (badge) badge.textContent = data.pending_count;
            document.getElementById('lastUpdate').textContent = 'Live — last updated ' + new Date().toLocaleTimeString();

            // If new pending order detected, reload + beep
            if (data.pending_count > lastPendingCount) {
                try { beepAudio.play(); } catch(e) {}
                window.location.reload();
            }
            lastPendingCount = data.pending_count;
        } catch (e) {
            console.warn('Poll failed', e);
        }
    }
    setInterval(pollOrders, 10000);
</script>
@endpush
