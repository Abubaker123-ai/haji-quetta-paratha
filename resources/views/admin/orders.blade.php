@extends('admin.layout', ['title' => 'Orders'])

@push('head')
<style>
    /* === Order Card Redesign — Light Mint Theme === */
    .order-card {
        margin-bottom: 18px;
        padding: 0;
        overflow: hidden;
        position: relative;
    }
    .order-card .status-strip {
        position: absolute;
        top: 0; left: 0; bottom: 0;
        width: 4px;
    }

    /* Header */
    .oc-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        padding: 14px 20px;
        border-bottom: 1px solid #d1fae5;
    }
    .oc-header-left { display: flex; flex-direction: column; gap: 4px; min-width: 0; }
    .oc-title { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
    .oc-title .order-id {
        font-size: 17px; font-weight: 800; color: #064e3b;
        letter-spacing: -0.01em;
    }
    .oc-meta {
        display: flex; align-items: center; gap: 8px;
        font-size: 12.5px; color: #4b5563;
        font-weight: 500;
    }
    .oc-meta .clock-icon {
        display: inline-flex; align-items: center; justify-content: center;
        width: 20px; height: 20px;
        background: #ecfdf5;
        border-radius: 50%; font-size: 10px;
    }
    .oc-header-right { text-align: right; flex-shrink: 0; }
    .oc-total-label {
        font-size: 10.5px; color: #047857;
        font-weight: 700; letter-spacing: 0.08em;
        text-transform: uppercase;
    }
    .oc-total-value {
        font-size: 24px; font-weight: 800;
        color: #064e3b; margin-top: 2px;
        letter-spacing: -0.02em;
    }

    /* Sections — tighter padding */
    .oc-section { padding: 13px 20px; border-bottom: 1px solid #ecfdf5; }
    .oc-section:last-child { border-bottom: none; }
    .oc-section-title {
        display: flex; align-items: center; gap: 8px;
        font-size: 11px; font-weight: 800;
        color: #047857;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 8px;
    }
    .oc-section-title .icon { font-size: 13px; opacity: 0.95; }

    /* Customer info grid — tighter */
    .oc-customer-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }
    @media (max-width: 700px) {
        .oc-customer-grid { grid-template-columns: 1fr; gap: 8px; }
    }
    .oc-info-item {
        display: flex; align-items: flex-start; gap: 9px;
        margin-bottom: 6px;
    }
    .oc-info-item:last-child { margin-bottom: 0; }
    .oc-info-icon {
        width: 26px; height: 26px; flex-shrink: 0;
        background: #d1fae5;
        border: 1px solid #6ee7b7;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px;
        color: #064e3b;
    }
    .oc-info-content { min-width: 0; flex: 1; }
    .oc-info-label {
        font-size: 10px; color: #047857;
        font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.06em;
        line-height: 1.3;
    }
    .oc-info-value {
        font-size: 14.5px; color: #111827; font-weight: 700;
        margin-top: 1px; word-break: break-word;
        line-height: 1.35;
    }
    .oc-info-value a { color: #047857; text-decoration: none; font-weight: 700; }
    .oc-info-value a:hover { color: #064e3b; text-decoration: underline; }
    .wa-pill {
        display: inline-flex; align-items: center; gap: 4px;
        margin-left: 8px;
        background: #25D366; color: #fff !important;
        padding: 3px 10px; border-radius: 999px;
        font-size: 11px; font-weight: 700;
        text-decoration: none !important;
        box-shadow: 0 2px 8px rgba(37,211,102,0.3);
    }
    .wa-pill:hover { background: #1ebe5a; color: #fff !important; }

    /* Message boxes */
    .oc-msg-box {
        padding: 13px 16px;
        border-radius: 10px;
        line-height: 1.55;
        font-size: 14px;
    }
    .oc-msg-customer {
        background: #fef9c3;
        border: 1px solid #fde047;
        color: #713f12;
        font-weight: 500;
    }
    .oc-msg-customer strong { color: #854d0e; }
    .oc-msg-admin {
        background: #ecfdf5;
        border: 1px solid #6ee7b7;
        border-left: 4px solid #10b981;
        color: #064e3b;
        font-weight: 500;
    }
    .oc-msg-label {
        display: block;
        font-size: 10.5px; font-weight: 800;
        letter-spacing: 0.08em;
        margin-bottom: 6px;
        text-transform: uppercase;
    }

    /* Items table */
    .oc-items {
        width: 100%; border-collapse: collapse;
        background: #f0fdf4;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #d1fae5;
    }
    .oc-items thead th {
        background: #d1fae5;
        padding: 10px 14px;
        font-size: 10.5px; font-weight: 700;
        color: #065f46;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        text-align: left;
        border-bottom: 1px solid #6ee7b7;
    }
    .oc-items thead th.right { text-align: right; }
    .oc-items thead th.center { text-align: center; }
    .oc-items tbody td {
        padding: 11px 14px;
        font-size: 14px; color: #111827;
        border-bottom: 1px solid #d1fae5;
        font-weight: 500;
    }
    .oc-items tbody tr:last-child td { border-bottom: none; }
    .oc-items tbody td.right { text-align: right; font-weight: 700; }
    .oc-items tbody td.center { text-align: center; font-weight: 700; }
    .oc-items tfoot td {
        padding: 12px 14px;
        font-size: 14.5px; font-weight: 800;
        color: #064e3b;
        background: #d1fae5;
        border-top: 1px solid #6ee7b7;
    }
    .oc-items tfoot td.right { text-align: right; color: #064e3b; font-size: 16px; }

    /* Action area */
    .oc-actions {
        background: #f0fdf4;
    }
    .action-btn {
        padding: 11px 14px;
        border: none; border-radius: 10px;
        font-size: 13px; font-weight: 700;
        cursor: pointer;
        transition: all 0.18s ease;
        letter-spacing: 0.02em;
        display: inline-flex; align-items: center; justify-content: center; gap: 6px;
        font-family: inherit;
    }
    .action-btn:hover { transform: translateY(-1px); }
    .action-btn:active { transform: translateY(0); }
    .action-delete {
        background: #fee2e2;
        border: 1px solid #fca5a5;
        color: #991b1b;
    }
    .action-delete:hover {
        background: #fecaca;
        color: #7f1d1d;
        border-color: #f87171;
        box-shadow: 0 2px 10px rgba(239,68,68,0.2);
    }

    /* Status select + template */
    .oc-update-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 12px;
    }
    @media (max-width: 700px) {
        .oc-update-grid { grid-template-columns: 1fr; }
    }
    .oc-update-grid label,
    .oc-msg-textarea-label {
        display: block;
        font-size: 10.5px; font-weight: 700;
        color: #047857;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }
    .oc-select, .oc-textarea {
        width: 100%; padding: 10px 12px;
        background: #ffffff;
        border: 1.5px solid #d1fae5;
        border-radius: 8px;
        font-family: inherit; font-size: 13.5px;
        color: #111827;
        transition: all 0.18s ease;
    }
    .oc-select:focus, .oc-textarea:focus {
        outline: none;
        border-color: #10b981;
        background: #f0fdf4;
        box-shadow: 0 0 0 3px rgba(16,185,129,0.18);
    }
    .oc-select option { background: #ffffff; color: #111827; }
    .oc-textarea { resize: vertical; min-height: 60px; }

    .oc-final-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: 12px;
    }
    @media (max-width: 700px) {
        .oc-final-actions { grid-template-columns: 1fr; }
    }
    .btn-whatsapp {
        background: #25D366;
        color: #fff;
        border: none;
        padding: 12px;
        border-radius: 10px;
        font-size: 14px; font-weight: 700;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        transition: all 0.18s ease;
        box-shadow: 0 2px 10px rgba(37,211,102,0.3);
        font-family: inherit;
    }
    .btn-whatsapp:hover {
        background: #1ebe5a;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(37,211,102,0.45);
    }
    .btn-save-status {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        border: none;
        padding: 12px;
        border-radius: 10px;
        font-size: 14px; font-weight: 700;
        cursor: pointer;
        transition: all 0.18s ease;
        box-shadow: 0 2px 10px rgba(99,102,241,0.3);
        font-family: inherit;
    }
    .btn-save-status:hover {
        background: linear-gradient(135deg, #4f46e5, #4338ca);
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(99,102,241,0.45);
    }

    .empty-state {
        text-align: center;
        padding: 70px 30px;
        color: #4b5563;
    }
    .empty-state .emoji { font-size: 56px; margin-bottom: 14px; }
    .empty-state .title { font-weight: 700; font-size: 17px; color: #064e3b; margin-bottom: 4px; }
</style>
@endpush

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

            <div class="card order-card" id="order-card-{{ $order->id }}" data-name="{{ $order->customer_name }}">
                <span class="status-strip" style="background: {{ $borderColor }};"></span>

                {{-- ===== HEADER ===== --}}
                <div class="oc-header">
                    <div class="oc-header-left">
                        <div class="oc-title">
                            <span class="order-id">Order #{{ $order->id }}</span>
                            <span class="badge badge-{{ $order->status }}">{{ $order->status }}</span>
                            <span class="badge" style="background:#dbeafe;color:#1e40af;border:1px solid #93c5fd;">{{ ucfirst($order->order_type) }}</span>
                        </div>
                        <div class="oc-meta">
                            <span class="clock-icon">🕒</span>
                            <span>{{ $order->created_at->format('M d, Y · g:i A') }}</span>
                            <span style="opacity:0.5;">•</span>
                            <span>{{ $order->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="oc-header-right">
                        <div class="oc-total-label">Total</div>
                        <div class="oc-total-value">Rs. {{ (int) $order->total }}</div>
                    </div>
                </div>

                {{-- ===== CUSTOMER INFO ===== --}}
                <div class="oc-section">
                    <div class="oc-section-title"><span class="icon">👤</span> Customer Information</div>
                    <div class="oc-customer-grid">
                        {{-- LEFT: Name + Phone --}}
                        <div>
                            <div class="oc-info-item">
                                <div class="oc-info-icon">👤</div>
                                <div class="oc-info-content">
                                    <div class="oc-info-label">Name</div>
                                    <div class="oc-info-value">{{ $order->customer_name }}</div>
                                </div>
                            </div>
                            <div class="oc-info-item">
                                <div class="oc-info-icon">📞</div>
                                <div class="oc-info-content">
                                    <div class="oc-info-label">Phone</div>
                                    <div class="oc-info-value">
                                        <a href="tel:{{ $order->customer_phone }}">{{ $order->customer_phone }}</a>
                                        <a href="https://wa.me/{{ preg_replace('/^0/', '92', preg_replace('/\D/', '', $order->customer_phone)) }}"
                                           target="_blank" class="wa-pill">💬 WhatsApp</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT: Email + Address/Type --}}
                        <div>
                            @if ($order->customer_email)
                                <div class="oc-info-item">
                                    <div class="oc-info-icon">✉️</div>
                                    <div class="oc-info-content">
                                        <div class="oc-info-label">Email</div>
                                        <div class="oc-info-value">
                                            <a href="mailto:{{ $order->customer_email }}">{{ $order->customer_email }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($order->order_type === 'delivery' && $order->customer_address)
                                <div class="oc-info-item">
                                    <div class="oc-info-icon">📍</div>
                                    <div class="oc-info-content">
                                        <div class="oc-info-label">Delivery Address</div>
                                        <div class="oc-info-value">{{ $order->customer_address }}</div>
                                        @if ($order->latitude && $order->longitude)
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ $order->latitude }},{{ $order->longitude }}"
                                               target="_blank" class="btn btn-sm" style="margin-top:8px;display:inline-flex;">
                                                🗺️ Open on Maps
                                            </a>
                                        @else
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($order->customer_address) }}"
                                               target="_blank" class="btn btn-sm btn-secondary" style="margin-top:8px;display:inline-flex;">
                                                🗺️ Search Maps
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="oc-info-item">
                                    <div class="oc-info-icon">🏪</div>
                                    <div class="oc-info-content">
                                        <div class="oc-info-label">Order Type</div>
                                        <div class="oc-info-value">Pickup from restaurant</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- ===== CUSTOMER MESSAGE (Note) ===== --}}
                @if ($order->notes)
                    <div class="oc-section">
                        <div class="oc-section-title"><span class="icon">💬</span> Customer Message</div>
                        <div class="oc-msg-box oc-msg-customer">
                            <span class="oc-msg-label" style="color:#fcd34d;">📝 Note from {{ $order->customer_name }}</span>
                            {{ $order->notes }}
                        </div>
                    </div>
                @endif

                {{-- ===== ORDER ITEMS ===== --}}
                @if (!empty($items))
                    <div class="oc-section">
                        <div class="oc-section-title"><span class="icon">🍽️</span> Order Details</div>
                        <table class="oc-items">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th class="center" style="width:80px;">Qty</th>
                                    <th class="right" style="width:100px;">Price</th>
                                    <th class="right" style="width:110px;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $line)
                                    @php
                                        $price = (float) ($line['price'] ?? 0);
                                        $qty = (int) ($line['quantity'] ?? 1);
                                    @endphp
                                    <tr>
                                        <td>{{ $line['name'] ?? '?' }}</td>
                                        <td class="center">× {{ $qty }}</td>
                                        <td class="right">Rs. {{ (int) $price }}</td>
                                        <td class="right">Rs. {{ (int) ($price * $qty) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">Grand Total</td>
                                    <td class="right">Rs. {{ (int) $order->total }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @endif

                {{-- ===== ADMIN MESSAGE ===== --}}
                @if ($order->admin_message)
                    <div class="oc-section">
                        <div class="oc-section-title"><span class="icon">📤</span> Your Reply to Customer</div>
                        <div class="oc-msg-box oc-msg-admin">
                            <span class="oc-msg-label" style="color:#93c5fd;">📨 Message Sent</span>
                            {{ $order->admin_message }}
                        </div>
                    </div>
                @endif

                {{-- ===== ACTIONS ===== --}}
                <div class="oc-section oc-actions">
                    <div class="oc-section-title"><span class="icon">⚡</span> Quick Actions</div>

                    @if (!in_array($order->status, ['cancelled', 'completed']))
                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                            @csrf
                            <div class="oc-update-grid">
                                <div>
                                    <label>Update Status</label>
                                    <select name="status" class="oc-select">
                                        <option value="pending"   {{ $order->status==='pending'?'selected':'' }}>🟡 Pending — Order received</option>
                                        <option value="preparing" {{ $order->status==='preparing'?'selected':'' }}>🟠 Preparing — Cooking now</option>
                                        <option value="ready"     {{ $order->status==='ready'?'selected':'' }}>🔵 Ready — For pickup/delivery</option>
                                        <option value="completed" {{ $order->status==='completed'?'selected':'' }}>🟢 Completed — Order delivered</option>
                                        <option value="cancelled" {{ $order->status==='cancelled'?'selected':'' }}>🔴 Cancelled</option>
                                    </select>
                                </div>
                                <div>
                                    <label>Quick Message Templates</label>
                                    <select onchange="if(this.value) document.getElementById('msg-{{ $order->id }}').value=this.value; this.selectedIndex=0;" class="oc-select">
                                        <option value="">Choose a template...</option>
                                        <option value="Your order has been received and we are now preparing it. It will be ready in 15–20 minutes. Thank you!">Preparing — 15-20 min</option>
                                        <option value="Your order will be ready in 25–30 minutes. We appreciate your patience!">Preparing — 25-30 min</option>
                                        <option value="Great news! Your order is ready for pickup. Please come at your convenience.">Ready for pickup</option>
                                        <option value="Your order is on its way! Our delivery rider will arrive in 10–15 minutes.">On the way — 10-15 min</option>
                                        <option value="Your order has been delivered. We hope you enjoy your meal! Thank you for choosing Haji Quetta Paratha.">Order delivered</option>
                                        <option value="We are sorry, but one item in your order is currently unavailable. Please contact us to update your order.">Item unavailable</option>
                                        <option value="We are sorry, but we are unable to accept your order at this time. Please try again later or contact us for assistance.">Order cancelled</option>
                                    </select>
                                </div>
                            </div>

                            <label class="oc-msg-textarea-label">Message to Customer</label>
                            <textarea id="msg-{{ $order->id }}" name="admin_message" rows="2"
                                placeholder="Type your message — then click Send WhatsApp or Save..."
                                class="oc-textarea">{{ $order->admin_message }}</textarea>

                            @php
                                $waItems = collect($items)->map(fn($l) =>
                                    '• ' . ($l['name'] ?? '?') . ' x' . ($l['quantity'] ?? 1)
                                )->implode("\n");
                                $waAddress = ($order->order_type === 'delivery' && $order->customer_address)
                                    ? $order->customer_address : 'Pickup';
                            @endphp
                            <div class="oc-final-actions">
                                <button type="button"
                                    onclick="sendWhatsApp('{{ $order->customer_phone }}', '{{ $order->id }}', `{{ addslashes($waItems) }}`, '{{ (int)$order->total }}', '{{ addslashes($waAddress) }}')"
                                    class="btn-whatsapp">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="white">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                    Send on WhatsApp
                                </button>
                                <button type="submit" class="btn-save-status">
                                    💾 Save &amp; Update
                                </button>
                            </div>
                        </form>
                    @else
                        <div style="color:rgba(255,255,255,0.6);font-size:13px;margin-bottom:12px;">
                            This order is <strong style="color:#fff;text-transform:uppercase;">{{ $order->status }}</strong>. No status changes possible.
                        </div>
                    @endif

                    {{-- Delete button — always available --}}
                    <form action="{{ route('admin.orders.delete', $order->id) }}" method="POST" style="margin-top:10px;"
                          onsubmit="return confirm('Permanently delete Order #{{ $order->id }}? This cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn action-delete" style="width:100%;padding:10px;">
                            🗑️ Delete Order
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="card empty-state">
                <div class="emoji">📭</div>
                <div class="title">No orders to show</div>
                <div>New orders will appear here automatically.</div>
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
        const statusMsg = document.getElementById('msg-' + orderId).value.trim();
        if (!statusMsg) {
            alert('Please type a message first, then click Send WhatsApp.');
            return;
        }
        const card = document.getElementById('order-card-' + orderId);
        const customerName = card ? card.dataset.name : 'Customer';

        const isPickup = address === 'Pickup';
        const fullMsg =
            'Hello ' + customerName + ',\n\n'
            + statusMsg + '\n\n'
            + '📋 *Your Order Details:*\n'
            + items + '\n\n'
            + '💰 *Total:* Rs. ' + total + '\n'
            + (isPickup
                ? '🏪 *Type:* Pickup from restaurant'
                : '📍 *Delivery Address:* ' + address)
            + '\n🔖 *Order ID:* #' + orderId
            + '\n\n— Haji Quetta Paratha\n📞 0312-7882163';

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

            const badge = document.getElementById('sidebar-pending-badge');
            if (badge) badge.textContent = data.pending_count;

            document.getElementById('lastUpdate').textContent =
                'Live — last updated ' + new Date().toLocaleTimeString();

            if (data.pending_count > lastPendingCount) {
                isReloading = true;
                try { beepAudio.play(); } catch(e) {}
                setTimeout(() => window.location.reload(), 500);
            }
            lastPendingCount = data.pending_count;
        } catch (e) {
            // silent
        }
    }

    setInterval(pollOrders, 8000);
</script>
@endpush
