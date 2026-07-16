<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Rental Sepeda</title>
    <style>
        * { box-sizing: border-box; }
        :root {
            --green: #10b981;
            --cyan: #06b6d4;
            --gradient: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
            --ink: #0f172a;
            --slate: #475569;
            --muted: #64748b;
            --faint: #94a3b8;
            --border: #eef2f7;
            --bg: #f4f8fb;
        }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0; padding: 0;
            background-color: var(--bg);
            background-image:
                radial-gradient(circle at 8% 8%, rgba(16, 185, 129, 0.16), transparent 32%),
                radial-gradient(circle at 92% 18%, rgba(6, 182, 212, 0.16), transparent 34%),
                radial-gradient(circle at 50% 95%, rgba(245, 158, 11, 0.10), transparent 38%);
            background-attachment: fixed;
            color: #1e293b;
        }
        a { color: inherit; }
        .wrap { max-width: 1120px; margin: 0 auto; padding: 0 24px; }

        /* ===== Navbar ===== */
        .navbar {
            position: sticky; top: 0; z-index: 100;
            background: rgba(255,255,255,0.92); backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--border);
        }
        .navbar-inner { max-width: 1120px; margin: 0 auto; padding: 14px 24px; display: flex; align-items: center; gap: 22px; }
        .brand { display: flex; align-items: center; gap: 8px; font-weight: 800; color: var(--ink); font-size: 17px; text-decoration: none; flex-shrink: 0; }
        .brand .dot { width: 11px; height: 11px; border-radius: 50%; background: var(--gradient); }
        .nav-links { display: flex; align-items: center; gap: 22px; font-size: 13.5px; font-weight: 700; color: var(--muted); flex: 1; }
        .nav-links a { text-decoration: none; color: var(--muted); padding: 6px 2px; border-bottom: 2px solid transparent; transition: all 0.15s; }
        .nav-links a:hover, .nav-links a.active { color: var(--ink); border-bottom-color: var(--green); }
        .nav-search {
            display: flex; align-items: center; gap: 8px;
            background: #f8fafc; border: 1px solid var(--border); border-radius: 999px;
            padding: 9px 16px; font-size: 13px; color: var(--faint); min-width: 200px;
        }
        .nav-search input { border: none; background: transparent; outline: none; font-size: 13px; width: 100%; color: var(--ink); }
        .nav-right { display: flex; align-items: center; gap: 14px; flex-shrink: 0; }
        .nav-bell {
            width: 38px; height: 38px; border-radius: 50%; border: 1px solid var(--border); background: #fff;
            display: flex; align-items: center; justify-content: center; position: relative; cursor: default; font-size: 15px;
        }
        .nav-bell .ping { position: absolute; top: 8px; right: 9px; width: 7px; height: 7px; border-radius: 50%; background: #ef4444; border: 1.5px solid #fff; }
        .nav-avatar-wrap { position: relative; }
        .nav-avatar {
            width: 38px; height: 38px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;
            background: var(--gradient); color: #fff; font-weight: 800; font-size: 14px; overflow: hidden; border: 2px solid #fff;
            box-shadow: 0 4px 10px rgba(16,185,129,0.3);
        }
        .nav-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .nav-dropdown {
            position: absolute; top: calc(100% + 12px); right: 0; z-index: 60;
            min-width: 240px; background: #fff; border: 1px solid var(--border); border-radius: 18px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.16); padding: 8px;
            opacity: 0; visibility: hidden; transform: translateY(-8px);
            transition: all 0.18s ease;
        }
        .nav-avatar-wrap.open .nav-dropdown { opacity: 1; visibility: visible; transform: translateY(0); }
        .nav-dropdown .who { padding: 10px 12px 12px; border-bottom: 1px solid var(--border); margin-bottom: 6px; }
        .nav-dropdown .who b { display: block; font-size: 13.5px; color: var(--ink); }
        .nav-dropdown .who span { font-size: 11px; color: var(--faint); text-transform: uppercase; font-weight: 700; letter-spacing: 0.3px; }
        .nav-dropdown a, .nav-dropdown button {
            display: flex; align-items: center; gap: 10px; text-decoration: none; width: 100%; text-align: left;
            padding: 10px 12px; border-radius: 12px; font-size: 13.5px; font-weight: 700;
            color: var(--slate); margin-bottom: 2px; transition: all 0.15s ease; background: none; border: none; cursor: pointer; font-family: inherit;
        }
        .nav-dropdown a:hover, .nav-dropdown button:hover { background: #f8fafc; color: var(--ink); }
        .nav-dropdown a.active { background: var(--gradient); color: #fff; }
        .nav-dropdown .logout-btn { color: #ef4444; }
        .nav-dropdown .logout-btn:hover { background: #fef2f2; color: #dc2626; }
        .nav-dropdown .menu-icon { font-size: 15px; width: 18px; text-align: center; flex-shrink: 0; }

        /* ===== Hero ===== */
        .hero {
            padding: 56px 0 64px;
        }
        .hero-grid { display: grid; grid-template-columns: 1.05fr 0.95fr; gap: 48px; align-items: center; }
        .hero-badge {
            display: inline-block; background: #d1fae5; color: #047857; font-weight: 700; font-size: 12px;
            padding: 6px 16px; border-radius: 999px; margin-bottom: 18px; letter-spacing: 0.2px;
        }
        .hero-copy h1 { font-size: 40px; line-height: 1.15; margin: 0 0 16px; color: var(--ink); font-weight: 800; }
        .hero-copy h1 .accent { background: var(--gradient); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .hero-copy p { font-size: 15px; color: var(--muted); line-height: 1.6; margin: 0 0 26px; max-width: 460px; }
        .hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }
        .btn-primary {
            background: var(--gradient); color: #fff; border: none; padding: 14px 26px; border-radius: 14px;
            font-weight: 700; font-size: 14px; cursor: pointer; text-decoration: none; display: inline-block;
            box-shadow: 0 10px 22px rgba(16,185,129,0.28); transition: filter 0.15s;
        }
        .btn-primary:hover { filter: brightness(1.05); }
        .btn-outline {
            background: #fff; color: var(--ink); border: 1px solid #dbe3ea; padding: 14px 26px; border-radius: 14px;
            font-weight: 700; font-size: 14px; cursor: pointer; text-decoration: none; display: inline-block; transition: all 0.15s;
        }
        .btn-outline:hover { border-color: var(--green); color: #047857; }

        .hero-visual { position: relative; }
        .hero-photo {
            position: relative; border-radius: 26px; overflow: hidden;
            background: var(--gradient);
            aspect-ratio: 4 / 3.4; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 20px 50px rgba(15,23,42,0.16);
        }
        .hero-photo::before { content: ""; position: absolute; top: -60px; right: -50px; width: 220px; height: 220px; background: rgba(255,255,255,0.14); border-radius: 50%; }
        .hero-photo::after { content: ""; position: absolute; bottom: -80px; left: -40px; width: 200px; height: 200px; background: rgba(255,255,255,0.10); border-radius: 50%; }
        .hero-photo .emoji { font-size: 120px; position: relative; z-index: 1; filter: drop-shadow(0 12px 18px rgba(0,0,0,0.18)); }
        .hero-float {
            position: absolute; left: 24px; bottom: -22px; z-index: 2;
            background: #fff; border-radius: 16px; padding: 12px 18px 12px 14px; display: flex; align-items: center; gap: 12px;
            box-shadow: 0 16px 34px rgba(15,23,42,0.16); border: 1px solid var(--border); max-width: 260px;
        }
        .hero-float .ic {
            width: 36px; height: 36px; border-radius: 50%; background: #d1fae5; color: #047857;
            display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;
        }
        .hero-float .txt span { display: block; font-size: 10.5px; color: var(--faint); font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px; }
        .hero-float .txt b { font-size: 13.5px; color: var(--ink); }

        /* ===== Section heading ===== */
        .section-heading { text-align: center; margin-bottom: 28px; }
        .section-heading h2 { font-size: 26px; color: var(--ink); margin: 0; font-weight: 800; }
        .section-kicker { color: #047857; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 6px; display: block; }

        /* ===== Search & filter ===== */
        .search-section { padding: 6px 0 44px; }
        .search-box {
            display: flex; align-items: center; gap: 10px; background: #fff; border: 1px solid var(--border);
            border-radius: 999px; padding: 16px 22px; box-shadow: 0 8px 24px rgba(15,23,42,0.05); max-width: 640px; margin: 0 auto 22px;
        }
        .search-box .ic { color: var(--faint); font-size: 15px; }
        .search-box input { flex: 1; border: none; outline: none; font-size: 14px; color: var(--ink); background: transparent; }
        .search-box select {
            border: none; border-left: 1px solid var(--border); outline: none; font-size: 12.5px; color: var(--muted);
            background: transparent; padding-left: 12px; font-weight: 700; cursor: pointer;
        }
        .search-box button { border: none; background: var(--gradient); color: #fff; font-weight: 700; font-size: 12.5px; padding: 9px 18px; border-radius: 999px; cursor: pointer; }

        .pill-row { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
        .pill {
            padding: 9px 20px; border-radius: 999px; font-size: 13px; font-weight: 700; text-decoration: none;
            border: 1px solid var(--border); color: var(--slate); background: #fff; transition: all 0.15s;
        }
        .pill:hover { border-color: var(--green); color: #047857; }
        .pill.active { background: var(--gradient); color: #fff; border-color: transparent; box-shadow: 0 6px 14px rgba(16,185,129,0.28); }

        /* ===== Catalog ===== */
        .catalog-section { padding: 8px 0 56px; }
        .catalog-topline { display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 22px; flex-wrap: wrap; gap: 8px; }
        .catalog-topline .kicker-block span.section-kicker { margin-bottom: 4px; }
        .catalog-topline h2 { font-size: 24px; margin: 0; color: var(--ink); font-weight: 800; }

        .grid-sepeda { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 20px; align-items: stretch; }
        .card-sepeda {
            border: 1px solid var(--border); border-radius: 20px; padding: 16px; background: #fff;
            display: flex; flex-direction: column; transition: all 0.2s ease; box-shadow: 0 2px 10px rgba(15,23,42,0.03);
        }
        .card-sepeda:hover { transform: translateY(-4px); box-shadow: 0 16px 30px rgba(15,23,42,0.10); border-color: #d1fae5; }
        .card-sepeda.card-nonaktif { background: #f8fafc; opacity: 0.75; }
        .card-sepeda.card-nonaktif:hover { transform: none; box-shadow: 0 2px 10px rgba(15,23,42,0.03); }
        .card-sepeda .foto-wrap { position: relative; margin-bottom: 12px; }
        .card-sepeda .foto { width: 100%; height: 150px; object-fit: cover; border-radius: 14px; display: block; background: #e2e8f0; }
        .card-sepeda .foto-kosong { width: 100%; height: 150px; border-radius: 14px; background: linear-gradient(135deg, #ecfeff, #f0fdf4); display: flex; align-items: center; justify-content: center; font-size: 42px; }
        .card-sepeda .status-chip { position: absolute; top: 10px; right: 10px; font-size: 10.5px; font-weight: 800; padding: 4px 11px; border-radius: 999px; background: #fff; box-shadow: 0 4px 10px rgba(15,23,42,0.12); }
        .status-chip.chip-tersedia { color: #047857; }
        .status-chip.chip-maintenance { color: #b45309; }
        .status-chip.chip-disewa { color: #6d28d9; }
        .status-chip.chip-habis { color: #b91c1c; }
        .card-sepeda .kategori { font-size: 10.5px; color: #4338ca; background: #eef2ff; display: inline-block; padding: 3px 10px; border-radius: 999px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px; margin-bottom: 8px; }
        .card-sepeda h3 { margin: 0 0 8px; font-size: 15.5px; color: var(--ink); line-height: 1.3; }
        .card-sepeda .harga { font-size: 13px; color: var(--slate); margin-bottom: 2px; }
        .card-sepeda .harga b { color: var(--ink); font-size: 14.5px; }
        .card-sepeda .stok { font-size: 11.5px; color: var(--faint); margin-top: 4px; font-weight: 600; }

        .form-sewa { margin-top: auto; padding-top: 14px; display: flex; flex-direction: column; gap: 8px; }
        .btn-sewa { padding: 12px; border: none; border-radius: 12px; background: var(--gradient); color: #fff; font-weight: 700; font-size: 13.5px; cursor: pointer; box-shadow: 0 8px 18px rgba(16,185,129,0.28); }
        .btn-sewa:hover { filter: brightness(1.05); }
        .btn-sewa-disabled { margin-top: auto; padding: 12px; border: none; border-radius: 12px; background: #e2e8f0; color: #94a3b8; font-weight: 700; font-size: 13.5px; cursor: not-allowed; text-align: center; }
        .empty-state { text-align: center; color: var(--faint); padding: 30px 0; font-size: 14px; }

        /* ===== Generic content container (riwayat, status aktif, alerts) ===== */
        .container {
            max-width: 1120px;
            margin: 0 auto 24px;
            background: #ffffff;
            padding: 32px;
            border-radius: 24px;
            box-shadow: 0px 14px 40px rgba(15, 23, 42, 0.07);
            border: 1px solid var(--border);
        }
        .section-title { display: flex; align-items: center; gap: 10px; border-bottom: 2px solid #f1f5f9; padding-bottom: 16px; margin-bottom: 20px; }
        .section-title h2 { margin: 0; font-size: 19px; color: var(--ink); }

        .alert { padding: 13px 16px; background-color: #ecfdf5; color: #047857; border-radius: 12px; margin-bottom: 20px; font-size: 14px; border: 1px solid #a7f3d0; font-weight: 600; }
        .alert-gagal { padding: 13px 16px; background-color: #fef2f2; color: #b91c1c; border-radius: 12px; margin-bottom: 20px; font-size: 14px; border: 1px solid #fecaca; font-weight: 600; }
        .alert-blokir { padding: 16px; background-color: #fef2f2; color: #b91c1c; border-radius: 14px; margin-bottom: 20px; font-size: 14px; border: 1px solid #fecaca; text-align: center; font-weight: 700; }

        .table-wrap { border: 1px solid var(--border); border-radius: 16px; overflow: hidden; margin-top: 6px; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 14px; font-size: 13px; border-bottom: 1px solid #f1f5f9; }
        th { background-color: #f8fafc; color: var(--muted); font-weight: 700; text-transform: uppercase; font-size: 11px; letter-spacing: 0.3px; }
        td { background-color: #ffffff; color: #1e293b; }
        tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background-color: #f8fafc; }

        .status-badge { font-weight: 700; padding: 4px 11px; border-radius: 999px; font-size: 11.5px; white-space: nowrap; }
        .status-pending { color: #b45309; background-color: #fef3c7; }
        .status-disetujui { color: #1d4ed8; background-color: #dbeafe; }
        .status-sedang-disewa { color: #6d28d9; background-color: #ede9fe; }
        .status-selesai { color: #047857; background-color: #d1fae5; }
        .status-ditolak { color: #dc2626; background-color: #fef2f2; }
        .denda-tag { color: #dc2626; font-weight: 700; }

        .btn-upload { padding: 7px 14px; border: none; border-radius: 999px; background: linear-gradient(135deg, #0ea5e9, #06b6d4); color: #fff; font-size: 12px; cursor: pointer; font-weight: 700; }
        .btn-nota { padding: 7px 14px; border: none; border-radius: 999px; background: linear-gradient(135deg, #10b981, #059669); color: #fff; font-size: 12px; text-decoration: none; font-weight: 700; display: inline-block; }
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.45); display: none; justify-content: center; align-items: center; z-index: 9999; backdrop-filter: blur(2px); }
        .modal-box { background: #fff; padding: 26px; border-radius: 20px; width: 100%; max-width: 440px; max-height: 88vh; overflow-y: auto; border: 1px solid var(--border); box-shadow: 0 20px 50px rgba(15,23,42,0.25); }
        .modal-box h3 { display: flex; align-items: center; gap: 8px; }
        .modal-box label { display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; color: var(--slate); }
        .modal-box select, .modal-box input { width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 13px; margin-bottom: 14px; box-sizing: border-box; }
        .form-sewa label.tnc-check { display: flex; align-items: flex-start; gap: 6px; font-size: 11px; color: var(--muted); line-height: 1.4; }
        .form-sewa label.tnc-check input { width: auto; margin-top: 2px; }
        .form-sewa label.tnc-check a { color: #2563eb; }
        .btn-kirim { background: var(--gradient); color: #fff; width: 100%; padding: 12px; border: none; border-radius: 12px; font-weight: 700; box-shadow: 0 8px 18px rgba(16,185,129,0.28); }
        .btn-batal { background: #f1f5f9; color: var(--slate); width: 100%; padding: 10px; border: none; border-radius: 12px; margin-top: 8px; font-weight: 700; }

        .status-aktif-card { border: none; border-radius: 18px; padding: 22px; background: linear-gradient(135deg, #ede9fe, #ecfeff); margin-bottom: 10px; }
        .status-aktif-card .judul { font-size: 11.5px; font-weight: 800; color: #6d28d9; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.3px; }
        .status-aktif-card .isi { font-size: 16px; color: var(--ink); font-weight: 700; margin-bottom: 4px; }
        .status-aktif-card .sub { font-size: 13px; color: var(--muted); }
        .countdown { font-size: 21px; font-weight: 800; color: #6d28d9; margin-top: 10px; letter-spacing: 0.5px; }
        .countdown.telat { color: #dc2626; }

        .payment-info { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 14px; padding: 16px; margin-bottom: 16px; }
        .payment-total { font-size: 14px; color: var(--slate); margin-bottom: 12px; }
        .payment-total b { color: var(--ink); font-size: 17px; }
        .payment-tabs { display: flex; gap: 10px; margin-bottom: 12px; flex-wrap: wrap; }
        .payment-method-box { flex: 1; min-width: 140px; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 12px; }
        .payment-label { font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 6px; }
        .payment-value { font-size: 12px; color: #334155; line-height: 1.5; }
        .payment-value .rekening { font-size: 15px; font-weight: 800; color: var(--green); letter-spacing: 0.5px; }
        .qris-box { background: #f1f5f9; border-radius: 10px; text-align: center; padding: 14px 6px; font-weight: 700; color: var(--slate); font-size: 12px; letter-spacing: 1px; }
        .qris-box small { display: block; font-weight: 400; color: var(--faint); margin-top: 4px; letter-spacing: normal; }
        .payment-deadline { font-size: 12px; color: var(--muted); border-top: 1px dashed #bbf7d0; padding-top: 10px; }
        .countdown-bayar { font-size: 16px; font-weight: 800; color: #b45309; margin-top: 4px; }
        .countdown-bayar.telat { color: #dc2626; }

        /* ===== Footer ===== */
        .site-footer { border-top: 1px solid var(--border); background: #fff; margin-top: 32px; padding: 44px 0 26px; }
        .footer-grid { display: flex; justify-content: space-between; gap: 32px; flex-wrap: wrap; margin-bottom: 30px; }
        .footer-brand .brand { margin-bottom: 8px; }
        .footer-brand p { font-size: 12.5px; color: var(--faint); max-width: 260px; line-height: 1.6; margin: 0; }
        .footer-cols { display: flex; gap: 56px; flex-wrap: wrap; }
        .footer-col h4 { font-size: 13px; color: var(--ink); margin: 0 0 12px; }
        .footer-col a { display: block; font-size: 12.5px; color: var(--muted); text-decoration: underline; margin-bottom: 8px; }
        .footer-bottom { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border); padding-top: 20px; flex-wrap: wrap; gap: 12px; }
        .footer-bottom small { color: var(--faint); font-size: 12px; }
        .social-row { display: flex; gap: 10px; }
        .social-row a { width: 34px; height: 34px; border-radius: 50%; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; font-size: 14px; text-decoration: none; color: var(--muted); }

        @media (max-width: 860px) {
            .hero-grid { grid-template-columns: 1fr; }
            .nav-links, .nav-search { display: none; }
            .hero-copy h1 { font-size: 30px; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="navbar-inner">
        <a href="#beranda" class="brand"><span class="dot"></span> Gowesin</a>
        <div class="nav-links">
            <a href="#beranda" class="active">Beranda</a>
            <a href="#katalog">Katalog Sepeda</a>
            <a href="#riwayat">Riwayat Sewa</a>
            <a href="/panduan">Tentang Kami</a>
        </div>
        <form action="/dashboard" method="GET" class="nav-search">
            <span class="ic">🔍</span>
            <input type="text" name="cari" placeholder="Cari sepeda..." value="{{ request('cari') }}">
        </form>
        <div class="nav-right">
            <span class="nav-bell" title="Notifikasi">🔔<span class="ping"></span></span>
            <div class="nav-avatar-wrap" id="navAvatarWrap">
                <div class="nav-avatar" onclick="toggleUserNav(event)">
                    @if(Auth::user()->foto_profil)
                        <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="{{ Auth::user()->name }}">
                    @else
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    @endif
                </div>
                <div class="nav-dropdown" id="userNavDropdown">
                    <div class="who">
                        <b>{{ Auth::user()->name }}</b>
                        <span>{{ Auth::user()->role }}</span>
                    </div>
                    @php
                        $userMenuItems = [
                            ['url' => '/dashboard', 'match' => 'dashboard', 'icon' => '🚲', 'label' => 'Sewa Sepeda'],
                            ['url' => '/profile', 'match' => 'profile', 'icon' => '👤', 'label' => 'Profil Saya'],
                            ['url' => '/panduan', 'match' => 'panduan', 'icon' => '📖', 'label' => 'Panduan Cara Sewa'],
                            ['url' => '/syarat-ketentuan', 'match' => 'syarat-ketentuan', 'icon' => '📃', 'label' => 'Syarat & Ketentuan'],
                        ];
                    @endphp
                    @foreach($userMenuItems as $item)
                        <a href="{{ $item['url'] }}" class="{{ request()->is($item['match']) ? 'active' : '' }}">
                            <span class="menu-icon">{{ $item['icon'] }}</span> {{ $item['label'] }}
                        </a>
                    @endforeach
                    <form action="/logout" method="POST" onsubmit="return confirm('Keluar dari sistem?')">
                        @csrf
                        <button type="submit" class="logout-btn"><span class="menu-icon">🚪</span> Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<section class="hero" id="beranda">
    <div class="wrap hero-grid">
        <div class="hero-copy">
            <span class="hero-badge">Solusi Bersepeda Urban</span>
            <h1>Gowesin Aja! Jelajahi Kota dengan <span class="accent">Sepeda Pilihanmu.</span></h1>
            <p>Sewa sepeda dengan mudah, cepat, dan harga terjangkau langsung dari genggamanmu. Rasakan kebebasan berkendara tanpa batas.</p>
            <div class="hero-actions">
                <a href="#katalog" class="btn-primary">Mulai Gowes Sekarang</a>
                <a href="/panduan" class="btn-outline">Lihat Tutorial</a>
            </div>
        </div>
        <div class="hero-visual">
            <div class="hero-photo">
                <span class="emoji">🚲</span>
            </div>
            @php $sepedaUnggulan = $sepedaTersedia->first(); @endphp
            <div class="hero-float">
                <span class="ic">⚡</span>
                <div class="txt">
                    <span>Populer Minggu Ini</span>
                    <b>{{ $sepedaUnggulan->tipe ?? 'Cari sepeda favoritmu' }}</b>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="search-section">
    <div class="wrap">
        <div class="section-heading">
            <h2>Temukan Teman Perjalananmu</h2>
        </div>

        <form method="GET" action="/dashboard#katalog" class="search-box">
            <span class="ic">🔍</span>
            <input type="text" name="cari" placeholder="Cari sepeda impianmu..." value="{{ request('cari') }}">
            <select name="status">
                <option value="">Semua Status</option>
                <option value="Tersedia" {{ request('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="Disewa" {{ request('status') == 'Disewa' ? 'selected' : '' }}>Disewa</option>
                <option value="Maintenance" {{ request('status') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>
            @if(request('kategori'))
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
            @endif
            <button type="submit">Cari</button>
        </form>

        <div class="pill-row">
            <a href="/dashboard#katalog" class="pill {{ !request('kategori') ? 'active' : '' }}">Semua</a>
            @foreach($daftarKategori as $kategori)
                <a href="{{ '/dashboard?kategori=' . urlencode($kategori) . (request('cari') ? '&cari=' . urlencode(request('cari')) : '') }}#katalog"
                   class="pill {{ request('kategori') == $kategori ? 'active' : '' }}">{{ $kategori }}</a>
            @endforeach
        </div>
    </div>
</section>

<section class="catalog-section" id="katalog">
    <div class="wrap">

        @if(session('sukses'))
            <div class="alert">✔️ {{ session('sukses') }}</div>
        @endif
        @if(session('gagal'))
            <div class="alert-gagal">⚠️ {{ session('gagal') }}</div>
        @endif
        @if(Auth::user()->is_blocked)
            <div class="alert-blokir">
                🚫 Akun Anda diblokir dan tidak dapat mengajukan sewa baru.
                @if(Auth::user()->alasan_blokir) <br>Alasan: {{ Auth::user()->alasan_blokir }} @endif
            </div>
        @endif

        <div class="catalog-topline">
            <div class="kicker-block">
                <span class="section-kicker">Katalog Pilihan</span>
                <h2>Tersedia Saat Ini</h2>
            </div>
        </div>

        @if($sepedaTersedia->isEmpty())
            <div class="empty-state">Tidak ada sepeda yang cocok dengan filter.</div>
        @else
            <div class="grid-sepeda">
                @foreach($sepedaTersedia as $sepeda)
                @php
                    $bisaSewa = $sepeda->status === 'Tersedia' && $sepeda->stok > 0;
                    $chipClass = match(true) {
                        $sepeda->status === 'Tersedia' && $sepeda->stok > 0 => 'chip-tersedia',
                        $sepeda->status === 'Tersedia' && $sepeda->stok <= 0 => 'chip-habis',
                        $sepeda->status === 'Maintenance' => 'chip-maintenance',
                        $sepeda->status === 'Disewa' => 'chip-disewa',
                        default => 'chip-habis',
                    };
                    $labelStatus = ($sepeda->status === 'Tersedia' && $sepeda->stok <= 0) ? 'Stok Habis' : $sepeda->status;
                @endphp
                <div class="card-sepeda {{ $bisaSewa ? '' : 'card-nonaktif' }}">
                    <div class="foto-wrap">
                        @if($sepeda->gambar)
                            <img src="{{ asset('storage/' . $sepeda->gambar) }}" alt="{{ $sepeda->tipe }}" class="foto">
                        @else
                            <div class="foto-kosong">🚲</div>
                        @endif
                        <span class="status-chip {{ $chipClass }}">{{ $labelStatus }}</span>
                    </div>
                    <div class="kategori">{{ $sepeda->kategori }}</div>
                    <h3>{{ $sepeda->tipe }}</h3>
                    <div class="harga">Per Jam: <b>Rp {{ number_format($sepeda->harga_per_jam, 0, ',', '.') }}</b></div>
                    <div class="harga">Per Hari: <b>Rp {{ number_format($sepeda->harga_per_hari, 0, ',', '.') }}</b></div>
                    <div class="stok">Stok tersedia: {{ $sepeda->stok }} unit</div>

                    @if(!$bisaSewa)
                        <div class="btn-sewa-disabled">
                            {{ $sepeda->status === 'Maintenance' ? 'Sedang Maintenance' : ($sepeda->status === 'Disewa' ? 'Sedang Disewa' : 'Stok Habis') }}
                        </div>
                    @elseif(!Auth::user()->is_blocked)
                    <div class="form-sewa">
                        <button type="button" class="btn-sewa" onclick="openSewa({{ $sepeda->id_sepeda }}, '{{ addslashes($sepeda->tipe) }}', {{ $sepeda->harga_per_jam }}, {{ $sepeda->harga_per_hari }})">Sewa Sekarang</button>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@php
    $statusAktif = $riwayatSewa->whereIn('status', ['Pending', 'Disetujui', 'Sedang Disewa'])->first();
@endphp
@if($statusAktif)
<div class="container">
    <div class="section-title">
        <h2>⏱️ Status Sewa Aktif Anda</h2>
    </div>
    <div class="status-aktif-card">
        <div class="judul">Transaksi #{{ $statusAktif->id_penyewaan }} · {{ $statusAktif->tipe }}</div>

        @if($statusAktif->status == 'Pending')
            <div class="isi">🕓 Menunggu Persetujuan Admin</div>
            <div class="sub">Pengajuan sewamu sedang ditinjau. Kamu akan bisa mengambil sepeda setelah disetujui admin.</div>
        @elseif($statusAktif->status == 'Disetujui')
            <div class="isi">✅ Silakan Ambil Sepeda</div>
            <div class="sub">Pesananmu sudah disetujui. Datang ke lokasi rental dengan membawa NIK asli untuk mengambil sepeda, lalu lakukan pembayaran.</div>
        @elseif($statusAktif->status == 'Sedang Disewa')
            <div class="isi">🚲 Sedang Disewa</div>
            <div class="sub">Batas waktu pengembalian: {{ \Carbon\Carbon::parse($statusAktif->deadline_kembali)->format('d M Y H:i') }}</div>
            <div class="countdown" id="countdown" data-deadline="{{ \Carbon\Carbon::parse($statusAktif->deadline_kembali)->toIso8601String() }}">Menghitung sisa waktu...</div>
        @endif
    </div>
</div>
@endif

<div class="container" id="riwayat">
    <div class="section-title">
        <h2>📋 Riwayat Sewa Saya</h2>
    </div>

    @if($riwayatSewa->isEmpty())
        <div class="empty-state">Kamu belum pernah menyewa sepeda.</div>
    @else
        <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Tipe Sepeda</th>
                    <th>Durasi</th>
                    <th>Total Biaya</th>
                    <th>Status</th>
                    <th>Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riwayatSewa as $sewa)
                <tr>
                    <td>{{ $sewa->tipe }}</td>
                    <td>{{ $sewa->durasi }} {{ $sewa->jenis_sewa == 'per_jam' ? 'jam' : 'hari' }}</td>
                    <td>
                        Rp {{ number_format($sewa->total_biaya, 0, ',', '.') }}
                        @if($sewa->total_denda > 0)
                            <br><span class="denda-tag">+ Denda Rp {{ number_format($sewa->total_denda, 0, ',', '.') }}</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $statusClass = [
                                'Pending' => 'status-pending',
                                'Disetujui' => 'status-disetujui',
                                'Sedang Disewa' => 'status-sedang-disewa',
                                'Selesai' => 'status-selesai',
                                'Ditolak' => 'status-ditolak',
                            ][$sewa->status] ?? 'status-pending';
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ $sewa->status }}</span>
                    </td>
                    <td>
                        @if($sewa->status_pembayaran == 'Sudah Dibayar')
                            <span class="status-badge status-selesai">Sudah Dibayar</span>
                        @else
                            <span class="status-badge status-pending">Belum Dibayar</span>
                        @endif
                    </td>
                    <td>
                        @if($sewa->status == 'Disetujui' && $sewa->status_pembayaran != 'Sudah Dibayar')
                            <button type="button" class="btn-upload" onclick="openUpload({{ $sewa->id_penyewaan }}, {{ $sewa->total_biaya }}, '{{ $sewa->batas_pembayaran ? \Carbon\Carbon::parse($sewa->batas_pembayaran)->toIso8601String() : '' }}')">Bayar Sekarang</button>
                        @elseif($sewa->status == 'Selesai')
                            <a href="/riwayat/{{ $sewa->id_penyewaan }}/nota" class="btn-nota" target="_blank">🧾 Lihat Nota</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    @endif
</div>

<footer class="site-footer">
    <div class="wrap">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="brand"><span class="dot"></span> Gowesin</div>
                <p>&copy; {{ date('Y') }} Gowesin. Urban Mobility &amp; Freshness. Menghadirkan kesegaran di setiap kayuhan Anda.</p>
            </div>
            <div class="footer-cols">
                <div class="footer-col">
                    <h4>Navigasi</h4>
                    <a href="/syarat-ketentuan">Syarat &amp; Ketentuan</a>
                    <a href="/panduan">Panduan Sewa</a>
                </div>
                <div class="footer-col">
                    <h4>Dukungan</h4>
                    <a href="/panduan">Bantuan</a>
                    <a href="/profile">Kontak</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <small>&copy; {{ date('Y') }} Gowesin. Seluruh hak cipta dilindungi.</small>
            <div class="social-row">
                <a href="#" aria-label="Instagram">📷</a>
                <a href="#" aria-label="Twitter">🐦</a>
                <a href="#" aria-label="Email">✉️</a>
            </div>
        </div>
    </div>
</footer>

<div class="modal-overlay" id="modalSewa">
    <div class="modal-box">
        <h3 style="margin-top:0;" id="sewaJudul">🚲 Ajukan Sewa</h3>

        <form id="formSewa" method="POST" onsubmit="return confirm('Ajukan sewa sekarang?')">
            @csrf
            <label>Jenis Sewa:</label>
            <select name="jenis_sewa" id="sewaJenis" required onchange="updateSewaTotal()">
                <option value="per_jam">Per Jam</option>
                <option value="per_hari">Per Hari</option>
            </select>
            <label>Durasi:</label>
            <input type="number" name="durasi" id="sewaDurasi" min="1" value="1" required oninput="updateSewaTotal()">

            <div class="payment-info" style="padding:12px 14px;">
                <div class="payment-total" style="margin-bottom:0;">Estimasi Total: <b id="sewaTotal">Rp 0</b></div>
            </div>
            <br>

            <label class="tnc-check" style="margin-bottom:14px;">
                <input type="checkbox" name="setuju_syarat" value="1" required>
                Saya sudah membaca &amp; menyetujui <a href="/syarat-ketentuan" target="_blank">Syarat &amp; Ketentuan</a> penyewaan (wajib membawa NIK asli saat ambil sepeda, denda keterlambatan berlaku).
            </label>

            <button type="submit" class="btn-kirim">✅ Ajukan Sewa</button>
            <button type="button" class="btn-batal" onclick="document.getElementById('modalSewa').style.display='none'">Batal</button>
        </form>
    </div>
</div>

<div class="modal-overlay" id="modalUpload">
    <div class="modal-box">
        <h3 style="margin-top:0;">💳 Pembayaran Sewa</h3>

        <div class="payment-info">
            <div class="payment-total">Total Tagihan: <b id="bayarTotal">Rp 0</b></div>

            <div class="payment-tabs">
                <div class="payment-method-box">
                    <div class="payment-label">Transfer Bank (VA Dummy)</div>
                    <div class="payment-value">BCA Virtual Account<br><span class="rekening">8808 1234 5678 901</span><br>a.n. Rental Sepeda ID</div>
                </div>
                <div class="payment-method-box">
                    <div class="payment-label">QRIS (Dummy)</div>
                    <div class="qris-box">▦▦▦ QRIS DEMO ▦▦▦<br><small>Simulasi — tidak untuk transaksi nyata</small></div>
                </div>
            </div>

            <div class="payment-deadline" id="bayarDeadlineWrap">
                Batas waktu pembayaran:
                <div class="countdown-bayar" id="countdownBayar">Menghitung...</div>
            </div>
        </div>

        <form id="formUpload" method="POST" onsubmit="return confirm('Konfirmasi bahwa pembayaran sudah kamu lakukan?')">
            @csrf
            <label>Metode Pembayaran:</label>
            <select name="metode_pembayaran" required>
                <option value="transfer">Transfer Bank (VA)</option>
                <option value="tunai">Tunai (bayar di lokasi)</option>
            </select>
            <button type="submit" class="btn-kirim">✅ Konfirmasi Pembayaran</button>
            <button type="button" class="btn-batal" onclick="document.getElementById('modalUpload').style.display='none'">Batal</button>
        </form>
    </div>
</div>

<script>
    function toggleUserNav(event) {
        event.stopPropagation();
        document.getElementById('navAvatarWrap').classList.toggle('open');
    }
    document.addEventListener('click', function (event) {
        const wrap = document.getElementById('navAvatarWrap');
        if (wrap && !wrap.contains(event.target)) {
            wrap.classList.remove('open');
        }
    });

    let sewaHargaJam = 0;
    let sewaHargaHari = 0;

    function openSewa(id, tipe, hargaJam, hargaHari) {
        document.getElementById('formSewa').action = '/sewa/' + id;
        document.getElementById('sewaJudul').innerText = '🚲 Ajukan Sewa: ' + tipe;
        sewaHargaJam = hargaJam;
        sewaHargaHari = hargaHari;
        document.getElementById('sewaJenis').value = 'per_jam';
        document.getElementById('sewaDurasi').value = 1;
        updateSewaTotal();
        document.getElementById('modalSewa').style.display = 'flex';
    }

    function updateSewaTotal() {
        const jenis = document.getElementById('sewaJenis').value;
        const durasi = parseInt(document.getElementById('sewaDurasi').value) || 0;
        const harga = jenis === 'per_jam' ? sewaHargaJam : sewaHargaHari;
        document.getElementById('sewaTotal').innerText = 'Rp ' + (harga * durasi).toLocaleString('id-ID');
    }

    let bayarDeadline = null;

    function openUpload(id, total, batasPembayaran) {
        document.getElementById('formUpload').action = '/pembayaran/' + id + '/konfirmasi';
        document.getElementById('bayarTotal').innerText = 'Rp ' + Number(total).toLocaleString('id-ID');
        document.getElementById('modalUpload').style.display = 'flex';

        bayarDeadline = batasPembayaran ? new Date(batasPembayaran) : null;
        updateCountdownBayar();
    }

    function updateCountdownBayar() {
        const el = document.getElementById('countdownBayar');
        if (!bayarDeadline) { el.innerText = '-'; return; }
        const now = new Date();
        let diff = bayarDeadline - now;
        if (diff <= 0) {
            const telat = Math.abs(diff);
            const jam = Math.floor(telat / 3600000);
            const menit = Math.floor((telat % 3600000) / 60000);
            el.innerText = '⚠️ Sudah lewat ' + jam + ' jam ' + menit + ' menit — segera hubungi admin.';
            el.classList.add('telat');
            return;
        }
        const jam = Math.floor(diff / 3600000);
        const menit = Math.floor((diff % 3600000) / 60000);
        const detik = Math.floor((diff % 60000) / 1000);
        el.innerText = jam + ' jam ' + menit + ' menit ' + detik + ' detik lagi';
    }
    setInterval(updateCountdownBayar, 1000);

    window.onclick = function(event) {
        const modalBayar = document.getElementById('modalUpload');
        const modalSewa = document.getElementById('modalSewa');
        if (event.target == modalBayar) modalBayar.style.display = 'none';
        if (event.target == modalSewa) modalSewa.style.display = 'none';
    }

    // Hitung mundur sisa waktu sewa untuk transaksi yang sedang berjalan
    const countdownEl = document.getElementById('countdown');
    if (countdownEl) {
        const deadline = new Date(countdownEl.dataset.deadline);
        function updateCountdown() {
            const now = new Date();
            let diff = deadline - now;
            if (diff <= 0) {
                countdownEl.classList.add('telat');
                const telat = Math.abs(diff);
                const j = Math.floor(telat / 3600000);
                const m = Math.floor((telat % 3600000) / 60000);
                countdownEl.innerText = '⚠️ Sudah telat ' + j + ' jam ' + m + ' menit — segera kembalikan!';
                return;
            }
            const hari = Math.floor(diff / 86400000);
            const jam = Math.floor((diff % 86400000) / 3600000);
            const menit = Math.floor((diff % 3600000) / 60000);
            const detik = Math.floor((diff % 60000) / 1000);
            let teks = 'Sisa waktu: ';
            if (hari > 0) teks += hari + ' hari ';
            teks += jam + ' jam ' + menit + ' menit ' + detik + ' detik';
            countdownEl.innerText = teks;
        }
        updateCountdown();
        setInterval(updateCountdown, 1000);
    }
</script>

</body>
</html>
