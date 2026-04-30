<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} — Haji Quetta Paratha</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"></noscript>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { min-height: 100vh; }
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            background-attachment: fixed;
            color: #e5e7eb;
            font-size: 15px;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(at 20% 10%, rgba(59,130,246,0.18) 0, transparent 50%),
                radial-gradient(at 85% 80%, rgba(99,102,241,0.15) 0, transparent 55%);
            pointer-events: none;
            z-index: 0;
        }
        td, th, p, label, .form-row label, .badge, .alert { color: #e5e7eb; }
        a { text-decoration: none; color: inherit; }
        .layout { display: flex; min-height: 100vh; position: relative; z-index: 1; }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(18px) saturate(140%);
            -webkit-backdrop-filter: blur(18px) saturate(140%);
            border-right: 1px solid rgba(255,255,255,0.08);
            color: #fff;
            padding: 24px 0;
            position: fixed; top: 0; bottom: 0; left: 0;
            box-shadow: 4px 0 24px rgba(0,0,0,0.3);
            z-index: 10;
        }
        .brand { padding: 0 22px 24px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .brand .logo {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, #FFC107, #FFB300);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 26px; margin-bottom: 12px;
            box-shadow: 0 4px 14px rgba(255,193,7,0.3);
        }
        .brand h1 { font-size: 14px; font-weight: 700; color: #fff; }
        .brand p { font-size: 11px; color: rgba(255,255,255,0.6); margin-top: 2px; }

        .nav { padding: 16px 0; }
        .nav a {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 22px; font-size: 14px; font-weight: 500;
            color: rgba(255,255,255,0.75);
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }
        .nav a:hover {
            background: rgba(255,255,255,0.06);
            color: #fff;
            border-left-color: rgba(96,165,250,0.5);
        }
        .nav a.active {
            background: linear-gradient(90deg, rgba(59,130,246,0.25), rgba(99,102,241,0.05));
            color: #fff;
            border-left: 3px solid #60a5fa;
            font-weight: 600;
        }
        .nav .icon { font-size: 18px; }
        .nav .badge-pending {
            margin-left: auto;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: #fff;
            font-size: 10px; font-weight: 700;
            padding: 2px 7px; border-radius: 10px;
            box-shadow: 0 2px 8px rgba(239,68,68,0.4);
        }
        .nav-footer { position: absolute; bottom: 16px; left: 0; right: 0; padding: 0 22px; }
        .nav-footer .user {
            padding: 12px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 10px;
            font-size: 12px;
        }
        .nav-footer .user .name { font-weight: 600; color: #fff; }
        .nav-footer .user .email { color: rgba(255,255,255,0.55); font-size: 11px; margin-top: 2px; }
        .nav-footer form { margin-top: 8px; }
        .nav-footer button {
            width: 100%; padding: 9px;
            background: rgba(239,68,68,0.15);
            color: #fca5a5;
            border: 1px solid rgba(239,68,68,0.3);
            border-radius: 8px;
            font-size: 12px; font-weight: 600;
            cursor: pointer;
            transition: all 0.18s ease;
        }
        .nav-footer button:hover {
            background: rgba(239,68,68,0.25);
            color: #fff;
            border-color: rgba(239,68,68,0.5);
        }

        /* Main */
        .main { margin-left: 240px; flex: 1; padding: 28px 32px; min-width: 0; }
        .page-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .page-head h2 { font-size: 24px; font-weight: 800; color: #fff; letter-spacing: -0.02em; }
        .page-head .sub { color: rgba(255,255,255,0.6); font-size: 13px; margin-top: 4px; }

        /* Buttons */
        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 10px 18px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff; border: none; border-radius: 10px;
            font-size: 13px; font-weight: 600;
            cursor: pointer;
            transition: all 0.18s ease;
            box-shadow: 0 2px 8px rgba(59,130,246,0.25);
        }
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(59,130,246,0.4);
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
        }
        .btn:active { transform: translateY(0); }
        .btn-secondary {
            background: rgba(255,255,255,0.08);
            color: #e5e7eb;
            border: 1px solid rgba(255,255,255,0.18);
            box-shadow: none;
        }
        .btn-secondary:hover {
            background: rgba(255,255,255,0.15);
            color: #fff;
            border-color: rgba(255,255,255,0.3);
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            box-shadow: 0 2px 8px rgba(239,68,68,0.3);
        }
        .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            box-shadow: 0 4px 14px rgba(239,68,68,0.45);
        }
        .btn-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            box-shadow: 0 2px 8px rgba(245,158,11,0.3);
        }
        .btn-warning:hover { background: linear-gradient(135deg, #d97706, #b45309); }
        .btn-sm { padding: 7px 13px; font-size: 12px; }

        /* Alerts */
        .alert {
            padding: 13px 16px; border-radius: 10px; margin-bottom: 18px;
            font-size: 14px; font-weight: 500;
            backdrop-filter: blur(8px);
        }
        .alert-ok {
            background: rgba(16,185,129,0.15);
            color: #6ee7b7;
            border: 1px solid rgba(16,185,129,0.3);
        }
        .alert-err {
            background: rgba(239,68,68,0.15);
            color: #fca5a5;
            border: 1px solid rgba(239,68,68,0.3);
        }

        /* Glass Cards */
        .card {
            background: rgba(255,255,255,0.06);
            backdrop-filter: blur(14px) saturate(160%);
            -webkit-backdrop-filter: blur(14px) saturate(160%);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18), inset 0 1px 0 rgba(255,255,255,0.06);
            padding: 24px;
            color: #e5e7eb;
        }

        /* Stats */
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 28px; }
        .stat {
            background: rgba(255,255,255,0.06);
            backdrop-filter: blur(14px) saturate(160%);
            -webkit-backdrop-filter: blur(14px) saturate(160%);
            border: 1px solid rgba(255,255,255,0.1);
            padding: 22px;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15), inset 0 1px 0 rgba(255,255,255,0.06);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 36px rgba(0,0,0,0.25), inset 0 1px 0 rgba(255,255,255,0.1);
            border-color: rgba(96,165,250,0.3);
        }
        .stat .label {
            font-size: 11px; color: rgba(255,255,255,0.6);
            font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .stat .value {
            font-size: 32px; font-weight: 800;
            background: linear-gradient(135deg, #fff, #c7d2fe);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-top: 8px;
            letter-spacing: -0.02em;
        }
        .stat .accent { color: #fbbf24; -webkit-text-fill-color: #fbbf24; }

        /* Table */
        table { width: 100%; border-collapse: collapse; }
        th {
            text-align: left; font-size: 11px; font-weight: 700;
            color: rgba(255,255,255,0.7);
            padding: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            background: rgba(255,255,255,0.03);
        }
        td {
            padding: 14px 12px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            font-size: 14px; vertical-align: middle;
            color: #e5e7eb;
        }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(255,255,255,0.04); }

        /* Badges */
        .badge {
            display: inline-block; padding: 4px 11px;
            border-radius: 12px; font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.05em;
        }
        .badge-pending { background: rgba(251,191,36,0.18); color: #fcd34d; border: 1px solid rgba(251,191,36,0.3); }
        .badge-preparing { background: rgba(249,115,22,0.18); color: #fdba74; border: 1px solid rgba(249,115,22,0.3); }
        .badge-ready { background: rgba(59,130,246,0.18); color: #93c5fd; border: 1px solid rgba(59,130,246,0.3); }
        .badge-completed { background: rgba(16,185,129,0.18); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.3); }
        .badge-cancelled { background: rgba(239,68,68,0.18); color: #fca5a5; border: 1px solid rgba(239,68,68,0.3); }
        .badge-available { background: rgba(16,185,129,0.18); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.3); }
        .badge-out { background: rgba(239,68,68,0.18); color: #fca5a5; border: 1px solid rgba(239,68,68,0.3); }

        .item-img {
            width: 48px; height: 48px;
            border-radius: 10px;
            object-fit: cover;
            background: rgba(255,255,255,0.06);
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            border: 1px solid rgba(255,255,255,0.1);
        }

        /* Modal */
        .modal-bg {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(6px);
            z-index: 100; align-items: center; justify-content: center;
        }
        .modal-bg.show { display: flex; }
        .modal {
            background: linear-gradient(135deg, rgba(15,23,42,0.95), rgba(30,58,138,0.92));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.12);
            padding: 26px;
            border-radius: 16px;
            max-width: 500px;
            width: 92%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            color: #e5e7eb;
        }
        .modal h3 { margin-bottom: 18px; font-size: 19px; font-weight: 700; color: #fff; }

        /* Forms */
        .form-row { margin-bottom: 14px; }
        .form-row label {
            display: block; font-size: 12px; font-weight: 600;
            color: rgba(255,255,255,0.75);
            margin-bottom: 6px;
        }
        .form-row input, .form-row textarea, .form-row select {
            width: 100%; padding: 11px 13px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 8px;
            font-family: inherit; font-size: 14px;
            color: #fff;
            transition: all 0.18s ease;
        }
        .form-row input::placeholder, .form-row textarea::placeholder { color: rgba(255,255,255,0.4); }
        .form-row input:focus, .form-row textarea:focus, .form-row select:focus {
            outline: none;
            border-color: #60a5fa;
            background: rgba(255,255,255,0.1);
            box-shadow: 0 0 0 3px rgba(96,165,250,0.2);
        }
        .form-row select option { background: #0f172a; color: #fff; }
        .form-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 18px; }

        /* Filter tabs */
        .filter-tabs { display: flex; gap: 8px; margin-bottom: 18px; flex-wrap: wrap; }
        .filter-tabs a {
            padding: 8px 16px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 10px;
            font-size: 13px; font-weight: 500;
            color: rgba(255,255,255,0.75);
            transition: all 0.18s ease;
        }
        .filter-tabs a:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border-color: rgba(255,255,255,0.2);
        }
        .filter-tabs a.active {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 4px 14px rgba(59,130,246,0.35);
        }

        .live-dot {
            display: inline-block; width: 8px; height: 8px;
            background: #10b981; border-radius: 50%;
            margin-right: 6px;
            box-shadow: 0 0 8px rgba(16,185,129,0.6);
            animation: pulse 2s infinite;
        }
        @keyframes pulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(0.85); } }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 10px; height: 10px; }
        ::-webkit-scrollbar-track { background: rgba(15,23,42,0.5); }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 5px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.25); }

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
                    <span class="icon">⭐</span><span>Feedback</span>
                </a>
                <a href="{{ route('admin.shop') }}" class="{{ $route === 'admin.shop' ? 'active' : '' }}">
                    @php $shopOpen = \App\Models\ShopSetting::instance()->effectivelyOpen(); @endphp
                    <span class="icon">{{ $shopOpen ? '🟢' : '🔴' }}</span><span>Shop Control</span>
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
