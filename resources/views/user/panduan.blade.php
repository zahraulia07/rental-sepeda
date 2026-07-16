<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Cara Menyewa - Rental Sepeda</title>
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
        .container { max-width: 800px; margin: auto; background: #fff; padding: 32px; border-radius: 24px; box-shadow: 0px 14px 40px rgba(15, 23, 42, 0.07); border: 1px solid #eef2f7; margin-bottom: 24px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; font-size: 13px; color: #64748b; }
        .brand { display: flex; align-items: center; gap: 8px; font-weight: 800; color: #0f172a; font-size: 15px; }
        .brand .dot { width: 10px; height: 10px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #06b6d4); }
        .topbar .role-badge { background: linear-gradient(135deg, #dbeafe, #e0f2fe); color: #1d4ed8; font-weight: 700; padding: 3px 10px; border-radius: 999px; font-size: 11px; text-transform: uppercase; margin-left: 6px; }
        .btn-logout { background: #fff; color: #ef4444; border: 1px solid #fecaca; padding: 8px 16px; border-radius: 999px; font-size: 13px; cursor: pointer; font-weight: 700; transition: all 0.15s; }
        .btn-logout:hover { background: #ef4444; color: #fff; border-color: #ef4444; }

        .hero-banner {
            position: relative; overflow: hidden;
            background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
            border-radius: 22px; padding: 30px 30px; margin-bottom: 28px;
            color: #fff; text-align: center;
        }
        .hero-banner::before { content: ""; position: absolute; top: -50px; right: -30px; width: 180px; height: 180px; background: rgba(255,255,255,0.14); border-radius: 50%; }
        .hero-banner h2 { margin: 0; font-size: 22px; position: relative; z-index: 1; }
        .hero-banner p { margin: 8px 0 0; font-size: 13px; opacity: 0.92; position: relative; z-index: 1; }

        .step-list { counter-reset: none; }
        .step { display: flex; gap: 16px; margin-bottom: 22px; padding: 16px; border-radius: 16px; transition: background 0.15s; }
        .step:hover { background: #f8fafc; }
        .step .angka {
            flex-shrink: 0; width: 38px; height: 38px; border-radius: 50%;
            background: linear-gradient(135deg, #10b981, #06b6d4); color: #fff;
            display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 15px;
            box-shadow: 0 6px 14px rgba(16,185,129,0.3);
        }
        .step .konten h4 { margin: 0 0 4px; font-size: 15px; color: #0f172a; }
        .step .konten p { margin: 0; font-size: 13px; color: #64748b; line-height: 1.6; }

        .status-list { background: linear-gradient(135deg, #f0fdf4, #ecfeff); border: 1px solid #d1fae5; border-radius: 18px; padding: 20px 24px; margin-top: 12px; }
        .status-list h4 { margin-top: 0; font-size: 14px; color: #0f172a; }
        .status-list ul { margin: 0; padding-left: 18px; }
        .status-list li { font-size: 13px; color: #475569; line-height: 1.9; }
    </style>
</head>
<body>

<div class="container">
    <div class="topbar">
        <div class="brand"><span class="dot"></span> BikeRent</div>
        <div>Masuk sebagai <b>{{ Auth::user()->name }}</b><span class="role-badge">{{ Auth::user()->role }}</span></div>
        <form action="/logout" method="POST" onsubmit="return confirm('Keluar dari sistem?')">
            @csrf
            <button type="submit" class="btn-logout">Keluar</button>
        </form>
    </div>

    @include('partials.user-nav')

    <div class="hero-banner">
        <h2>📖 Panduan Cara Menyewa Sepeda</h2>
        <p>Ikuti 7 langkah mudah ini biar proses sewamu lancar</p>
    </div>

    <div class="step-list">
        <div class="step">
            <div class="angka">1</div>
            <div class="konten">
                <h4>Pilih Sepeda</h4>
                <p>Buka halaman "Sewa Sepeda", pilih armada yang tersedia sesuai kebutuhan, lalu tentukan jenis sewa (per jam / per hari) dan durasinya.</p>
            </div>
        </div>
        <div class="step">
            <div class="angka">2</div>
            <div class="konten">
                <h4>Setujui Syarat & Ketentuan</h4>
                <p>Centang persetujuan Syarat & Ketentuan sebelum mengajukan sewa. Pastikan sudah membacanya terlebih dahulu.</p>
            </div>
        </div>
        <div class="step">
            <div class="angka">3</div>
            <div class="konten">
                <h4>Ajukan & Tunggu Persetujuan</h4>
                <p>Setelah diajukan, pesanan berstatus "Menunggu Persetujuan". Admin akan meninjau dan menyetujui pengajuanmu.</p>
            </div>
        </div>
        <div class="step">
            <div class="angka">4</div>
            <div class="konten">
                <h4>Ambil Sepeda di Lokasi</h4>
                <p>Setelah disetujui, datang ke lokasi rental dengan membawa <b>KTP asli</b>. Batas waktu pengembalian mulai dihitung sejak sepeda diambil.</p>
            </div>
        </div>
        <div class="step">
            <div class="angka">5</div>
            <div class="konten">
                <h4>Bayar Sewa</h4>
                <p>Buka riwayat sewa, klik "Bayar Sekarang", pilih metode transfer bank (VA) atau tunai di lokasi, lalu klik "Konfirmasi Pembayaran".</p>
            </div>
        </div>
        <div class="step">
            <div class="angka">6</div>
            <div class="konten">
                <h4>Kembalikan Tepat Waktu</h4>
                <p>Kembalikan sepeda sebelum batas waktu berakhir agar terhindar dari denda keterlambatan. Pantau sisa waktu di menu Status Sewa Aktif.</p>
            </div>
        </div>
        <div class="step">
            <div class="angka">7</div>
            <div class="konten">
                <h4>Selesai & Unduh Nota</h4>
                <p>Setelah admin mengonfirmasi pengembalian, status berubah menjadi "Selesai" dan kamu bisa melihat / mengunduh nota digital dari riwayat sewa.</p>
            </div>
        </div>
    </div>

    <div class="status-list">
        <h4>Arti Status Transaksi</h4>
        <ul>
            <li><b>Menunggu Persetujuan</b> — pengajuan sewa masih ditinjau admin.</li>
            <li><b>Silakan Ambil Sepeda</b> (Disetujui) — sepeda siap diambil di lokasi.</li>
            <li><b>Sedang Disewa</b> — sepeda sudah diambil, masa sewa sedang berjalan.</li>
            <li><b>Selesai</b> — sepeda sudah dikembalikan dan transaksi ditutup.</li>
            <li><b>Ditolak</b> — pengajuan sewa tidak disetujui admin.</li>
        </ul>
    </div>
</div>

</body>
</html>
