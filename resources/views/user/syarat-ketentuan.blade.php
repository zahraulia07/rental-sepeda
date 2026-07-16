<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syarat & Ketentuan - Rental Sepeda</title>
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

        .pasal { background: #f8fafc; border: 1px solid #eef2f7; border-radius: 16px; padding: 18px 22px; margin-bottom: 16px; }
        h3 { font-size: 15px; color: #0f172a; margin-top: 0; margin-bottom: 10px; display: flex; align-items: center; gap: 8px; }
        h3 .no { display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 8px; background: linear-gradient(135deg, #10b981, #06b6d4); color: #fff; font-size: 12px; font-weight: 800; flex-shrink: 0; }
        p, li { font-size: 13.5px; color: #475569; line-height: 1.75; }
        ol, ul { padding-left: 20px; margin: 0; }
        .badge-wajib { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; font-size: 10.5px; font-weight: 800; padding: 2px 9px; border-radius: 999px; margin-left: 6px; }
        .footnote { margin-top: 24px; color: #94a3b8; font-size: 12px; text-align: center; }
    </style>
</head>
<body>

<div class="container">
    <div class="topbar">
        <div class="brand"><span class="dot"></span> Gowesin</div>
        <div>Masuk sebagai <b>{{ Auth::user()->name }}</b><span class="role-badge">{{ Auth::user()->role }}</span></div>
        <form action="/logout" method="POST" onsubmit="return confirm('Keluar dari sistem?')">
            @csrf
            <button type="submit" class="btn-logout">Keluar</button>
        </form>
    </div>

    @include('partials.user-nav')

    <div class="hero-banner">
        <h2>📃 Syarat & Ketentuan Penyewaan</h2>
        <p>Baca dulu sebelum mengajukan sewa ya, biar sama-sama enak</p>
    </div>

    <div class="pasal">
        <h3><span class="no">1</span> Identitas Penyewa</h3>
        <ul>
            <li>Penyewa wajib menunjukkan <b>KTP / NIK asli</b> yang masih berlaku saat pengambilan sepeda di lokasi. <span class="badge-wajib">WAJIB</span></li>
            <li>Data pada saat pendaftaran akun (nama, NIK, no HP, alamat) harus sesuai dengan identitas asli penyewa.</li>
        </ul>
    </div>

    <div class="pasal">
        <h3><span class="no">2</span> Proses Sewa</h3>
        <ol>
            <li>Pilih sepeda yang tersedia, tentukan jenis sewa (per jam / per hari) dan durasinya, lalu ajukan sewa.</li>
            <li>Pengajuan akan berstatus <b>"Menunggu Persetujuan"</b> hingga disetujui oleh admin.</li>
            <li>Setelah disetujui, datang ke lokasi rental untuk mengambil sepeda dan menunjukkan KTP asli.</li>
            <li>Batas waktu pengembalian mulai dihitung sejak sepeda diambil, sesuai durasi sewa yang dipilih.</li>
        </ol>
    </div>

    <div class="pasal">
        <h3><span class="no">3</span> Pembayaran</h3>
        <ul>
            <li>Pembayaran dapat dilakukan melalui transfer bank (VA) atau tunai langsung di lokasi.</li>
            <li>Setelah membayar, klik tombol "Bayar Sekarang" lalu "Konfirmasi Pembayaran" pada halaman riwayat sewa untuk menandai transaksi sebagai lunas.</li>
        </ul>
    </div>

    <div class="pasal">
        <h3><span class="no">4</span> Denda Keterlambatan</h3>
        <ul>
            <li>Setiap keterlambatan pengembalian sepeda dari batas waktu yang ditentukan akan dikenakan <b>denda otomatis</b>.</li>
            <li>Besaran denda dihitung berdasarkan tarif per jam atau per hari keterlambatan, sesuai jenis sepeda yang disewa, dan akan tampil transparan pada riwayat sewa serta nota digital.</li>
        </ul>
    </div>

    <div class="pasal">
        <h3><span class="no">5</span> Kerusakan & Kehilangan</h3>
        <ul>
            <li>Penyewa bertanggung jawab penuh atas kondisi sepeda selama masa sewa.</li>
            <li>Kerusakan atau kehilangan unit akan dikenakan biaya penggantian sesuai kebijakan admin.</li>
        </ul>
    </div>

    <div class="pasal">
        <h3><span class="no">6</span> Pelanggaran</h3>
        <p>Akun yang melanggar ketentuan (mis. tidak mengembalikan sepeda, memberikan data palsu, atau menunggak pembayaran) dapat diblokir oleh admin dan tidak dapat melakukan penyewaan baru.</p>
    </div>

    <p class="footnote">Dengan mengajukan sewa, Anda dianggap telah membaca dan menyetujui seluruh syarat & ketentuan di atas.</p>
</div>

</body>
</html>
