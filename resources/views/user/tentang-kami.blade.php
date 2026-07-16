<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Rental Sepeda</title>
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
            border-radius: 22px; padding: 34px 30px; margin-bottom: 28px;
            color: #fff; text-align: center;
        }
        .hero-banner::before { content: ""; position: absolute; top: -50px; right: -30px; width: 180px; height: 180px; background: rgba(255,255,255,0.14); border-radius: 50%; }
        .hero-banner::after { content: ""; position: absolute; bottom: -60px; left: -20px; width: 160px; height: 160px; background: rgba(255,255,255,0.10); border-radius: 50%; }
        .hero-banner h2 { margin: 0; font-size: 24px; position: relative; z-index: 1; }
        .hero-banner p { margin: 8px 0 0; font-size: 13px; opacity: 0.92; position: relative; z-index: 1; max-width: 480px; margin-left: auto; margin-right: auto; line-height: 1.6; }

        .section { margin-bottom: 30px; }
        .section h3 { font-size: 16px; color: #0f172a; margin: 0 0 10px; display: flex; align-items: center; gap: 8px; }
        .section p { font-size: 13.5px; color: #475569; line-height: 1.8; margin: 0 0 10px; }

        .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin: 20px 0 30px; }
        .stat-box { background: linear-gradient(135deg, #f0fdf4, #ecfeff); border: 1px solid #d1fae5; border-radius: 16px; padding: 16px 10px; text-align: center; }
        .stat-box .angka { font-size: 20px; font-weight: 800; color: #047857; }
        .stat-box .label { font-size: 10.5px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-top: 4px; letter-spacing: 0.2px; }

        .value-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .value-card { display: flex; gap: 14px; padding: 16px; border-radius: 16px; border: 1px solid #eef2f7; transition: all 0.15s; }
        .value-card:hover { background: #f8fafc; }
        .value-card .icon {
            flex-shrink: 0; width: 40px; height: 40px; border-radius: 12px;
            background: linear-gradient(135deg, #10b981, #06b6d4); color: #fff;
            display: flex; align-items: center; justify-content: center; font-size: 18px;
            box-shadow: 0 6px 14px rgba(16,185,129,0.3);
        }
        .value-card h4 { margin: 0 0 4px; font-size: 13.5px; color: #0f172a; }
        .value-card p { margin: 0; font-size: 12px; color: #64748b; line-height: 1.6; }

        .misi-list { margin: 0; padding-left: 0; list-style: none; }
        .misi-list li { display: flex; gap: 10px; font-size: 13.5px; color: #475569; line-height: 1.7; margin-bottom: 8px; }
        .misi-list li .check { flex-shrink: 0; color: #10b981; font-weight: 800; }

        .contact-box { background: linear-gradient(135deg, #f0fdf4, #ecfeff); border: 1px solid #d1fae5; border-radius: 18px; padding: 22px 24px; }
        .contact-box h4 { margin-top: 0; font-size: 14px; color: #0f172a; }
        .contact-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 12px; }
        .contact-item { display: flex; align-items: center; gap: 10px; font-size: 12.5px; color: #475569; }
        .contact-item .ic { font-size: 15px; }

        @media (max-width: 620px) {
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
            .value-grid { grid-template-columns: 1fr; }
            .contact-grid { grid-template-columns: 1fr; }
        }
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
        <h2>🚲 Tentang Gowesin</h2>
        <p>Teman perjalananmu menjelajahi kota dengan cara yang lebih sehat, hemat, dan ramah lingkungan — satu kayuhan pada satu waktu.</p>
    </div>

    <div class="stat-grid">
        <div class="stat-box"><div class="angka">150+</div><div class="label">Unit Sepeda</div></div>
        <div class="stat-box"><div class="angka">12rb+</div><div class="label">Pengguna</div></div>
        <div class="stat-box"><div class="angka">8</div><div class="label">Titik Rental</div></div>
        <div class="stat-box"><div class="angka">4.8★</div><div class="label">Rating Pengguna</div></div>
    </div>

    <div class="section">
        <h3>📖 Cerita Kami</h3>
        <p>
            Gowesin lahir dari kebiasaan sederhana: tiga orang teman yang gemar bersepeda keliling kota setiap akhir pekan,
            tapi capek harus bawa-bawa sepeda sendiri dari rumah atau minjem sana-sini. Dari situ muncul ide untuk
            menyediakan sepeda sewaan yang mudah diakses siapa saja, kapan saja — cukup buka aplikasi, pilih sepeda,
            dan langsung gowes.
        </p>
        <p>
            Sejak awal berdiri, kami percaya bersepeda bukan cuma soal olahraga, tapi juga cara menikmati kota dengan
            ritme yang lebih santai, sekaligus jadi pilihan transportasi yang lebih hijau untuk aktivitas sehari-hari.
        </p>
    </div>

    <div class="section">
        <h3>🎯 Visi & Misi</h3>
        <p style="margin-bottom: 14px;"><b>Visi:</b> Menjadi platform rental sepeda urban paling dipercaya, yang membuat gaya hidup aktif dan ramah lingkungan bisa dinikmati semua orang.</p>
        <p style="margin-bottom: 8px;"><b>Misi:</b></p>
        <ul class="misi-list">
            <li><span class="check">✓</span> Menyediakan armada sepeda yang terawat, aman, dan nyaman dikendarai.</li>
            <li><span class="check">✓</span> Menghadirkan proses sewa yang cepat, transparan, dan tanpa ribet.</li>
            <li><span class="check">✓</span> Mendorong lebih banyak orang beralih ke transportasi ramah lingkungan.</li>
            <li><span class="check">✓</span> Memberikan pelayanan yang ramah dan responsif untuk setiap penyewa.</li>
        </ul>
    </div>

    <div class="section">
        <h3>💚 Kenapa Pilih Gowesin?</h3>
        <div class="value-grid">
            <div class="value-card">
                <div class="icon">🛠️</div>
                <div>
                    <h4>Armada Terawat</h4>
                    <p>Setiap sepeda melewati pengecekan rutin sebelum disewakan, jadi kamu bisa gowes dengan tenang.</p>
                </div>
            </div>
            <div class="value-card">
                <div class="icon">⚡</div>
                <div>
                    <h4>Proses Cepat</h4>
                    <p>Sewa dari genggaman, pengajuan disetujui admin dalam hitungan menit, langsung bisa ambil sepeda.</p>
                </div>
            </div>
            <div class="value-card">
                <div class="icon">💳</div>
                <div>
                    <h4>Harga Transparan</h4>
                    <p>Tarif per jam maupun per hari ditampilkan jelas di awal, tanpa biaya tersembunyi.</p>
                </div>
            </div>
            <div class="value-card">
                <div class="icon">🤝</div>
                <div>
                    <h4>Layanan Ramah</h4>
                    <p>Tim kami siap membantu mulai dari pemilihan sepeda sampai proses pengembalian.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-box">
        <h4>📍 Hubungi Kami</h4>
        <div class="contact-grid">
            <div class="contact-item"><span class="ic">📌</span> Jl. Melati Raya No. 21, Bekasi, Jawa Barat</div>
            <div class="contact-item"><span class="ic">📞</span> +62 812-3456-7890</div>
            <div class="contact-item"><span class="ic">✉️</span> halo@gowesin.id</div>
            <div class="contact-item"><span class="ic">🕒</span> Setiap hari, 07.00 - 21.00 WIB</div>
        </div>
    </div>
</div>

</body>
</html>
