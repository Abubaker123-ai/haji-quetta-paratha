<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Panel — Haji Quetta Paratha</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background: #0f0f0f;
      color: #e2e2e2;
      min-height: 100vh;
    }

    .layout { display: flex; min-height: 100vh; }

    /* ── SIDEBAR ── */
    .sidebar {
      width: 230px;
      background: #161616;
      border-right: 1px solid #2a2a2a;
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0; left: 0;
      height: 100vh;
      z-index: 10;
    }

    .logo-box {
      padding: 22px 20px 18px;
      border-bottom: 1px solid #2a2a2a;
    }
    .logo-box .brand {
      font-size: 15px;
      font-weight: 700;
      color: #c9a227;
      line-height: 1.4;
    }
    .logo-box .sub {
      font-size: 10px;
      color: #555;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      margin-top: 4px;
    }

    .nav { padding: 12px 0; flex: 1; }

    .nav a {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 20px;
      color: #666;
      text-decoration: none;
      font-size: 13.5px;
      font-weight: 500;
      border-left: 3px solid transparent;
      transition: all 0.15s;
    }
    .nav a:hover { color: #ccc; background: rgba(255,255,255,0.03); }
    .nav a.active {
      color: #c9a227;
      border-left-color: #c9a227;
      background: rgba(201,162,39,0.07);
    }
    .nav a .ico { font-size: 15px; }

    .sidebar-foot {
      padding: 16px 20px;
      border-top: 1px solid #2a2a2a;
      font-size: 12px;
      color: #444;
    }
    .sidebar-foot a { color: #555; text-decoration: none; }
    .sidebar-foot a:hover { color: #c9a227; }

    /* ── MAIN ── */
    .main { margin-left: 230px; flex: 1; padding: 28px 30px; }

    /* ── TOPBAR ── */
    .topbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 24px;
    }
    .topbar h1 {
      font-size: 20px;
      font-weight: 700;
      color: #fff;
    }
    .topbar h1 span { color: #c9a227; }

    .badge-live {
      display: flex;
      align-items: center;
      gap: 7px;
      background: rgba(34,197,94,0.08);
      border: 1px solid rgba(34,197,94,0.2);
      border-radius: 20px;
      padding: 5px 14px;
      font-size: 12px;
      font-weight: 600;
      color: #22c55e;
    }
    .dot {
      width: 7px; height: 7px;
      background: #22c55e;
      border-radius: 50%;
      animation: blink 2s infinite;
    }
    @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }

    /* ── STATS ── */
    .stats { display: grid; grid-template-columns: repeat(3,1fr); gap: 14px; margin-bottom: 24px; }

    .stat {
      background: #161616;
      border: 1px solid #242424;
      border-radius: 12px;
      padding: 20px 22px;
      position: relative;
      overflow: hidden;
    }
    .stat::after {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 2px;
      background: linear-gradient(90deg, #c9a227, #f0d060);
    }
    .stat .ico { font-size: 22px; margin-bottom: 10px; }
    .stat .num {
      font-size: 32px;
      font-weight: 800;
      color: #c9a227;
      line-height: 1;
    }
    .stat .lbl {
      font-size: 11px;
      color: #555;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-top: 5px;
    }

    /* ── TABLE CARD ── */
    .card {
      background: #161616;
      border: 1px solid #242424;
      border-radius: 12px;
      overflow: hidden;
    }

    .card-top {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 20px;
      border-bottom: 1px solid #242424;
    }
    .card-top h2 {
      font-size: 14px;
      font-weight: 700;
      color: #ddd;
    }
    .pill {
      background: rgba(201,162,39,0.1);
      color: #c9a227;
      border-radius: 20px;
      padding: 3px 12px;
      font-size: 12px;
      font-weight: 600;
    }

    table { width: 100%; border-collapse: collapse; }

    thead th {
      padding: 11px 16px;
      text-align: left;
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #555;
      background: #131313;
      border-bottom: 1px solid #242424;
    }

    tbody td {
      padding: 14px 16px;
      font-size: 13.5px;
      border-bottom: 1px solid rgba(255,255,255,0.04);
      vertical-align: middle;
    }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover td { background: rgba(255,255,255,0.02); }

    .id-tag {
      background: rgba(201,162,39,0.1);
      color: #c9a227;
      border-radius: 6px;
      padding: 3px 8px;
      font-size: 12px;
      font-weight: 700;
    }

    .name { font-weight: 600; color: #e8e8e8; }

    .phone {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      color: #c9a227;
      text-decoration: none;
      font-weight: 500;
      font-size: 13px;
    }
    .phone:hover { color: #f0d060; }

    .addr { color: #777; font-size: 13px; }

    .msg {
      color: #888;
      font-size: 13px;
      max-width: 200px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .time { color: #555; font-size: 12px; }
    .time-date { display: block; color: #666; font-weight: 500; }

    .empty {
      text-align: center;
      padding: 60px 20px;
      color: #444;
    }
    .empty .e-ico { font-size: 40px; margin-bottom: 12px; }
    .empty p { font-size: 14px; line-height: 1.7; }

    @media (max-width: 768px) {
      .sidebar { display: none; }
      .main { margin-left: 0; padding: 16px; }
      .stats { grid-template-columns: 1fr 1fr; }
    }
  </style>
</head>
<body>
<div class="layout">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="logo-box">
      <div class="brand">🫓 Haji Quetta<br>Paratha</div>
      <div class="sub">Admin Panel</div>
    </div>

    <nav class="nav">
      <a href="#" class="active">
        <span class="ico">📋</span> Contact Submissions
      </a>
      <a href="{{ route('home') }}">
        <span class="ico">🏠</span> Home Page
      </a>
      <a href="{{ route('menu') }}">
        <span class="ico">🍽️</span> Menu
      </a>
      <a href="{{ route('order') }}">
        <span class="ico">🛒</span> Order Page
      </a>
      <a href="{{ route('contact') }}">
        <span class="ico">✉️</span> Contact Form
      </a>
    </nav>

    <div class="sidebar-foot">
      <a href="https://wa.me/923127882163" target="_blank">
        💬 0312-7882163
      </a>
    </div>
  </aside>

  <!-- MAIN -->
  <main class="main">

    <!-- TOPBAR -->
    <div class="topbar">
      <h1>Contact <span>Submissions</span></h1>
      <div class="badge-live">
        <div class="dot"></div> Live Data
      </div>
    </div>

    <!-- STATS -->
    <div class="stats">
      <div class="stat">
        <div class="ico">📬</div>
        <div class="num">{{ $contacts->count() }}</div>
        <div class="lbl">Total Submissions</div>
      </div>
      <div class="stat">
        <div class="ico">📅</div>
        <div class="num">{{ $contacts->where('created_at', '>=', now()->startOfDay())->count() }}</div>
        <div class="lbl">Aaj Ki Inquiries</div>
      </div>
      <div class="stat">
        <div class="ico">📆</div>
        <div class="num">{{ $contacts->where('created_at', '>=', now()->startOfWeek())->count() }}</div>
        <div class="lbl">Is Hafte Ki</div>
      </div>
    </div>

    <!-- TABLE -->
    <div class="card">
      <div class="card-top">
        <h2>📋 Tamam Inquiries</h2>
        <span class="pill">{{ $contacts->count() }} records</span>
      </div>

      @if($contacts->isEmpty())
        <div class="empty">
          <div class="e-ico">📭</div>
          <p>Abhi koi submission nahi hai.<br>Jab koi contact form bhare ga, yahan dikh jayega.</p>
        </div>
      @else
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Naam</th>
              <th>Phone</th>
              <th>Address</th>
              <th>Message</th>
              <th>Waqt</th>
            </tr>
          </thead>
          <tbody>
            @foreach($contacts as $c)
            <tr>
              <td><span class="id-tag">#{{ $c->id }}</span></td>
              <td><span class="name">{{ $c->name }}</span></td>
              <td>
                <a href="tel:{{ $c->phone }}" class="phone">📞 {{ $c->phone }}</a>
              </td>
              <td><span class="addr">{{ $c->address ?? '—' }}</span></td>
              <td><div class="msg" title="{{ $c->message }}">{{ $c->message ?? '—' }}</div></td>
              <td class="time">
                <span class="time-date">{{ $c->created_at->format('d M Y') }}</span>
                {{ $c->created_at->format('h:i A') }}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>

  </main>
</div>
</body>
</html>
