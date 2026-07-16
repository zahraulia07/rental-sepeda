<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Gowesin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            margin: 0; min-height: 100vh;
            display: flex; color: #10131C;
        }

        /* PANEL KIRI — ilustrasi + gradasi */
        .panel-hero {
            flex: 1.1; position: relative; overflow: hidden; min-height: 100vh;
            background: linear-gradient(155deg, #06B6D4 0%, #635BFF 55%, #7C3AED 100%);
            display: flex; flex-direction: column; justify-content: space-between;
            padding: 44px 48px;
        }
        .panel-hero::before, .panel-hero::after {
            content: ''; position: absolute; border-radius: 50%;
            background: rgba(255,255,255,0.10);
        }
        .panel-hero::before { width: 420px; height: 420px; top: -140px; right: -140px; }
        .panel-hero::after { width: 300px; height: 300px; bottom: -100px; left: -80px; background: rgba(255,255,255,0.08); }

        .brand-mark { display: flex; align-items: center; gap: 10px; position: relative; z-index: 2; }
        .brand-mark .logo-img { width: 32px; height: 32px; border-radius: 9px; object-fit: cover; display: block; }
        .brand-mark .brand-name { font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 20px; color: #fff; letter-spacing: -0.3px; }

        .hero-illustration {
            position: relative; z-index: 2; text-align: center;
            width: 100%; max-width: 420px; aspect-ratio: 1 / 1; margin: 0 auto;
        }
        .hero-illustration img {
            width: 100%; height: 100%; object-fit: cover; border-radius: 28px;
            filter: drop-shadow(0 20px 30px rgba(0,0,0,0.15));
            /* memudar di sisi kanan foto, menyatu ke panel gradasi di belakangnya */
            -webkit-mask-image: linear-gradient(to right, #000 55%, transparent 100%);
                    mask-image: linear-gradient(to right, #000 55%, transparent 100%);
        }

        .hero-copy { position: relative; z-index: 2; color: #fff; }
        .hero-copy h1 { font-family: 'Space Grotesk', sans-serif; font-size: 30px; font-weight: 700; line-height: 1.25; margin: 0 0 12px; letter-spacing: -0.4px; }
        .hero-copy p { font-size: 14.5px; line-height: 1.6; color: rgba(255,255,255,0.85); max-width: 380px; margin: 0; }

        /* PANEL KANAN — form */
        .panel-form { flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px 24px; background: #F6F7FB; }
        .form-wrap { width: 100%; max-width: 400px; }

        .form-brand { text-align: center; margin-bottom: 26px; }
        .form-brand .badge-icon {
            width: 54px; height: 54px; border-radius: 16px; margin: 0 auto 14px;
            background: linear-gradient(135deg, #06B6D4 0%, #635BFF 55%, #A855F7 100%);
            display: flex; align-items: center; justify-content: center; font-size: 26px;
            box-shadow: 0 10px 22px -6px rgba(99, 91, 255, 0.45); overflow: hidden;
        }
        .form-brand .badge-icon img { width: 100%; height: 100%; object-fit: cover; }
        .form-brand h2 { font-family: 'Space Grotesk', sans-serif; font-size: 24px; font-weight: 700; margin: 0 0 6px; color: #10131C; }
        .form-brand p { font-size: 13.5px; color: #6B7280; margin: 0; }

        .card { background: #fff; border: 1px solid #EEF0F7; border-radius: 22px; padding: 30px; box-shadow: 0 14px 40px rgba(15, 23, 42, 0.06); }

        .field-group { margin-bottom: 18px; }
        .field-group label { display: block; font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 7px; }
        .input-icon-wrap { position: relative; }
        .input-icon-wrap .icon-left { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); font-size: 15px; opacity: 0.55; }
        .input-icon-wrap input {
            width: 100%; padding: 12px 14px 12px 40px; border: 1px solid #E2E8F0; border-radius: 12px;
            font-size: 14px; background: #F8FAFC; color: #10131C; font-family: 'Inter', sans-serif;
        }
        .input-icon-wrap input:focus { outline: none; border-color: #635BFF; box-shadow: 0 0 0 4px rgba(99, 91, 255, 0.12); background: #fff; }
        .toggle-eye { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; font-size: 15px; opacity: 0.55; user-select: none; background: none; border: none; padding: 4px; }

        .remember-row { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; }
        .remember-row input[type="checkbox"] { width: 16px; height: 16px; accent-color: #635BFF; }
        .remember-row label { font-size: 13px; color: #475569; cursor: pointer; }

        .btn-masuk {
            width: 100%; padding: 13px; border: none; border-radius: 12px; cursor: pointer;
            background: linear-gradient(135deg, #06B6D4 0%, #635BFF 55%, #A855F7 100%); color: #fff;
            font-weight: 700; font-size: 14.5px; font-family: 'Inter', sans-serif;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            box-shadow: 0 10px 22px -6px rgba(99, 91, 255, 0.45); transition: all 0.18s;
        }
        .btn-masuk:hover { transform: translateY(-1px); box-shadow: 0 14px 26px -6px rgba(99, 91, 255, 0.55); }

        .error-box { background: #FEF2F2; border-left: 4px solid #E11D48; color: #B91C1C; padding: 11px 14px; border-radius: 10px; font-size: 13px; margin-bottom: 18px; }
        .success-box { background: #ECFDF5; border-left: 4px solid #10B981; color: #047857; padding: 11px 14px; border-radius: 10px; font-size: 13px; margin-bottom: 18px; }

        .footer-link { text-align: center; margin-top: 22px; font-size: 13.5px; color: #6B7280; }
        .footer-link a { color: #635BFF; text-decoration: none; font-weight: 700; }
        .footer-link a:hover { text-decoration: underline; }

        @media (max-width: 880px) {
            .panel-hero { display: none; }
            .panel-form { min-height: 100vh; }
        }
    </style>
</head>
<body>

<div class="panel-hero">
    <div class="brand-mark">
        <img src="{{ asset('images/logo.png') }}" alt="Gowesin" class="logo-img">
        <span class="brand-name">Gowesin</span>
    </div>

    <div class="hero-illustration">
        <img src="{{ asset('images/hero-login.jpg') }}" alt="Gowesin">
    </div>

    <div class="hero-copy">
        <h1>Temukan Kebebasan di Setiap Putaran Pedal.</h1>
        <p>Layanan penyewaan sepeda modern untuk mobilitas perkotaan yang lebih cerdas, sehat, dan berkelanjutan.</p>
    </div>
</div>

<div class="panel-form">
    <div class="form-wrap">
        <div class="form-brand">
            <div class="badge-icon"><img src="{{ asset('images/logo.png') }}" alt="Gowesin"></div>
            <h2>Gowesin</h2>
            <p>Selamat datang kembali! Silakan masuk ke akun Anda.</p>
        </div>

        <div class="card">
            @if ($errors->any())
                <div class="error-box">{{ $errors->first() }}</div>
            @endif

            @if (session('sukses'))
                <div class="success-box">✔️ {{ session('sukses') }}</div>
            @endif

            <form method="POST" action="/login">
                @csrf
                <div class="field-group">
                    <label>Email / Username</label>
                    <div class="input-icon-wrap">
                        <span class="icon-left">👤</span>
                        <input type="text" name="identifier" value="{{ old('identifier') }}" required autofocus placeholder="nama@email.com atau username">
                    </div>
                </div>

                <div class="field-group">
                    <label>Password</label>
                    <div class="input-icon-wrap">
                        <span class="icon-left">🔒</span>
                        <input type="password" name="password" id="passwordInput" required placeholder="Masukkan password" style="padding-right: 40px;">
                        <button type="button" class="toggle-eye" onclick="togglePassword()">👁️</button>
                    </div>
                </div>

                <div class="remember-row">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ingat Saya</label>
                </div>

                <button type="submit" class="btn-masuk">MASUK →</button>
            </form>
        </div>

        <div class="footer-link">
            Belum punya akun? <a href="/register">Daftar Sekarang</a>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('passwordInput');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>

</body>
</html>
