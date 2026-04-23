<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin — Contact Submissions</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', sans-serif; background: #0f0f0f; color: #e5e5e5; min-height: 100vh; }
    .admin-header { background: #1a1a1a; border-bottom: 1px solid #2a2a2a; padding: 1.2rem 2rem; display: flex; align-items: center; gap: 1rem; }
    .admin-header h1 { font-size: 1.2rem; font-weight: 700; color: #d4af37; }
    .admin-header span { font-size: 0.8rem; color: #666; }
    .admin-body { padding: 2rem; max-width: 1100px; margin: 0 auto; }
    .stats-row { display: flex; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap; }
    .stat-card { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 12px; padding: 1.2rem 1.8rem; flex: 1; min-width: 150px; }
    .stat-number { font-size: 2rem; font-weight: 800; color: #d4af37; }
    .stat-label { font-size: 0.78rem; color: #666; margin-top: 0.2rem; text-transform: uppercase; letter-spacing: 1px; }
    table { width: 100%; border-collapse: collapse; background: #1a1a1a; border-radius: 12px; overflow: hidden; border: 1px solid #2a2a2a; }
    thead { background: #222; }
    th { padding: 0.9rem 1rem; text-align: left; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 1px; color: #d4af37; border-bottom: 1px solid #2a2a2a; }
    td { padding: 0.9rem 1rem; font-size: 0.88rem; border-bottom: 1px solid #1e1e1e; color: #ccc; vertical-align: top; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #222; }
    .empty { text-align: center; padding: 3rem; color: #555; }
    .badge { display: inline-block; background: rgba(212,175,55,0.15); color: #d4af37; border-radius: 20px; padding: 0.2rem 0.7rem; font-size: 0.75rem; font-weight: 600; }
    a.back { display: inline-flex; align-items: center; gap: 0.4rem; color: #d4af37; text-decoration: none; font-size: 0.85rem; font-weight: 600; }
    a.back:hover { opacity: 0.8; }
  </style>
</head>
<body>

  <div class="admin-header">
    <h1>🫓 Haji Quetta — Admin Panel</h1>
    <span>Contact Submissions</span>
    <div style="margin-left:auto">
      <a href="{{ route('home') }}" class="back">← Website Par Wapas Jaein</a>
    </div>
  </div>

  <div class="admin-body">

    <div class="stats-row">
      <div class="stat-card">
        <div class="stat-number">{{ $contacts->count() }}</div>
        <div class="stat-label">Total Submissions</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">{{ $contacts->where('created_at', '>=', now()->startOfDay())->count() }}</div>
        <div class="stat-label">Aaj Ki</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">{{ $contacts->where('created_at', '>=', now()->startOfWeek())->count() }}</div>
        <div class="stat-label">Is Hafte Ki</div>
      </div>
    </div>

    @if($contacts->isEmpty())
      <div class="empty">
        <div style="font-size:3rem;margin-bottom:1rem">📭</div>
        <p>Abhi koi submission nahi hai.</p>
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
            <td><span class="badge">#{{ $contact->id }}</span></td>
            <td><strong style="color:#e5e5e5">{{ $contact->name }}</strong></td>
            <td><a href="tel:{{ $contact->phone }}" style="color:#d4af37;text-decoration:none">{{ $contact->phone }}</a></td>
            <td>{{ $contact->address ?? '—' }}</td>
            <td style="max-width:250px">{{ $contact->message ?? '—' }}</td>
            <td style="white-space:nowrap;color:#666;font-size:0.8rem">{{ $contact->created_at->format('d M Y, h:i A') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    @endif

  </div>

</body>
</html>