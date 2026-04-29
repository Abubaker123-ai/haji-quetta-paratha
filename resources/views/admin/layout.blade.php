<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} — Haji Quetta Paratha</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', -apple-system, sans-serif; background: #f3f4f6; color: #1f2937; }
        a { text-decoration: none; color: inherit; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 240px; background: linear-gradient(180deg, #1B5E20, #2E7D32); color: #fff; padding: 24px 0; position: fixed; top: 0; bottom: 0; left: 0; }
        .brand { padding: 0 22px 24px; border-bottom: 1px solid rgba(255,255,255,0.15); }
        .brand .logo { width: 48px; height: 48px; background: #FFC107; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 26px; margin-bottom: 12px; }
        .brand h1 { font-size: 14px; font-weight: 700; }
        .brand p { font-size: 11px; opacity: 0.7; margin-top: 2px; }
        .nav { padding: 16px 0; }
        .nav a { display: flex; align-items: center; gap: 12px; padding: 12px 22px; font-size: 14px; font-weight: 500; transition: background 0.15s; }
        .nav a:hover { background: rgba(255,255,255,0.08); }
        .nav a.active { background: rgba(255,255,255,0.15); border-left: 3px solid #FFC107; padding-left: 19px; }
        .nav .icon { font-size: 18px; }
        .nav .badge-pending { margin-left: auto; background: #ef4444; color: #fff; font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 10px; }
        .nav-footer { position: absolute; bottom: 16px; left: 0; right: 0; padding: 0 22px; }
        .nav-footer .user { padding: 12px; background: rgba(0,0,0,0.15); border-radius: 8px; font-size: 12px; }
        .nav-footer .user .name { font-weight: 600; }
        .nav-footer .user .email { opacity: 0.7; font-size: 11px; margin-top: 2px; }
        .nav-footer form { margin-top: 8px; }
        .nav-footer button { width: 100%; padding: 8px; background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.2); border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; }
        .nav-footer button:hover { background: rgba(255,255,255,0.18); }
        .main { margin-left: 240px; flex: 1; padding: 28px 32px; }
        .page-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .page-head h2 { font-size: 22px; font-weight: 700; }
        .page-head .sub { color: #6b7280; font-size: 13px; margin-top: 2px; }
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; background: #1B5E20; color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: background 0.15s; }
        .btn:hover { background: #2E7D32; }
        .btn-secondary { background: #fff; color: #1B5E20; border: 1px solid #1B5E20; }
        .btn-secondary:hover { background: #f0f9f0; }
        .btn-danger { background: #ef4444; }
        .btn-danger:hover { background: #dc2626; }
        .btn-warning { background: #f59e0b; }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 18px; font-size: 14px; font-weight: 500; }
        .alert-ok { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
        .alert-err { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
        .card { background: #fff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.03); padding: 20px; }
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 28px; }
        .stat { background: #fff; padding: 18px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .stat .label { font-size: 12px; color: #6b7280; font-weight: 500; }
        .stat .value { font-size: 28px; font-weight: 800; color: #1B5E20; margin-top: 4px; }
        .stat .accent { color: #f59e0b; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; padding: 10px 12px; border-bottom: 1px solid #e5e7eb; text-transform: uppercase; letter-spacing: 0.04em; }
        td { padding: 14px 12px; border-bottom: 1px solid #f3f4f6; font-size: 14px; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 10px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-completed { background: #d1fae5; color: #065f46; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }
        .badge-available { background: #d1fae5; color: #065f46; }
        .badge-out { background: #fee2e2; color: #991b1b; }
        .item-img { width: 48px; height: 48px; border-radius: 8px; object-fit: cover; background: #f3f4f6; display: flex; align-items: center; justify-content: center; font-size: 22px; }
        .modal-bg { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 100; align-items: center; justify-content: center; }
        .modal-bg.show { display: flex; }
        .modal { background: #fff; padding: 24px; border-radius: 12px; max-width: 500px; width: 92%; max-height: 90vh; overflow-y: auto; }
        .modal h3 { margin-bottom: 18px; font-size: 18px; font-weight: 700; }
        .form-row { margin-bottom: 14px; }
        .form-row label { display: block; font-size: 12px; font-weight: 600; color: #4b5563; margin-bottom: 5px; }
        .form-row input, .form-row textarea, .form-row select { width: 100%; padding: 9px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-family: inherit; font-size: 14px; transition: border-color 0.15s; }
        .form-row input:focus, .form-row textarea:focus, .form-row select:focus { outline: none; border-color: #1B5E20; box-shadow: 0 0 0 3px rgba(27,94,32,0.1); }
        .form-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 18px; }
        .filter-tabs { display: flex; gap: 8px; margin-bottom: 18px; }
        .filter-tabs a { padding: 7px 14px; background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 13px; font-weight: 500; color: #4b5563; }
        .filter-tabs a.active { background: #1B5E20; color: #fff; border-color: #1B5E20; }
        .live-dot { display: inline-block; width: 8px; height: 8px; background: #10b981; border-radius: 50%; margin-right: 6px; animation: pulse 2s infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }
        @media (max-width: 768px) {
            .sidebar { width: 64px; padding: 16px 0; }
            .brand { padding: 0 12px 16px; text-align: center; }
            .brand h1, .brand p, .nav a span:not(.icon), .nav-footer .user, .nav-footer button { display: none; }
            .nav a { justify-content: center; padding: 12px; }
            .main { margin-left: 64px; padding: 16px; }
        }
    </style>
    @stack('head')
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="brand">
                <div class="logo">🫓</div>
                <h1>Haji Quetta</h1>
                <p>Admin Panel</p>
            </div>
            <nav class="nav">
                @php
                    $route = request()->route()->getName();
                    $pendingCount = \App\Models\Order::where('status', 'pending')->count();
                @endphp
                <a href="{{ route('admin.dashboard') }}" class="{{ $route === 'admin.dashboard' ? 'active' : '' }}">
                    <span class="icon">📊</span><span>Dashboard</span>
                </a>
                <a href="{{ route('admin.orders') }}" class="{{ str_starts_with($route, 'admin.orders') ? 'active' : '' }}">
                    <span class="icon">📦</span><span>Orders</span>
                    @if($pendingCount > 0)
                        <span class="badge-pending" id="sidebar-pending-badge">{{ $pendingCount }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.menu') }}" class="{{ str_starts_with($route, 'admin.menu') ? 'active' : '' }}">
                    <span class="icon">🍽️</span><span>Menu</span>
                </a>
                <a href="{{ route('admin.messages') }}" class="{{ $route === 'admin.messages' ? 'active' : '' }}">
                    <span class="icon">💬</span><span>Messages</span>
                </a>
            </nav>
            <div class="nav-footer">
                <div class="user">
                    <div class="name">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div class="email">{{ auth()->user()->email ?? '' }}</div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit">Sign Out</button>
                </form>
            </div>
        </aside>
        <main class="main">
            @if (session('ok'))
                <div class="alert alert-ok">{{ session('ok') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-err">
                    @foreach ($errors->all() as $e) <div>{{ $e }}</div> @endforeach
                </div>
            @endif
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
