<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengaturan Profil - Rental Sepeda</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
    <style>
        * { box-sizing: border-box; }
        :root {
            --emerald: #059669;
            --emerald-dark: #065f46;
            --emerald-soft: #ecfdf5;
            --ink: #0f172a;
            --slate: #475569;
            --muted: #64748b;
            --faint: #94a3b8;
            --border: #e5e7eb;
            --page-bg: #f7f9fb;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0; padding: 0;
            background: var(--page-bg);
            color: var(--ink);
        }
        a { color: inherit; }
        .wrap { max-width: 1160px; margin: 0 auto; padding: 0 24px; }

        /* ===== Top navbar ===== */
        .topnav { background: #fff; border-bottom: 1px solid var(--border); }
        .topnav-inner { max-width: 1160px; margin: 0 auto; padding: 16px 24px; display: flex; align-items: center; gap: 28px; }
        .brand { font-weight: 800; color: var(--emerald); font-size: 19px; text-decoration: none; flex-shrink: 0; }
        .nav-links { display: flex; align-items: center; gap: 26px; font-size: 14.5px; color: var(--ink); flex: 1; }
        .nav-links a { text-decoration: none; color: var(--ink); padding: 4px 0; }
        .nav-links a:hover { color: var(--emerald); }
        .nav-right { display: flex; align-items: center; gap: 18px; flex-shrink: 0; }

        .nav-bell-wrap { position: relative; }
        .nav-bell {
            background: none; border: none; font-size: 19px; cursor: pointer; color: var(--slate);
            position: relative; display: flex; align-items: center; justify-content: center; width: 30px; height: 30px;
        }
        .notif-badge {
            position: absolute; top: -3px; right: -3px; min-width: 17px; height: 17px; padding: 0 4px;
            border-radius: 999px; background: #ef4444; color: #fff; font-size: 10px; font-weight: 800;
            display: flex; align-items: center; justify-content: center; border: 1.5px solid #fff;
        }
        .notif-dropdown {
            position: absolute; top: calc(100% + 14px); right: -10px; z-index: 60;
            width: 320px; max-height: 380px; overflow-y: auto;
            background: #fff; border: 1px solid var(--border); border-radius: 16px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.14); padding: 8px;
            opacity: 0; visibility: hidden; transform: translateY(-8px);
            transition: all 0.18s ease;
        }
        .nav-bell-wrap.open .notif-dropdown { opacity: 1; visibility: visible; transform: translateY(0); }
        .notif-dropdown-head { padding: 8px 10px 10px; font-size: 13px; font-weight: 800; color: var(--ink); border-bottom: 1px solid var(--border); margin-bottom: 4px; }
        .notif-item { padding: 10px; border-radius: 10px; margin-bottom: 2px; }
        .notif-item.unread { background: var(--emerald-soft); }
        .notif-item .notif-judul { font-size: 12.5px; font-weight: 800; color: var(--ink); margin-bottom: 2px; display: flex; align-items: center; gap: 6px; }
        .notif-item.unread .notif-judul::before { content: ""; width: 7px; height: 7px; border-radius: 50%; background: var(--emerald); flex-shrink: 0; }
        .notif-item .notif-msg { font-size: 12px; color: var(--slate); line-height: 1.5; }
        .notif-item .notif-time { font-size: 10.5px; color: var(--faint); margin-top: 4px; font-weight: 700; text-transform: uppercase; }
        .notif-empty { padding: 24px 10px; text-align: center; font-size: 12.5px; color: var(--faint); }

        .nav-avatar-wrap { position: relative; }
        .nav-avatar-trigger { display: flex; align-items: center; gap: 8px; cursor: pointer; user-select: none; }
        .nav-avatar {
            width: 34px; height: 34px; border-radius: 50%; overflow: hidden; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, var(--emerald), #06b6d4); color: #fff; font-weight: 800; font-size: 13px;
            border: 2px solid var(--emerald-soft);
        }
        .nav-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .nav-avatar-name { font-size: 14px; font-weight: 700; color: var(--ink); }
        .nav-avatar-trigger .chevron { font-size: 11px; color: var(--muted); transition: transform 0.15s; }
        .nav-avatar-wrap.open .chevron { transform: rotate(180deg); }
        .nav-dropdown {
            position: absolute; top: calc(100% + 14px); right: 0; z-index: 60;
            min-width: 220px; background: #fff; border: 1px solid var(--border); border-radius: 16px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.14); padding: 8px;
            opacity: 0; visibility: hidden; transform: translateY(-8px);
            transition: all 0.18s ease;
        }
        .nav-avatar-wrap.open .nav-dropdown { opacity: 1; visibility: visible; transform: translateY(0); }
        .nav-dropdown a, .nav-dropdown button {
            display: flex; align-items: center; gap: 10px; text-decoration: none; width: 100%; text-align: left;
            padding: 9px 11px; border-radius: 10px; font-size: 13.5px; font-weight: 600;
            color: var(--slate); margin-bottom: 2px; background: none; border: none; cursor: pointer; font-family: inherit;
        }
        .nav-dropdown a:hover, .nav-dropdown button:hover { background: #f8fafc; color: var(--ink); }
        .nav-dropdown a.active { background: var(--emerald-soft); color: var(--emerald-dark); }
        .nav-dropdown .logout-btn { color: #ef4444; }
        .nav-dropdown .logout-btn:hover { background: #fef2f2; }

        /* ===== Page layout ===== */
        .page-body { padding: 40px 0 60px; }
        .layout { display: grid; grid-template-columns: 260px 1fr; gap: 24px; align-items: start; }

        .card { background: #fff; border: 1px solid var(--border); border-radius: 20px; }

        /* Sidebar */
        .side-card { padding: 12px; }
        .side-tab {
            display: flex; align-items: center; gap: 12px; padding: 12px 14px; border-radius: 12px;
            font-size: 14px; font-weight: 600; color: var(--slate); cursor: pointer; margin-bottom: 4px;
            border-left: 3px solid transparent; background: none; width: 100%; text-align: left; font-family: inherit;
        }
        .side-tab .ic { font-size: 16px; width: 18px; text-align: center; }
        .side-tab:hover { background: #f8fafc; }
        .side-tab.active { background: var(--emerald-soft); color: var(--emerald-dark); border-left-color: var(--emerald); font-weight: 700; }
        .side-divider { height: 1px; background: var(--border); margin: 8px 6px; }
        .side-tab.logout { color: #ef4444; }
        .side-tab.logout:hover { background: #fef2f2; }

        /* Content */
        .content-card { padding: 34px 38px 30px; }
        .content-title { font-size: 25px; font-weight: 800; color: var(--ink); margin: 0 0 6px; }
        .content-subtitle { font-size: 13.5px; color: var(--muted); margin: 0 0 26px; }

        .alert { padding: 12px 16px; background-color: var(--emerald-soft); color: #047857; border-radius: 12px; margin-bottom: 22px; font-size: 13.5px; border: 1px solid #a7f3d0; font-weight: 600; }
        .alert-gagal { padding: 12px 16px; background-color: #fef2f2; color: #b91c1c; border-radius: 12px; margin-bottom: 22px; font-size: 13.5px; border: 1px solid #fecaca; font-weight: 600; }

        .avatar-row { display: flex; align-items: center; gap: 22px; margin-bottom: 26px; }
        .avatar-photo-wrap { width: 84px; height: 84px; border-radius: 50%; border: 3px solid var(--emerald); padding: 3px; flex-shrink: 0; }
        .avatar-photo-wrap img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block; }
        .avatar-photo-empty { width: 100%; height: 100%; border-radius: 50%; background: var(--emerald-soft); display: flex; align-items: center; justify-content: center; font-size: 30px; }
        .avatar-actions label.field-label { display: block; margin-bottom: 8px; }
        .avatar-btns { display: flex; gap: 10px; }
        .btn-dark { background: var(--emerald-dark); color: #fff; border: none; padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 13.5px; cursor: pointer; }
        .btn-dark:hover { filter: brightness(1.08); }
        .btn-ghost-outline { background: #fff; color: var(--ink); border: 1px solid var(--border); padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 13.5px; cursor: pointer; }
        .btn-ghost-outline:hover { border-color: #cbd5e1; }
        .avatar-hint { font-size: 12px; color: var(--faint); margin: 8px 0 0; }

        .divider { height: 1px; background: var(--border); margin: 0 0 26px; }

        .field-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px 24px; }
        .field-label { display: block; margin-bottom: 7px; font-weight: 700; font-size: 13px; color: var(--ink); }
        .field-input {
            width: 100%; padding: 12px 14px; border: 1px solid var(--border); border-radius: 12px;
            font-size: 14px; background: #f9fafb; color: var(--ink); font-family: inherit;
        }
        .field-input:focus { outline: none; border-color: var(--emerald); box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.12); background: #fff; }
        select.field-input { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2364748b'%3E%3Cpath fill-rule='evenodd' d='M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z' clip-rule='evenodd'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; background-size: 16px; padding-right: 36px; }
        .error-text { color: #dc2626; font-size: 12px; margin-top: 5px; }

        .field-verified-wrap { display: flex; align-items: center; gap: 10px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 4px 6px 4px 14px; }
        .field-verified-wrap input { border: none; background: none; flex: 1; padding: 8px 0; font-size: 14px; color: var(--ink); font-family: inherit; }
        .field-verified-wrap input:focus { outline: none; }
        .badge-verified { background: var(--emerald-soft); color: var(--emerald-dark); font-size: 11.5px; font-weight: 800; padding: 5px 10px; border-radius: 999px; white-space: nowrap; display: flex; align-items: center; gap: 4px; }

        .phone-group { display: flex; border: 1px solid var(--border); border-radius: 12px; overflow: hidden; background: #f9fafb; }
        .phone-prefix { background: #eff6ff; color: var(--ink); font-weight: 700; padding: 12px 14px; border-right: 1px solid #bfdbfe; font-size: 14px; }
        .phone-group input { border: none; background: transparent; flex: 1; padding: 12px 14px; font-size: 14px; font-family: inherit; color: var(--ink); }
        .phone-group input:focus { outline: none; }
        .phone-group:focus-within { border-color: var(--emerald); box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.12); }

        .field-full { grid-column: 1 / -1; }
        textarea.field-input { resize: vertical; min-height: 84px; }

        .form-footer { display: flex; justify-content: flex-end; gap: 12px; margin-top: 30px; padding-top: 26px; border-top: 1px solid var(--border); }
        .form-footer .btn-dark, .form-footer .btn-ghost-outline { padding: 12px 26px; font-size: 14px; }

        /* ===== Footer ===== */
        .site-footer { border-top: 1px solid var(--border); background: #fff; padding: 34px 0; margin-top: 40px; }
        .footer-inner { max-width: 1160px; margin: 0 auto; padding: 0 24px; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px; }
        .footer-brand { font-weight: 800; color: var(--emerald); font-size: 18px; margin-bottom: 4px; }
        .footer-copy { font-size: 12.5px; color: var(--faint); }
        .footer-links { display: flex; gap: 22px; font-size: 13px; color: var(--slate); flex-wrap: wrap; }
        .footer-links a { text-decoration: underline; text-underline-offset: 3px; }
        .footer-links a:hover { color: var(--emerald); }

        @media (max-width: 820px) {
            .layout { grid-template-columns: 1fr; }
            .field-grid { grid-template-columns: 1fr; }
            .nav-links { display: none; }
            .content-card { padding: 26px 20px; }
        }
    </style>
</head>
<body>

@php
    $initialTab = 'edit';
    if ($errors->any()) {
        if ($errors->has('current_password') || $errors->has('password')) {
            $initialTab = 'password';
        } elseif ($errors->hasAny(['no_hp', 'no_ktp', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'alamat'])) {
            $initialTab = 'alamat';
        }
    }
@endphp

<nav class="topnav">
    <div class="topnav-inner">
        <a href="/dashboard" class="brand">Gowesin</a>
        <div class="nav-links">
            <a href="/dashboard#beranda">Beranda</a>
            <a href="/dashboard#katalog">Katalog Sepeda</a>
            <a href="/dashboard#riwayat">Riwayat Sewa</a>
            <a href="/tentang-kami">Tentang Kami</a>
        </div>
        <div class="nav-right">
            <div class="nav-bell-wrap" id="navBellWrap">
                <button type="button" class="nav-bell" onclick="toggleNotifDropdown(event)" title="Notifikasi">
                    🔔
                    @if($jumlahNotifBelumDibaca > 0)
                        <span class="notif-badge" id="notifBadge">{{ $jumlahNotifBelumDibaca > 9 ? '9+' : $jumlahNotifBelumDibaca }}</span>
                    @endif
                </button>
                <div class="notif-dropdown" id="notifDropdown">
                    <div class="notif-dropdown-head">🔔 Notifikasi</div>
                    @forelse($daftarNotifikasi as $notif)
                        <div class="notif-item {{ $notif->dibaca ? '' : 'unread' }}">
                            <div class="notif-judul">{{ $notif->judul }}</div>
                            <div class="notif-msg">{{ $notif->pesan }}</div>
                            <div class="notif-time">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</div>
                        </div>
                    @empty
                        <div class="notif-empty">Belum ada notifikasi.</div>
                    @endforelse
                </div>
            </div>
            <div class="nav-avatar-wrap" id="navAvatarWrap">
                <div class="nav-avatar-trigger" onclick="toggleUserNav(event)">
                    <div class="nav-avatar">
                        @if($user->foto_profil)
                            <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="{{ $user->name }}">
                        @else
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        @endif
                    </div>
                    <span class="nav-avatar-name">{{ explode(' ', $user->name)[0] }}</span>
                    <span class="chevron">⌄</span>
                </div>
                <div class="nav-dropdown" id="userNavDropdown">
                    <a href="/dashboard">🚲 Sewa Sepeda</a>
                    <a href="/profile" class="active">👤 Profil Saya</a>
                    <a href="/panduan">📖 Panduan Cara Sewa</a>
                    <a href="/syarat-ketentuan">📃 Syarat & Ketentuan</a>
                    <a href="/tentang-kami">ℹ️ Tentang Kami</a>
                    <form action="/logout" method="POST" onsubmit="return confirm('Keluar dari sistem?')">
                        @csrf
                        <button type="submit" class="logout-btn">🚪 Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="page-body">
    <div class="wrap layout">

        <div class="card side-card">
            <button type="button" class="side-tab {{ $initialTab === 'edit' ? 'active' : '' }}" id="tab-edit" onclick="switchTab('edit')">
                <span class="ic">👤</span> Edit Profil
            </button>
            <button type="button" class="side-tab {{ $initialTab === 'password' ? 'active' : '' }}" id="tab-password" onclick="switchTab('password')">
                <span class="ic">🔒</span> Ubah Kata Sandi
            </button>
            <button type="button" class="side-tab {{ $initialTab === 'alamat' ? 'active' : '' }}" id="tab-alamat" onclick="switchTab('alamat')">
                <span class="ic">🪪</span> Alamat & Kontak
            </button>
            <div class="side-divider"></div>
            <form action="/logout" method="POST" onsubmit="return confirm('Keluar dari sistem?')">
                @csrf
                <button type="submit" class="side-tab logout"><span class="ic">↩️</span> Keluar Sesi</button>
            </form>
        </div>

        <div class="card content-card">
            @if(session('sukses'))
                <div class="alert">✔️ {{ session('sukses') }}</div>
            @endif
            @if($errors->any())
                <div class="alert-gagal">⚠️ {{ $errors->first() }}</div>
            @endif

            <h1 class="content-title" id="pageTitle">
                {{ $initialTab === 'password' ? 'Ubah Kata Sandi' : ($initialTab === 'alamat' ? 'Alamat & Kontak' : 'Pengaturan Profil') }}
            </h1>
            <p class="content-subtitle" id="pageSubtitle">
                {{ $initialTab === 'password' ? 'Perbarui kata sandi akun Anda secara berkala demi keamanan.' : ($initialTab === 'alamat' ? 'Lengkapi data alamat & kontak untuk proses verifikasi penyewaan.' : 'Perbarui informasi pribadi dan preferensi akun Anda.') }}
            </p>

            {{-- ===== Form data profil (Edit Profil + Alamat & Kontak, satu form) ===== --}}
            <form action="/profile" method="POST" enctype="multipart/form-data" id="formProfil">
                @csrf
                @method('PUT')
                <input type="hidden" name="hapus_foto" id="hapusFotoInput" value="0">

                {{-- Panel: Edit Profil --}}
                <div id="panelEditProfil" style="display: {{ $initialTab === 'edit' ? 'block' : 'none' }};">
                    <div class="avatar-row">
                        <div class="avatar-photo-wrap">
                            @if($user->foto_profil)
                                <img id="previewFoto" src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil">
                            @else
                                <img id="previewFoto" src="" alt="Foto Profil" style="display:none;">
                            @endif
                            <div id="previewFotoKosong" class="avatar-photo-empty" style="display: {{ $user->foto_profil ? 'none' : 'flex' }};">👤</div>
                        </div>
                        <div class="avatar-actions">
                            <label class="field-label">Foto Profil</label>
                            <input type="file" id="fotoPicker" accept="image/*" style="display:none;">
                            <input type="file" id="fotoFinal" name="foto_profil" style="display:none;">
                            <div class="avatar-btns">
                                <button type="button" class="btn-dark" onclick="document.getElementById('fotoPicker').click()">Unggah Baru</button>
                                <button type="button" class="btn-ghost-outline" onclick="hapusFoto()">Hapus</button>
                            </div>
                            <p class="avatar-hint">Maksimal 2MB. Format: JPG, PNG, WEBP.</p>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div class="field-grid">
                        <div>
                            <label class="field-label">Nama Lengkap</label>
                            <input type="text" class="field-input" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div>
                            <label class="field-label">Username</label>
                            <input type="text" class="field-input" name="username" value="{{ old('username', $user->username) }}" required>
                        </div>
                        <div class="field-full">
                            <label class="field-label">Alamat Email</label>
                            <div class="field-verified-wrap">
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @if($user->email_verified_at)
                                    <span class="badge-verified">✓ Terverifikasi</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Panel: Alamat & Kontak --}}
                <div id="panelAlamatKontak" style="display: {{ $initialTab === 'alamat' ? 'block' : 'none' }};">
                    <div class="field-grid">
                        <div>
                            <label class="field-label">Nomor WhatsApp / Telepon</label>
                            <div class="phone-group">
                                <span class="phone-prefix">+62</span>
                                <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" required>
                            </div>
                        </div>
                        <div>
                            <label class="field-label">No. KTP</label>
                            <input type="text" class="field-input" name="no_ktp" value="{{ old('no_ktp', $user->no_ktp) }}" maxlength="16" required>
                        </div>
                        <div>
                            <label class="field-label">Tempat Lahir</label>
                            <input type="text" class="field-input" name="tempat_lahir" value="{{ old('tempat_lahir', $user->tempat_lahir) }}" required>
                        </div>
                        <div>
                            <label class="field-label">Tanggal Lahir</label>
                            <input type="date" class="field-input" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir ? $user->tanggal_lahir->format('Y-m-d') : '') }}" required>
                        </div>
                        <div>
                            <label class="field-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="field-input" required>
                                <option value="" disabled {{ old('jenis_kelamin', $user->jenis_kelamin) ? '' : 'selected' }}>Pilih jenis kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="field-full">
                            <label class="field-label">Alamat Lengkap</label>
                            <textarea class="field-input" name="alamat" required>{{ old('alamat', $user->alamat) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-footer" id="formProfilFooter" style="display: {{ $initialTab === 'password' ? 'none' : 'flex' }};">
                    <a href="/profile" class="btn-ghost-outline" style="text-decoration:none; display:inline-flex; align-items:center;">Batal</a>
                    <button type="submit" class="btn-dark">Simpan Perubahan</button>
                </div>
            </form>

            {{-- ===== Form ganti kata sandi ===== --}}
            <form action="/profile/password" method="POST" id="formPassword" style="display: {{ $initialTab === 'password' ? 'block' : 'none' }};">
                @csrf
                @method('PUT')
                <div class="field-grid">
                    <div class="field-full">
                        <label class="field-label">Kata Sandi Saat Ini</label>
                        <input type="password" class="field-input" name="current_password" required>
                    </div>
                    <div>
                        <label class="field-label">Kata Sandi Baru</label>
                        <input type="password" class="field-input" name="password" required minlength="6">
                    </div>
                    <div>
                        <label class="field-label">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" class="field-input" name="password_confirmation" required minlength="6">
                    </div>
                </div>
                <div class="form-footer">
                    <a href="/profile" class="btn-ghost-outline" style="text-decoration:none; display:inline-flex; align-items:center;">Batal</a>
                    <button type="submit" class="btn-dark">Perbarui Kata Sandi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<footer class="site-footer">
    <div class="footer-inner">
        <div>
            <div class="footer-brand">Gowesin</div>
            <div class="footer-copy">© {{ date('Y') }} Gowesin. Urban Mobility & Freshness.</div>
        </div>
        <div class="footer-links">
            <a href="/syarat-ketentuan">Kebijakan Privasi</a>
            <a href="/syarat-ketentuan">Syarat & Ketentuan</a>
            <a href="/panduan">Bantuan</a>
            <a href="/tentang-kami">Kontak</a>
        </div>
    </div>
</footer>

<div class="modal-overlay" id="modalCrop" style="position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(15,23,42,0.5); display:none; justify-content:center; align-items:center; z-index:9999; backdrop-filter: blur(2px);">
    <div style="background:#fff; padding:24px; border-radius:20px; width:100%; max-width:480px; border:1px solid #eef2f7; box-shadow: 0 20px 50px rgba(15,23,42,0.25);">
        <h3 style="margin-top:0;">✂️ Crop Foto Profil</h3>
        <div style="max-height:380px; overflow:hidden; background:#0f172a; border-radius:14px;">
            <img id="cropImage" src="" alt="Crop" style="display:block; max-width:100%;">
        </div>
        <button type="button" class="btn-dark" style="width:100%; padding:11px; margin-top:16px;" onclick="simpanCrop()">✅ Gunakan Foto Ini</button>
        <button type="button" class="btn-ghost-outline" style="width:100%; padding:10px; margin-top:8px;" onclick="document.getElementById('modalCrop').style.display='none'">Batal</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script>
    // ===== Tab switching sidebar =====
    function switchTab(tab) {
        document.querySelectorAll('.side-tab').forEach(el => el.classList.remove('active'));
        document.getElementById('tab-' + tab).classList.add('active');

        document.getElementById('panelEditProfil').style.display = tab === 'edit' ? 'block' : 'none';
        document.getElementById('panelAlamatKontak').style.display = tab === 'alamat' ? 'block' : 'none';
        document.getElementById('formProfilFooter').style.display = (tab === 'edit' || tab === 'alamat') ? 'flex' : 'none';
        document.getElementById('formPassword').style.display = tab === 'password' ? 'block' : 'none';

        const titles = { edit: 'Pengaturan Profil', alamat: 'Alamat & Kontak', password: 'Ubah Kata Sandi' };
        const subtitles = {
            edit: 'Perbarui informasi pribadi dan preferensi akun Anda.',
            alamat: 'Lengkapi data alamat & kontak untuk proses verifikasi penyewaan.',
            password: 'Perbarui kata sandi akun Anda secara berkala demi keamanan.',
        };
        document.getElementById('pageTitle').innerText = titles[tab];
        document.getElementById('pageSubtitle').innerText = subtitles[tab];
    }

    // ===== Dropdown avatar =====
    function toggleUserNav(event) {
        event.stopPropagation();
        document.getElementById('navAvatarWrap').classList.toggle('open');
    }
    document.addEventListener('click', function (event) {
        const wrap = document.getElementById('navAvatarWrap');
        if (wrap && !wrap.contains(event.target)) wrap.classList.remove('open');
    });

    // ===== Dropdown notifikasi =====
    function toggleNotifDropdown(event) {
        event.stopPropagation();
        const wrap = document.getElementById('navBellWrap');
        const willOpen = !wrap.classList.contains('open');
        wrap.classList.toggle('open');

        if (willOpen) {
            const badge = document.getElementById('notifBadge');
            if (badge) badge.remove();

            fetch('/notifikasi/tandai-dibaca', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            }).then(() => {
                document.querySelectorAll('.notif-item.unread').forEach(el => el.classList.remove('unread'));
            }).catch(() => {});
        }
    }
    document.addEventListener('click', function (event) {
        const bellWrap = document.getElementById('navBellWrap');
        if (bellWrap && !bellWrap.contains(event.target)) bellWrap.classList.remove('open');
    });

    // ===== Upload & crop foto profil =====
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
            document.getElementById('hapusFotoInput').value = '0';

            document.getElementById('modalCrop').style.display = 'none';
        }, 'image/jpeg', 0.9);
    }

    function hapusFoto() {
        document.getElementById('previewFoto').style.display = 'none';
        document.getElementById('previewFoto').src = '';
        document.getElementById('previewFotoKosong').style.display = 'flex';
        document.getElementById('fotoFinal').value = '';
        document.getElementById('hapusFotoInput').value = '1';
    }

    window.addEventListener('click', function (event) {
        const modal = document.getElementById('modalCrop');
        if (event.target == modal) modal.style.display = 'none';
    });
</script>

</body>
</html>
