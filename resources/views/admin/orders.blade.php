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
        <a href="{{ route('admin.orders', ['filter' => 'completed']) }}" class="{{ $filter === 'completed' ? 'active' : '' }}">Completed</a>
        <a href="{{ route('admin.orders', ['filter' => 'cancelled']) }}" class="{{ $filter === 'cancelled' ? 'active' : '' }}">Cancelled</a>
    </div>

    <div id="ordersList">
        @forelse ($orders as $order)
            @php
                $borderColor = match($order->status) {
                    'completed' => '#10b981',
                    'cancelled' => '#ef4444',
                    default => '#f59e0b',
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
                @if ($order->status === 'pending')
                    <div style="display:flex;gap:8px;">
                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" style="flex:1;">
                            @csrf
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="btn" style="width:100%;">✓ Mark Complete</button>
                        </form>
                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" style="flex:1;" onsubmit="return confirm('Cancel this order?');">
                            @csrf
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="btn btn-danger" style="width:100%;">✕ Cancel</button>
                        </form>
                    </div>
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
