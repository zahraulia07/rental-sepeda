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
            background-color: #f4f8fb;
            background-image:
                radial-gradient(circle at 8% 8%, rgba(16, 185, 129, 0.16), transparent 32%),
                radial-gradient(circle at 92% 18%, rgba(6, 182, 212, 0.16), transparent 34%),
                radial-gradient(circle at 50% 95%, rgba(245, 158, 11, 0.10), transparent 38%);
            background-attachment: fixed;
            color: #1e293b;
            padding: 20px;
        }

        .wrapper {
            width: 100%;
            max-width: 880px;
            background: #ffffff;
            border-radius: 28px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.10);
            border: 1px solid #eef2f7;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* Panel kiri: hero brand */
        .hero {
            position: relative;
            overflow: hidden;
            background: linear-gradient(150deg, #10b981 0%, #06b6d4 100%);
            color: #fff;
            padding: 44px 38px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .hero::before {
            content: ""; position: absolute; top: -70px; right: -50px; width: 240px; height: 240px;
            background: rgba(255,255,255,0.14); border-radius: 50%;
        }
        .hero::after {
            content: ""; position: absolute; bottom: -90px; left: -40px; width: 220px; height: 220px;
            background: rgba(255,255,255,0.10); border-radius: 50%;
        }
        .hero-top { position: relative; z-index: 1; }
        .hero-brand { display: flex; align-items: center; gap: 10px; font-weight: 800; font-size: 18px; margin-bottom: 40px; }
        .hero-brand .dot { width: 12px; height: 12px; border-radius: 50%; background: #fff; }
        .hero-emoji { font-size: 46px; margin-bottom: 14px; }
        .hero h1 { font-size: 26px; margin: 0 0 10px; line-height: 1.3; position: relative; z-index: 1; }
        .hero p { font-size: 13.5px; opacity: 0.92; line-height: 1.6; margin: 0; position: relative; z-index: 1; }

        .hero-features { position: relative; z-index: 1; display: flex; flex-direction: column; gap: 14px; margin-top: 30px; }
        .hero-feature { display: flex; align-items: center; gap: 10px; font-size: 13px; font-weight: 600; }
        .hero-feature .ico {
            width: 30px; height: 30px; border-radius: 10px; background: rgba(255,255,255,0.18);
            display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0;
        }

        /* Panel kanan: form */
        .form-panel { padding: 44px 40px; display: flex; flex-direction: column; justify-content: center; }
        .brand-mobile { display: none; text-align: center; margin-bottom: 24px; }
        .brand-mobile h1 { font-size: 20px; margin: 0; color: #0f172a; }

        .form-title { margin-bottom: 26px; }
        .form-title h2 { margin: 0 0 6px; font-size: 22px; color: #0f172a; }
        .form-title p { margin: 0; font-size: 13.5px; color: #64748b; }

        .form-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 6px; font-size: 13.5px; font-weight: 700; color: #334155; }
        input {
            width: 100%; padding: 12px 14px; border: 1px solid #e2e8f0;
            border-radius: 12px; font-size: 14px; background: #f8fafc; color: #0f172a;
        }
        input:focus {
            outline: none; border-color: #10b981; background: #fff;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.12);
        }
        .btn-submit {
            width: 100%; padding: 13px; border: none; border-radius: 999px; margin-top: 6px;
            background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
            color: #fff; font-weight: 800; font-size: 15px;
            cursor: pointer; transition: all .2s;
            box-shadow: 0 10px 22px rgba(16, 185, 129, 0.30);
        }
        .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 14px 26px rgba(16, 185, 129, 0.38); }

        .error-box {
            background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c;
            padding: 11px 14px; border-radius: 12px; font-size: 13px; margin-bottom: 18px; font-weight: 600;
        }
        .success-box {
            background: #ecfdf5; border: 1px solid #a7f3d0; color: #047857;
            padding: 11px 14px; border-radius: 12px; font-size: 13px; margin-bottom: 18px; font-weight: 600;
        }
        .footer-link { text-align: center; margin-top: 22px; font-size: 13px; color: #64748b; }
        .footer-link a { color: #10b981; text-decoration: none; font-weight: 700; }
        .footer-link a:hover { text-decoration: underline; }

        @media (max-width: 720px) {
            .wrapper { grid-template-columns: 1fr; max-width: 420px; }
            .hero { display: none; }
            .brand-mobile { display: block; }
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="hero">
        <div class="hero-top">
            <div class="hero-brand"><span class="dot"></span> BikeRent</div>
            <div class="hero-emoji">🚲</div>
            <h1>Kelola Rental Sepeda Lebih Mudah</h1>
            <p>Masuk untuk menyewa armada terbaik kami atau kelola inventaris dari satu dashboard yang simpel &amp; cepat.</p>
        </div>
        <div class="hero-features">
            <div class="hero-feature"><span class="ico">⚡</span> Proses sewa cepat, tinggal pilih &amp; ajukan</div>
            <div class="hero-feature"><span class="ico">🔒</span> Data &amp; pembayaran tercatat rapi</div>
            <div class="hero-feature"><span class="ico">🛠️</span> Armada terawat & selalu dicek berkala</div>
        </div>
    </div>

    <div class="form-panel">
        <div class="brand-mobile"><h1>🚲 BikeRent</h1></div>

        <div class="form-title">
            <h2>Selamat Datang 👋</h2>
            <p>Masuk untuk mengelola inventaris armada</p>
        </div>

        @if ($errors->any())
            <div class="error-box">{{ $errors->first() }}</div>
        @endif

        @if (session('sukses'))
            <div class="success-box">✔️ {{ session('sukses') }}</div>
        @endif

        @if (session('gagal'))
            <div class="error-box">⚠️ {{ session('gagal') }}</div>
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
</div>

</body>
</html>
