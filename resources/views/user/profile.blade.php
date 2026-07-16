<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Rental Sepeda</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0; padding: 40px 24px;
            background-color: #f4f8fb;
            background-image:
                radial-gradient(circle at 8% 8%, rgba(16, 185, 129, 0.16), transparent 32%),
                radial-gradient(circle at 92% 18%, rgba(6, 182, 212, 0.16), transparent 34%),
                radial-gradient(circle at 50% 95%, rgba(245, 158, 11, 0.10), transparent 38%);
            background-attachment: fixed;
            color: #1e293b;
        }
        .container { max-width: 700px; margin: auto; background: #fff; padding: 32px; border-radius: 24px; box-shadow: 0px 14px 40px rgba(15, 23, 42, 0.07); border: 1px solid #eef2f7; margin-bottom: 24px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; font-size: 13px; color: #64748b; }
        .brand { display: flex; align-items: center; gap: 8px; font-weight: 800; color: #0f172a; font-size: 15px; }
        .brand .dot { width: 10px; height: 10px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #06b6d4); }
        .topbar .user-info b { color: #0f172a; }
        .topbar .role-badge { background: linear-gradient(135deg, #dbeafe, #e0f2fe); color: #1d4ed8; font-weight: 700; padding: 3px 10px; border-radius: 999px; font-size: 11px; text-transform: uppercase; margin-left: 6px; }
        .btn-logout { background: #fff; color: #ef4444; border: 1px solid #fecaca; padding: 8px 16px; border-radius: 999px; font-size: 13px; cursor: pointer; font-weight: 700; transition: all 0.15s; }
        .btn-logout:hover { background: #ef4444; color: #fff; border-color: #ef4444; }

        .section-title { display: flex; align-items: center; gap: 10px; border-bottom: 2px solid #f1f5f9; padding-bottom: 16px; margin-bottom: 20px; }
        .section-title h2 { margin: 0; font-size: 19px; color: #0f172a; }

        .alert { padding: 13px 16px; background-color: #ecfdf5; color: #047857; border-radius: 12px; margin-bottom: 20px; font-size: 14px; border: 1px solid #a7f3d0; font-weight: 600; }
        .alert-gagal { padding: 13px 16px; background-color: #fef2f2; color: #b91c1c; border-radius: 12px; margin-bottom: 20px; font-size: 14px; border: 1px solid #fecaca; font-weight: 600; }

        .form-group { margin-bottom: 16px; }
        label { display: block; margin-bottom: 6px; font-weight: 700; font-size: 13px; color: #475569; }
        input { width: 100%; padding: 11px; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 14px; background: #f8fafc; }
        input:focus { outline: none; border-color: #10b981; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15); background: #fff; }
        input[disabled] { color: #94a3b8; background: #f1f5f9; }
        .error { color: #dc2626; font-size: 12px; margin-top: 4px; }

        .btn-simpan { background: linear-gradient(135deg, #10b981, #06b6d4); color: #fff; padding: 12px 24px; border: none; border-radius: 12px; font-weight: 700; font-size: 14px; cursor: pointer; box-shadow: 0 8px 18px rgba(16,185,129,0.28); }
        .btn-simpan:hover { filter: brightness(1.05); }
        .hint { font-size: 12px; color: #94a3b8; margin-top: -10px; margin-bottom: 16px; }

        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.5); display: none; justify-content: center; align-items: center; z-index: 9999; backdrop-filter: blur(2px); }
        .modal-crop-box { background: #fff; padding: 24px; border-radius: 20px; width: 100%; max-width: 480px; border: 1px solid #eef2f7; box-shadow: 0 20px 50px rgba(15,23,42,0.25); }
        .crop-img-wrap { max-height: 380px; overflow: hidden; background: #0f172a; border-radius: 14px; }
        .crop-img-wrap img { display: block; max-width: 100%; }
        .btn-simpan-crop { background: linear-gradient(135deg, #10b981, #06b6d4); color: #fff; width: 100%; padding: 11px; border: none; border-radius: 12px; font-weight: 700; margin-top: 16px; cursor: pointer; box-shadow: 0 8px 18px rgba(16,185,129,0.28); }
        .btn-batal-crop { background: #f1f5f9; color: #475569; width: 100%; padding: 10px; border: none; border-radius: 12px; margin-top: 8px; cursor: pointer; font-weight: 700; }
        .btn-pilih-foto { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; padding: 10px 18px; border-radius: 999px; font-size: 13px; font-weight: 700; cursor: pointer; }
    </style>
</head>
<body>

<div class="container">
    <div class="topbar">
        <div class="brand"><span class="dot"></span> Gowesin</div>
        <div class="user-info">Masuk sebagai <b>{{ Auth::user()->name }}</b><span class="role-badge">{{ Auth::user()->role }}</span></div>
        <form action="/logout" method="POST" onsubmit="return confirm('Keluar dari sistem?')">
            @csrf
            <button type="submit" class="btn-logout">Keluar</button>
        </form>
    </div>

    @include('partials.user-nav')

    @if(session('sukses'))
        <div class="alert">✔️ {{ session('sukses') }}</div>
    @endif
    @if($errors->any())
        <div class="alert-gagal">⚠️ {{ $errors->first() }}</div>
    @endif
</div>

<div class="container">
    <div class="section-title"><h2>👤 Edit Profil</h2></div>
    <form action="/profile" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group" style="text-align:center;">
            @if($user->foto_profil)
                <img id="previewFoto" src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil" style="width:96px;height:96px;object-fit:cover;border-radius:50%;border:3px solid #10b981; display:block; margin:0 auto; box-shadow: 0 8px 20px rgba(16,185,129,0.25);">
            @else
                <img id="previewFoto" src="" alt="Foto Profil" style="width:96px;height:96px;object-fit:cover;border-radius:50%;border:3px solid #10b981; display:none; margin:0 auto;">
            @endif
            <div id="previewFotoKosong" style="width:96px;height:96px;border-radius:50%;background:linear-gradient(135deg, #ecfeff, #f0fdf4);display:{{ $user->foto_profil ? 'none' : 'flex' }};align-items:center;justify-content:center;font-size:38px;margin:0 auto;">👤</div>
        </div>
        <div class="form-group" style="text-align:center;">
            <label style="text-align:center;">Foto Profil</label>
            <input type="file" id="fotoPicker" accept="image/*" style="display:none;">
            <input type="file" id="fotoFinal" name="foto_profil" style="display:none;">
            <button type="button" class="btn-pilih-foto" onclick="document.getElementById('fotoPicker').click()">🖼️ Pilih & Crop Foto</button>
            <p class="hint" style="margin-top:6px;">Foto akan di-crop jadi persegi sebelum disimpan.</p>
        </div>
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="form-group">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $user->tempat_lahir) }}" required>
        </div>
        <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir ? $user->tanggal_lahir->format('Y-m-d') : '') }}" required>
        </div>
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" required style="width: 100%; padding: 11px; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 14px; background: #f8fafc;">
                <option value="" disabled>Pilih jenis kelamin</option>
                <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label>No. KTP</label>
            <input type="text" name="no_ktp" value="{{ old('no_ktp', $user->no_ktp) }}" maxlength="16" required>
        </div>
        <div class="form-group">
            <label>Nomor HP Aktif</label>
            <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" required>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" value="{{ old('alamat', $user->alamat) }}" required>
        </div>
        <button type="submit" class="btn-simpan">Simpan Perubahan</button>
    </form>
</div>

<div class="container">
    <div class="section-title"><h2>🔒 Ganti Kata Sandi</h2></div>
    <form action="/profile/password" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Kata Sandi Saat Ini</label>
            <input type="password" name="current_password" required>
        </div>
        <div class="form-group">
            <label>Kata Sandi Baru</label>
            <input type="password" name="password" required minlength="6">
        </div>
        <div class="form-group">
            <label>Konfirmasi Kata Sandi Baru</label>
            <input type="password" name="password_confirmation" required minlength="6">
        </div>
        <button type="submit" class="btn-simpan">Perbarui Kata Sandi</button>
    </form>
</div>

<div class="modal-overlay" id="modalCrop">
    <div class="modal-crop-box">
        <h3 style="margin-top:0;">✂️ Crop Foto Profil</h3>
        <div class="crop-img-wrap">
            <img id="cropImage" src="" alt="Crop">
        </div>
        <button type="button" class="btn-simpan-crop" onclick="simpanCrop()">✅ Gunakan Foto Ini</button>
        <button type="button" class="btn-batal-crop" onclick="document.getElementById('modalCrop').style.display='none'">Batal</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script>
    let cropper = null;
    const fotoPicker = document.getElementById('fotoPicker');
    const cropImage = document.getElementById('cropImage');

    fotoPicker.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            cropImage.src = e.target.result;
            document.getElementById('modalCrop').style.display = 'flex';

            if (cropper) cropper.destroy();
            cropper = new Cropper(cropImage, {
                aspectRatio: 1,
                viewMode: 1,
                autoCropArea: 1,
                background: false,
            });
        };
        reader.readAsDataURL(file);
    });

    function simpanCrop() {
        if (!cropper) return;

        cropper.getCroppedCanvas({ width: 400, height: 400 }).toBlob(function (blob) {
            const file = new File([blob], 'foto-profil.jpg', { type: 'image/jpeg' });

            const dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('fotoFinal').files = dt.files;

            const url = URL.createObjectURL(blob);
            const preview = document.getElementById('previewFoto');
            preview.src = url;
            preview.style.display = 'block';
            document.getElementById('previewFotoKosong').style.display = 'none';

            document.getElementById('modalCrop').style.display = 'none';
        }, 'image/jpeg', 0.9);
    }

    window.addEventListener('click', function (event) {
        const modal = document.getElementById('modalCrop');
        if (event.target == modal) modal.style.display = 'none';
    });
</script>

</body>
</html>
