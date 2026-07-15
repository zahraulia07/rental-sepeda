<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Rental Sepeda</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background: linear-gradient(135deg, #f0fdf4 0%, #e0f2fe 100%); color: #1e293b; }
        .container { max-width: 700px; margin: auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0px 10px 30px rgba(15, 23, 42, 0.06); border: 1px solid #e2e8f0; margin-bottom: 24px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; font-size: 13px; color: #64748b; }
        .topbar .user-info b { color: #0f172a; }
        .topbar .role-badge { background: #dbeafe; color: #1d4ed8; font-weight: 700; padding: 2px 8px; border-radius: 4px; font-size: 11px; text-transform: uppercase; margin-left: 6px; }
        .btn-logout { background: transparent; color: #ef4444; border: 1px solid #fecaca; padding: 6px 14px; border-radius: 6px; font-size: 13px; cursor: pointer; }
        .btn-logout:hover { background: #fef2f2; }

        h2 { font-size: 20px; color: #0f172a; border-bottom: 3px solid #f1f5f9; padding-bottom: 16px; margin-bottom: 20px; }

        .alert { padding: 12px; background-color: #f0fdf4; color: #15803d; border-radius: 6px; margin-bottom: 20px; font-size: 14px; border-left: 5px solid #10b981; }
        .alert-gagal { padding: 12px; background-color: #fef2f2; color: #b91c1c; border-radius: 6px; margin-bottom: 20px; font-size: 14px; border-left: 5px solid #ef4444; }

        .form-group { margin-bottom: 16px; }
        label { display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #475569; }
        input { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; background: #f8fafc; }
        input:focus { outline: none; border-color: #10b981; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15); background: #fff; }
        input[disabled] { color: #94a3b8; background: #f1f5f9; }
        .error { color: #dc2626; font-size: 12px; margin-top: 4px; }

        .btn-simpan { background: #10b981; color: #fff; padding: 10px 20px; border: none; border-radius: 6px; font-weight: bold; font-size: 14px; cursor: pointer; }
        .btn-simpan:hover { background: #059669; }
        .hint { font-size: 12px; color: #94a3b8; margin-top: -10px; margin-bottom: 16px; }

        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.5); display: none; justify-content: center; align-items: center; z-index: 9999; }
        .modal-crop-box { background: #fff; padding: 22px; border-radius: 12px; width: 100%; max-width: 480px; border: 1px solid #e2e8f0; }
        .crop-img-wrap { max-height: 380px; overflow: hidden; background: #0f172a; border-radius: 8px; }
        .crop-img-wrap img { display: block; max-width: 100%; }
        .btn-simpan-crop { background: #10b981; color: #fff; width: 100%; padding: 10px; border: none; border-radius: 6px; font-weight: bold; margin-top: 16px; cursor: pointer; }
        .btn-batal-crop { background: #f1f5f9; color: #475569; width: 100%; padding: 9px; border: none; border-radius: 6px; margin-top: 8px; cursor: pointer; }
        .btn-pilih-foto { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; padding: 9px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; }
    </style>
</head>
<body>

<div class="container">
    <div class="topbar">
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
    <h2>👤 Edit Profil</h2>
    <form action="/profile" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group" style="text-align:center;">
            @if($user->foto_profil)
                <img id="previewFoto" src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil" style="width:90px;height:90px;object-fit:cover;border-radius:50%;border:2px solid #10b981; display:block; margin:0 auto;">
            @else
                <img id="previewFoto" src="" alt="Foto Profil" style="width:90px;height:90px;object-fit:cover;border-radius:50%;border:2px solid #10b981; display:none; margin:0 auto;">
            @endif
            <div id="previewFotoKosong" style="width:90px;height:90px;border-radius:50%;background:#f1f5f9;display:{{ $user->foto_profil ? 'none' : 'flex' }};align-items:center;justify-content:center;font-size:36px;margin:0 auto;">👤</div>
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
            <select name="jenis_kelamin" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; background: #f8fafc;">
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
    <h2>🔒 Ganti Kata Sandi</h2>
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
