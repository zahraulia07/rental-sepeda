<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Cara Menyewa - Rental Sepeda</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background: linear-gradient(135deg, #f0fdf4 0%, #e0f2fe 100%); color: #1e293b; }
        .container { max-width: 800px; margin: auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0px 10px 30px rgba(15, 23, 42, 0.06); border: 1px solid #e2e8f0; margin-bottom: 24px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; font-size: 13px; color: #64748b; }
        .topbar .role-badge { background: #dbeafe; color: #1d4ed8; font-weight: 700; padding: 2px 8px; border-radius: 4px; font-size: 11px; text-transform: uppercase; margin-left: 6px; }
        .btn-logout { background: transparent; color: #ef4444; border: 1px solid #fecaca; padding: 6px 14px; border-radius: 6px; font-size: 13px; cursor: pointer; }

        h2 { font-size: 22px; color: #0f172a; border-bottom: 3px solid #f1f5f9; padding-bottom: 16px; margin-bottom: 20px; }

        .step { display: flex; gap: 16px; margin-bottom: 22px; }
        .step .angka { flex-shrink: 0; width: 34px; height: 34px; border-radius: 50%; background: #10b981; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; }
        .step .konten h4 { margin: 0 0 4px; font-size: 15px; color: #0f172a; }
        .step .konten p { margin: 0; font-size: 13px; color: #64748b; line-height: 1.6; }

        .status-list { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px 20px; margin-top: 24px; }
        .status-list h4 { margin-top: 0; font-size: 14px; color: #0f172a; }
        .status-list li { font-size: 13px; color: #475569; line-height: 1.8; }
    </style>
</head>
<body>

<div class="container">
    <div class="topbar">
        <div>Masuk sebagai <b>{{ Auth::user()->name }}</b><span class="role-badge">{{ Auth::user()->role }}</span></div>
        <form action="/logout" method="POST" onsubmit="return confirm('Keluar dari sistem?')">
            @csrf
            <button type="submit" class="btn-logout">Keluar</button>
        </form>
    </div>

    @include('partials.user-nav')

    <h2>📖 Panduan Cara Menyewa Sepeda</h2>

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
            <p>Lakukan pembayaran via transfer bank (unggah bukti transfer di riwayat sewa) atau tunai langsung di lokasi.</p>
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
