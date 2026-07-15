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
            background: linear-gradient(135deg, #e0f2fe 0%, #f0fdf4 100%);
            color: #1e293b;
            padding: 40px 16px;
        }
        .card {
            background: #ffffff;
            width: 100%;
            max-width: 640px;
            padding: 36px 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            border: 1px solid #e2e8f0;
        }
        .brand { text-align: center; margin-bottom: 24px; }
        .brand h1 { font-size: 22px; margin: 0; color: #0f172a; }
        .brand p { margin: 6px 0 0; font-size: 13px; color: #64748b; }
        .section-title {
            font-size: 13px; font-weight: 700; color: #10b981; text-transform: uppercase;
            letter-spacing: 0.5px; margin: 24px 0 14px; border-bottom: 2px solid #d1fae5; padding-bottom: 8px;
        }
        .section-title:first-of-type { margin-top: 0; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-group { margin-bottom: 16px; }
        .form-group.full { grid-column: 1 / -1; }
        label { display: block; margin-bottom: 6px; font-size: 14px; font-weight: 600; color: #334155; }
        input, select, textarea {
            width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px;
            font-size: 14px; background: #f8fafc; color: #0f172a; font-family: inherit;
        }
        textarea { resize: vertical; min-height: 60px; }
        input:focus, select:focus, textarea:focus {
            outline: none; border-color: #10b981; background: #fff;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
        }
        .btn-submit {
            width: 100%; padding: 12px; border: none; border-radius: 8px; background: #10b981;
            color: #fff; font-weight: bold; font-size: 15px; cursor: pointer; margin-top: 8px;
        }
        .btn-submit:hover { background: #059669; }
        .error-box {
            background: #fef2f2; border-left: 4px solid #ef4444; color: #b91c1c;
            padding: 12px 14px; border-radius: 6px; font-size: 13px; margin-bottom: 18px;
        }
        .error-box ul { margin: 4px 0 0; padding-left: 18px; }
        .footer-link { text-align: center; margin-top: 20px; font-size: 13px; color: #64748b; }
        .footer-link a { color: #10b981; text-decoration: none; font-weight: 600; }
        .footer-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="card">
    <div class="brand">
        <h1>🚲 Buat Akun Baru</h1>
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

        <div class="section-title">Data Diri</div>

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

        <div class="section-title">Data Akun</div>

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
