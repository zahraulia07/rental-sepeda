<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syarat & Ketentuan - Rental Sepeda</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background: linear-gradient(135deg, #f0fdf4 0%, #e0f2fe 100%); color: #1e293b; }
        .container { max-width: 800px; margin: auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0px 10px 30px rgba(15, 23, 42, 0.06); border: 1px solid #e2e8f0; margin-bottom: 24px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; font-size: 13px; color: #64748b; }
        .topbar .role-badge { background: #dbeafe; color: #1d4ed8; font-weight: 700; padding: 2px 8px; border-radius: 4px; font-size: 11px; text-transform: uppercase; margin-left: 6px; }
        .btn-logout { background: transparent; color: #ef4444; border: 1px solid #fecaca; padding: 6px 14px; border-radius: 6px; font-size: 13px; cursor: pointer; }

        h2 { font-size: 22px; color: #0f172a; border-bottom: 3px solid #f1f5f9; padding-bottom: 16px; margin-bottom: 20px; }
        h3 { font-size: 15px; color: #0f172a; margin-top: 24px; margin-bottom: 8px; }
        p, li { font-size: 14px; color: #334155; line-height: 1.7; }
        ol, ul { padding-left: 20px; }
        .badge-wajib { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 4px; margin-left: 6px; }
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

    <h2>📃 Syarat & Ketentuan Penyewaan</h2>

    <h3>1. Identitas Penyewa</h3>
    <ul>
        <li>Penyewa wajib menunjukkan <b>KTP / NIK asli</b> yang masih berlaku saat pengambilan sepeda di lokasi. <span class="badge-wajib">WAJIB</span></li>
        <li>Data pada saat pendaftaran akun (nama, NIK, no HP, alamat) harus sesuai dengan identitas asli penyewa.</li>
    </ul>

    <h3>2. Proses Sewa</h3>
    <ol>
        <li>Pilih sepeda yang tersedia, tentukan jenis sewa (per jam / per hari) dan durasinya, lalu ajukan sewa.</li>
        <li>Pengajuan akan berstatus <b>"Menunggu Persetujuan"</b> hingga disetujui oleh admin.</li>
        <li>Setelah disetujui, datang ke lokasi rental untuk mengambil sepeda dan menunjukkan KTP asli.</li>
        <li>Batas waktu pengembalian mulai dihitung sejak sepeda diambil, sesuai durasi sewa yang dipilih.</li>
    </ol>

    <h3>3. Pembayaran</h3>
    <ul>
        <li>Pembayaran dapat dilakukan melalui transfer bank atau tunai langsung di lokasi.</li>
        <li>Jika membayar via transfer, unggah bukti transfer melalui menu riwayat sewa untuk diverifikasi admin.</li>
    </ul>

    <h3>4. Denda Keterlambatan</h3>
    <ul>
        <li>Setiap keterlambatan pengembalian sepeda dari batas waktu yang ditentukan akan dikenakan <b>denda otomatis</b>.</li>
        <li>Besaran denda dihitung berdasarkan tarif per jam atau per hari keterlambatan, sesuai jenis sepeda yang disewa, dan akan tampil transparan pada riwayat sewa serta nota digital.</li>
    </ul>

    <h3>5. Kerusakan & Kehilangan</h3>
    <ul>
        <li>Penyewa bertanggung jawab penuh atas kondisi sepeda selama masa sewa.</li>
        <li>Kerusakan atau kehilangan unit akan dikenakan biaya penggantian sesuai kebijakan admin.</li>
    </ul>

    <h3>6. Pelanggaran</h3>
    <p>Akun yang melanggar ketentuan (mis. tidak mengembalikan sepeda, memberikan data palsu, atau menunggak pembayaran) dapat diblokir oleh admin dan tidak dapat melakukan penyewaan baru.</p>

    <p style="margin-top: 24px; color: #64748b; font-size: 12px;">Dengan mengajukan sewa, Anda dianggap telah membaca dan menyetujui seluruh syarat & ketentuan di atas.</p>
</div>

</body>
</html>
