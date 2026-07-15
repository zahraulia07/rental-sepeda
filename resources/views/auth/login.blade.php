<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rental Sepeda</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #e0f2fe 0%, #f0fdf4 100%);
            color: #1e293b;
            padding: 20px;
        }
        .card {
            background: #ffffff;
            width: 100%;
            max-width: 400px;
            padding: 36px 32px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            border: 1px solid #e2e8f0;
        }
        .brand { text-align: center; margin-bottom: 28px; }
        .brand h1 { font-size: 22px; margin: 0; color: #0f172a; }
        .brand p { margin: 6px 0 0; font-size: 13px; color: #64748b; }
        .form-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 6px; font-size: 14px; font-weight: 600; color: #334155; }
        input {
            width: 100%; padding: 11px 12px; border: 1px solid #cbd5e1;
            border-radius: 8px; font-size: 14px; background: #f8fafc; color: #0f172a;
        }
        input:focus {
            outline: none; border-color: #10b981; background: #fff;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
        }
        .btn-submit {
            width: 100%; padding: 12px; border: none; border-radius: 8px;
            background: #10b981; color: #fff; font-weight: bold; font-size: 15px;
            cursor: pointer; transition: background .2s;
        }
        .btn-submit:hover { background: #059669; }
        .error-box {
            background: #fef2f2; border-left: 4px solid #ef4444; color: #b91c1c;
            padding: 10px 14px; border-radius: 6px; font-size: 13px; margin-bottom: 18px;
        }
        .success-box {
            background: #f0fdf4; border-left: 4px solid #10b981; color: #15803d;
            padding: 10px 14px; border-radius: 6px; font-size: 13px; margin-bottom: 18px;
        }
        .footer-link { text-align: center; margin-top: 20px; font-size: 13px; color: #64748b; }
        .footer-link a { color: #10b981; text-decoration: none; font-weight: 600; }
        .footer-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="card">
    <div class="brand">
        <h1>🚲 Rental Sepeda</h1>
        <p>Masuk untuk mengelola inventaris armada</p>
    </div>

    @if ($errors->any())
        <div class="error-box">{{ $errors->first() }}</div>
    @endif

    @if (session('sukses'))
        <div class="success-box">✔️ {{ session('sukses') }}</div>
    @endif

    <form method="POST" action="/login">
        @csrf
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="{{ old('username') }}" required autofocus placeholder="Masukkan username">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required placeholder="Masukkan password">
        </div>
        <button type="submit" class="btn-submit">Masuk</button>
    </form>

    <div class="footer-link">
        Belum punya akun? <a href="/register">Daftar di sini</a>
    </div>
</div>

</body>
</html>
