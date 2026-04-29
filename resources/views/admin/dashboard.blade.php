@extends('admin.layout', ['title' => 'Dashboard'])

@section('content')
    <div class="page-head">
        <div>
            <h2>Dashboard</h2>
            <div class="sub">Overview of your restaurant operations</div>
        </div>
        <span style="font-size:12px;color:#10b981;font-weight:600;"><span class="live-dot"></span>Live</span>
    </div>

    <div class="stat-grid">
        <div class="stat">
            <div class="label">Pending Orders</div>
            <div class="value accent">{{ $stats['orders_pending'] }}</div>
        </div>
        <div class="stat">
            <div class="label">Total Orders</div>
            <div class="value">{{ $stats['orders_total'] }}</div>
        </div>
        <div class="stat">
            <div class="label">Menu Items</div>
            <div class="value">{{ $stats['menu_active'] }} / {{ $stats['menu_total'] }}</div>
            <div class="label" style="margin-top:4px;font-size:10px;">available / total</div>
        </div>
        <div class="stat">
            <div class="label">Customer Messages</div>
            <div class="value">{{ $stats['messages'] }}</div>
        </div>
    </div>

    <div class="card">
        <h3 style="font-size:15px;font-weight:700;margin-bottom:16px;">Latest Orders</h3>
        @if ($latestOrders->isEmpty())
            <p style="color:#6b7280;font-size:14px;">No orders yet.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>#</th><th>Customer</th><th>Type</th><th>Total</th><th>Status</th><th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($latestOrders as $o)
                        <tr>
                            <td><strong>#{{ $o->id }}</strong></td>
                            <td>{{ $o->customer_name }}</td>
                            <td>{{ ucfirst($o->order_type) }}</td>
                            <td>Rs. {{ (int) $o->total }}</td>
                            <td><span class="badge badge-{{ $o->status }}">{{ $o->status }}</span></td>
                            <td style="color:#6b7280;font-size:13px;">{{ $o->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="margin-top:14px;">
                <a href="{{ route('admin.orders') }}" class="btn btn-secondary btn-sm">View all orders →</a>
            </div>
        @endif
    </div>
@endsection
