<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Haji Quetta Paratha</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', -apple-system, sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 50%, #43A047 100%); padding: 20px; }
        .card { background: #fff; padding: 36px; border-radius: 16px; max-width: 400px; width: 100%; box-shadow: 0 20px 50px rgba(0,0,0,0.2); }
        .logo { width: 72px; height: 72px; background: #FFC107; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 38px; margin: 0 auto 18px; box-shadow: 0 6px 20px rgba(255,193,7,0.4); }
        h1 { font-size: 22px; font-weight: 700; color: #1B5E20; text-align: center; }
        .sub { font-size: 13px; color: #6b7280; text-align: center; margin-top: 6px; margin-bottom: 24px; }
        .row { margin-bottom: 14px; }
        .row label { display: block; font-size: 12px; font-weight: 600; color: #4b5563; margin-bottom: 5px; }
        .row input { width: 100%; padding: 11px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-family: inherit; font-size: 14px; transition: border-color 0.15s; }
        .row input:focus { outline: none; border-color: #1B5E20; box-shadow: 0 0 0 3px rgba(27,94,32,0.1); }
        .check { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #4b5563; margin-bottom: 18px; }
        .check input { width: auto; }
        .btn { width: 100%; padding: 12px; background: #1B5E20; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: background 0.15s; }
        .btn:hover { background: #2E7D32; }
        .err { background: #fef2f2; color: #b91c1c; padding: 10px 12px; border-radius: 8px; font-size: 13px; margin-bottom: 14px; border: 1px solid #fecaca; }
        .info { margin-top: 18px; padding: 12px; background: #f9fafb; border-radius: 8px; font-size: 11px; color: #6b7280; text-align: center; }
        .info strong { color: #1B5E20; }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">🫓</div>
        <h1>Admin Sign In</h1>
        <p class="sub">Haji Quetta Paratha — Restaurant Management</p>
        @if ($errors->any())
            <div class="err">{{ $errors->first() }}</div>
        @endif
        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="row">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="row">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <label class="check">
                <input type="checkbox" name="remember"> Keep me signed in
            </label>
            <button type="submit" class="btn">Sign In</button>
        </form>
    </div>
</body>
</html>
