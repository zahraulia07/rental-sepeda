<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Rental Sepeda</title>
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
            padding: 40px 16px;
        }
        .card {
            background: #ffffff;
            width: 100%;
            max-width: 680px;
            padding: 40px 44px;
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.09);
            border: 1px solid #eef2f7;
        }
        .brand { text-align: center; margin-bottom: 8px; }
        .brand-emoji {
            width: 56px; height: 56px; border-radius: 18px; margin: 0 auto 14px;
            background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
            display: flex; align-items: center; justify-content: center; font-size: 26px;
            box-shadow: 0 10px 22px rgba(16, 185, 129, 0.30);
        }
        .brand h1 { font-size: 22px; margin: 0; color: #0f172a; }
        .brand p { margin: 6px 0 24px; font-size: 13.5px; color: #64748b; text-align: center; }

        .section-title {
            font-size: 12px; font-weight: 800; color: #10b981; text-transform: uppercase;
            letter-spacing: 0.6px; margin: 26px 0 16px; padding-bottom: 10px;
            display: flex; align-items: center; gap: 8px;
            border-bottom: 2px solid #f1f5f9;
        }
        .section-title:first-of-type { margin-top: 0; }
        .section-title .num {
            width: 20px; height: 20px; border-radius: 50%; background: #d1fae5; color: #047857;
            display: inline-flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 800;
        }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-group { margin-bottom: 16px; }
        .form-group.full { grid-column: 1 / -1; }
        label { display: block; margin-bottom: 6px; font-size: 13.5px; font-weight: 700; color: #334155; }
        input, select, textarea {
            width: 100%; padding: 11px 14px; border: 1px solid #e2e8f0; border-radius: 12px;
            font-size: 14px; background: #f8fafc; color: #0f172a; font-family: inherit;
        }
        textarea { resize: vertical; min-height: 60px; }
        input:focus, select:focus, textarea:focus {
            outline: none; border-color: #10b981; background: #fff;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.12);
        }
        .btn-submit {
            width: 100%; padding: 13px; border: none; border-radius: 999px;
            background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
            color: #fff; font-weight: 800; font-size: 15px; cursor: pointer; margin-top: 10px;
            transition: all .2s; box-shadow: 0 10px 22px rgba(16, 185, 129, 0.30);
        }
        .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 14px 26px rgba(16, 185, 129, 0.38); }

        .error-box {
            background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c;
            padding: 13px 16px; border-radius: 12px; font-size: 13px; margin-bottom: 20px; font-weight: 600;
        }
        .error-box strong { display: block; margin-bottom: 4px; }
        .error-box ul { margin: 4px 0 0; padding-left: 18px; font-weight: 500; }
        .footer-link { text-align: center; margin-top: 22px; font-size: 13px; color: #64748b; }
        .footer-link a { color: #10b981; text-decoration: none; font-weight: 700; }
        .footer-link a:hover { text-decoration: underline; }

        @media (max-width: 560px) {
            .form-row { grid-template-columns: 1fr; }
            .card { padding: 30px 22px; }
        }
    </style>
</head>
<body>

<div class="card">
    <div class="brand">
        <div class="brand-emoji">🚲</div>
        <h1>Buat Akun Baru</h1>
        <p>Lengkapi data diri untuk mendaftar</p>
    </div>

    @if ($errors->any())
        <div class="error-box">
            <strong>Periksa kembali data yang kamu isi:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/register">
        @csrf

        <div class="section-title"><span class="num">1</span> Data Diri</div>

        <div class="form-group full">
            <label>Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Zahra Aulia">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required placeholder="Contoh: Tangerang">
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" required>
                    <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih jenis kelamin</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label>No. KTP</label>
                <input type="text" name="no_ktp" value="{{ old('no_ktp') }}" required maxlength="16" inputmode="numeric" placeholder="16 digit NIK">
            </div>
        </div>

        <div class="form-group full">
            <label>Alamat</label>
            <textarea name="alamat" required placeholder="Alamat lengkap sesuai KTP">{{ old('alamat') }}</textarea>
        </div>

        <div class="form-group full">
            <label>No. HP</label>
            <input type="text" name="no_hp" value="{{ old('no_hp') }}" required placeholder="Contoh: 08123456789">
        </div>

        <div class="section-title"><span class="num">2</span> Data Akun</div>

        <div class="form-group full">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com">
        </div>

        <div class="form-group full">
            <label>Username</label>
            <input type="text" name="username" value="{{ old('username') }}" required placeholder="Dipakai untuk login">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Minimal 6 karakter">
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required placeholder="Ulangi password">
            </div>
        </div>

        <button type="submit" class="btn-submit">Daftar Sekarang</button>
    </form>

    <div class="footer-link">
        Sudah punya akun? <a href="/login">Masuk di sini</a>
    </div>
</div>

</body>
</html>
