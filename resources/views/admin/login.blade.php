<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Haji Quetta Paratha</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            padding: 20px;
            color: #111827;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(at 20% 10%, rgba(16,185,129,0.18) 0, transparent 50%),
                radial-gradient(at 85% 80%, rgba(52,211,153,0.18) 0, transparent 55%);
            pointer-events: none;
        }
        .card {
            background: #ffffff;
            border: 1px solid rgba(6,78,59,0.12);
            padding: 38px 36px;
            border-radius: 20px;
            max-width: 420px; width: 100%;
            box-shadow: 0 20px 60px rgba(6,78,59,0.18);
            position: relative;
            z-index: 1;
        }
        .logo {
            width: 76px; height: 76px;
            background: linear-gradient(135deg, #FFC107, #FFB300);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 40px; margin: 0 auto 20px;
            box-shadow: 0 10px 28px rgba(255,193,7,0.4);
        }
        h1 {
            font-size: 24px; font-weight: 800;
            color: #064e3b; text-align: center;
            letter-spacing: -0.02em;
        }
        .sub {
            font-size: 13px;
            color: #4b5563;
            text-align: center;
            margin-top: 6px; margin-bottom: 28px;
        }
        .row { margin-bottom: 16px; }
        .row label {
            display: block;
            font-size: 12px; font-weight: 700;
            color: #047857;
            margin-bottom: 7px;
            letter-spacing: 0.02em;
        }
        .row input {
            width: 100%; padding: 12px 14px;
            background: #ffffff;
            border: 1.5px solid #d1fae5;
            border-radius: 10px;
            font-family: inherit; font-size: 14px;
            color: #111827;
            transition: all 0.18s ease;
        }
        .row input::placeholder { color: #9ca3af; }
        .row input:focus {
            outline: none;
            border-color: #10b981;
            background: #f0fdf4;
            box-shadow: 0 0 0 3px rgba(16,185,129,0.18);
        }
        .check {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px;
            color: #4b5563;
            margin-bottom: 22px;
            cursor: pointer;
            font-weight: 500;
        }
        .check input { width: auto; cursor: pointer; }
        .btn {
            width: 100%; padding: 13px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff; border: none; border-radius: 10px;
            font-size: 14.5px; font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(16,185,129,0.35);
            letter-spacing: 0.02em;
        }
        .btn:hover {
            transform: translateY(-1px);
            background: linear-gradient(135deg, #059669, #047857);
            box-shadow: 0 6px 20px rgba(16,185,129,0.5);
        }
        .btn:active { transform: translateY(0); }
        .err {
            background: #fee2e2;
            color: #991b1b;
            padding: 11px 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 16px;
            border: 1px solid #fca5a5;
            font-weight: 500;
        }
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
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus placeholder="admin@haji.com">
            </div>
            <div class="row">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required placeholder="••••••••">
            </div>
            <label class="check">
                <input type="checkbox" name="remember"> Keep me signed in
            </label>
            <button type="submit" class="btn">Sign In →</button>
        </form>
    </div>
</body>
</html>
