<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Panel — Haji Quetta Paratha</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <style>
    :root {
      --gold: #d4af37;
      --gold-light: #f0d060;
      --dark: #0a0a0a;
      --card: #111111;
      --card2: #161616;
      --border: rgba(212,175,55,0.12);
      --text: #e8e8e8;
      --text-muted: #555;
      --green: #22c55e;
      --red: #ef4444;
    }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Inter',sans-serif; background:var(--dark); color:var(--text); min-height:100vh; }

    /* SIDEBAR */
    .layout { display:flex; min-height:100vh; }
    .sidebar {
      width:240px; background:var(--card); border-right:1px solid var(--border);
      display:flex; flex-direction:column; padding:1.5rem 0; position:fixed; height:100vh; left:0; top:0; z-index:10;
    }
    .sidebar-logo {
      padding:0 1.5rem 1.5rem; border-bottom:1px solid var(--border); margin-bottom:1rem;
    }
    .sidebar-logo .brand { font-family:'Syne',sans-serif; font-weight:800; font-size:1rem; color:var(--gold); line-height:1.2; }
    .sidebar-logo .sub { font-size:0.7rem; color:var(--text-muted); margin-top:0.2rem; letter-spacing:1px; text-transform:uppercase; }
    .nav-item {
      display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1.5rem;
      color:var(--text-muted); text-decoration:none; font-size:0.85rem; font-weight:500;
      transition:all 0.2s; border-left:3px solid transparent;
    }
    .nav-item:hover { color:var(--text); background:rgba(255,255,255,0.03); }
    .nav-item.active { color:var(--gold); border-left-color:var(--gold); background:rgba(212,175,55,0.06); }
    .nav-item .icon { font-size:1rem; width:20px; text-align:center; }
    .sidebar-footer { margin-top:auto; padding:1rem 1.5rem; border-top:1px solid var(--border); }
    .sidebar-footer a { color:var(--text-muted); text-decoration:none; font-size:0.78rem; display:flex; align-items:center; gap:0.5rem; transition:color 0.2s; }
    .sidebar-footer a:hover { color:var(--gold); }

    /* MAIN */
    .main { margin-left:240px; flex:1; padding:2rem; }

    /* TOPBAR */
    .topbar {
      display:flex; align-items:center; justify-content:space-between;
      margin-bottom:2rem;
    }
    .topbar-title { font-family:'Syne',sans-serif; font-size:1.4rem; font-weight:700; }
    .topbar-title span { color:var(--gold); }
    .live-badge {
      display:flex; align-items:center; gap:0.5rem; background:rgba(34,197,94,0.1);
      border:1px solid rgba(34,197,94,0.25); border-radius:20px; padding:0.4rem 1rem;
      font-size:0.75rem; font-weight:600; color:var(--green);
    }
    .live-dot { width:7px; height:7px; background:var(--green); border-radius:50%; animation:pulse 2s infinite; }
    @keyframes pulse { 0%,100%{opacity:1;} 50%{opacity:0.4;} }

    /* STATS */
    .stats-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; margin-bottom:2rem; }
    .stat-card {
      background:var(--card); border:1px solid var(--border); border-radius:16px;
      padding:1.4rem 1.6rem; position:relative; overflow:hidden;
      transition:border-color 0.2s;
    }
    .stat-card:hover { border-color:rgba(212,175,55,0.3); }
    .stat-card::before {
      content:''; position:absolute; top:0; left:0; right:0; height:3px;
      background:linear-gradient(90deg, var(--gold), var(--gold-light));
      opacity:0.6;
    }
    .stat-icon { font-size:1.6rem; margin-bottom:0.8rem; }
    .stat-num { font-family:'Syne',sans-serif; font-size:2.2rem; font-weight:800; color:var(--gold); line-height:1; }
    .stat-label { font-size:0.72rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:1.2px; margin-top:0.4rem; }

    /* TABLE CARD */
    .table-card { background:var(--card); border:1px solid var(--border); border-radius:16px; overflow:hidden; }
    .table-header {
      padding:1.2rem 1.5rem; border-bottom:1px solid var(--border);
      display:flex; align-items:center; justify-content:space-between;
    }
    .table-header h2 { font-family:'Syne',sans-serif; font-size:1rem; font-weight:700; color:var(--text); }
    .table-header .count-pill {
      background:rgba(212,175,55,0.12); color:var(--gold); border-radius:20px;
      padding:0.25rem 0.8rem; font-size:0.75rem; font-weight:600;
    }
    table { width:100%; border-collapse:collapse; }
    thead th {
      padding:0.85rem 1.2rem; text-align:left; font-size:0.7rem;
      text-transform:uppercase; letter-spacing:1.2px; color:var(--text-muted);
      background:var(--card2); border-bottom:1px solid var(--border);
    }
    tbody td {
      padding:1rem 1.2rem; font-size:0.85rem; border-bottom:1px solid rgba(255,255,255,0.04);
      vertical-align:middle;
    }
    tbody tr:last-child td { border-bottom:none; }
    tbody tr { transition:background 0.15s; }
    tbody tr:hover td { background:rgba(255,255,255,0.025); }

    .id-badge {
      background:rgba(212,175,55,0.1); color:var(--gold); border-radius:8px;
      padding:0.25rem 0.6rem; font-size:0.72rem; font-weight:700; font-family:'Syne',sans-serif;
    }
    .name-cell { font-weight:600; color:var(--text); font-size:0.88rem; }
    .phone-link {
      color:var(--gold); text-decoration:none; font-weight:600; font-size:0.85rem;
      display:flex; align-items:center; gap:0.4rem;
    }
    .phone-link:hover { color:var(--gold-light); }
    .address-cell { color:#888; font-size:0.82rem; max-width:180px; }
    .msg-cell { color:#aaa; font-size:0.82rem; max-width:220px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .time-cell { color:var(--text-muted); font-size:0.75rem; white-space:nowrap; }
    .time-date { font-weight:600; color:#777; }
    .time-hour { display:block; font-size:0.7rem; color:var(--text-muted); }

    .empty-state { text-align:center; padding:4rem 2rem; }
    .empty-state .emoji { font-size:3.5rem; margin-bottom:1rem; }
    .empty-state p { color:var(--text-muted); font-size:0.9rem; }

    /* RESPONSIVE */
    @media(max-width:768px) {
      .sidebar { display:none; }
      .main { margin-left:0; padding:1rem; }
      .stats-grid { grid-template-columns:1fr; }
    }
  </style>
</head>
<body>

<div class="layout">

  <!-- SIDEBAR -->
  <div class="sidebar">
    <div class="sidebar-logo">
      <div class="brand">🫓 Haji Quetta<br>Paratha</div>
      <div class="sub">Admin Panel</div>
    </div>

    <a href="#" class="nav-item active">
      <span class="icon">📋</span> Contact Submissions
    </a>
    <a href="{{ route('home') }}" class="nav-item">
      <span class="icon">🏠</span> Home Page
    </a>
    <a href="{{ route('menu') }}" class="nav-item">
      <span class="icon">🍽️</span> Menu
    </a>
    <a href="{{ route('order') }}" class="nav-item">
      <span class="icon">🛒</span> Order Page
    </a>
    <a href="{{ route('contact') }}" class="nav-item">
      <span class="icon">✉️</span> Contact Form
    </a>

    <div class="sidebar-footer">
      <a href="https://wa.me/923127882163" target="_blank">
        💬 WhatsApp: 0312-7882163
      </a>
    </div>
  </div>

  <!-- MAIN CONTENT -->
  <div class="main">

    <!-- TOPBAR -->
    <div class="topbar">
      <div class="topbar-title">Contact <span>Submissions</span></div>
      <div class="live-badge">
        <div class="live-dot"></div>
        Live Data
      </div>
    </div>

    <!-- STATS -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon">📬</div>
        <div class="stat-num">{{ $contacts->count() }}</div>
        <div class="stat-label">Total Submissions</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon">📅</div>
        <div class="stat-num">{{ $contacts->where('created_at', '>=', now()->startOfDay())->count() }}</div>
        <div class="stat-label">Aaj Ki Inquiries</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon">📆</div>
        <div class="stat-num">{{ $contacts->where('created_at', '>=', now()->startOfWeek())->count() }}</div>
        <div class="stat-label">Is Hafte Ki</div>
      </div>
    </div>

    <!-- TABLE -->
    <div class="table-card">
      <div class="table-header">
        <h2>📋 Tamam Inquiries</h2>
        <span class="count-pill">{{ $contacts->count() }} records</span>
      </div>

      @if($contacts->isEmpty())
        <div class="empty-state">
          <div class="emoji">📭</div>
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
            @foreach($contacts as $contact)
            <tr>
              <td><span class="id-badge">#{{ $contact->id }}</span></td>
              <td><div class="name-cell">{{ $contact->name }}</div></td>
              <td>
                <a href="tel:{{ $contact->phone }}" class="phone-link">
                  📞 {{ $contact->phone }}
                </a>
              </td>
              <td><div class="address-cell">{{ $contact->address ?? '—' }}</div></td>
              <td><div class="msg-cell" title="{{ $contact->message }}">{{ $contact->message ?? '—' }}</div></td>
              <td class="time-cell">
                <span class="time-date">{{ $contact->created_at->format('d M Y') }}</span>
                <span class="time-hour">{{ $contact->created_at->format('h:i A') }}</span>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>

  </div>
</div>

</body>
</html>