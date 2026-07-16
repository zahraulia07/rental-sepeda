<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota #{{ $nota->id_penyewaan }} - Rental Sepeda</title>
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
        .page-wrap { max-width: 480px; margin: auto; }
        .nota-box { background: #fff; padding: 32px; border-radius: 24px; box-shadow: 0px 14px 40px rgba(15, 23, 42, 0.08); border: 1px solid #eef2f7; }
        .brand { text-align: center; margin-bottom: 20px; }
        .brand .icon-circle { width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #06b6d4); display: flex; align-items: center; justify-content: center; font-size: 26px; margin: 0 auto 12px; box-shadow: 0 10px 22px rgba(16,185,129,0.3); }
        .brand h2 { margin: 0; font-size: 19px; color: #0f172a; }
        .brand p { margin: 4px 0 0; font-size: 12px; color: #94a3b8; }
        .divider { border-top: 1px dashed #cbd5e1; margin: 18px 0; }
        .baris { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 9px; color: #64748b; gap: 12px; }
        .baris span:first-child { flex-shrink: 0; }
        .baris b { color: #0f172a; text-align: right; }
        .total-row { display: flex; justify-content: space-between; font-size: 16px; font-weight: 800; color: #0f172a; margin-top: 10px; }
        .lunas-badge { display: block; text-align: center; margin: 18px 0 6px; background: linear-gradient(135deg, #d1fae5, #ccfbf1); color: #047857; font-weight: 800; padding: 10px; border-radius: 12px; font-size: 13px; letter-spacing: 0.2px; }
        .footer-note { text-align: center; font-size: 11px; color: #94a3b8; margin-top: 20px; }
        .btn-download {
            display: block; width: 100%; margin: 20px auto 0; padding: 13px;
            background: linear-gradient(135deg, #10b981, #06b6d4); color: #fff; border: none;
            border-radius: 12px; font-weight: 700; font-size: 14px; cursor: pointer;
            box-shadow: 0 10px 22px rgba(16,185,129,0.3);
        }
        .btn-download:hover { filter: brightness(1.05); }
        .btn-download:disabled { opacity: 0.7; cursor: wait; }
        .btn-back { display: block; text-align: center; margin-top: 12px; font-size: 12.5px; color: #64748b; text-decoration: none; font-weight: 600; }
        .btn-back:hover { color: #0f172a; }
    </style>
</head>
<body>

<div class="page-wrap">
<div class="nota-box" id="notaBox">
    <div class="brand">
        <div class="icon-circle">🚲</div>
        <h2>Nota Digital Rental Sepeda</h2>
        <p>Kuitansi Transaksi #{{ $nota->id_penyewaan }}</p>
    </div>

    <div class="divider"></div>

    <div class="baris"><span>Nama Penyewa</span><b>{{ $nota->nama_penyewa }}</b></div>
    <div class="baris"><span>Tipe Sepeda</span><b>{{ $nota->tipe }} ({{ $nota->kategori }})</b></div>
    <div class="baris"><span>Jenis Sewa</span><b>{{ $nota->durasi }} {{ $nota->jenis_sewa == 'per_jam' ? 'jam' : 'hari' }}</b></div>
    <div class="baris"><span>Tanggal Ambil</span><b>{{ $nota->tanggal_ambil ? \Carbon\Carbon::parse($nota->tanggal_ambil)->format('d M Y H:i') : '-' }}</b></div>
    <div class="baris"><span>Batas Kembali</span><b>{{ $nota->deadline_kembali ? \Carbon\Carbon::parse($nota->deadline_kembali)->format('d M Y H:i') : '-' }}</b></div>
    <div class="baris"><span>Tanggal Selesai</span><b>{{ $nota->tanggal_selesai ? \Carbon\Carbon::parse($nota->tanggal_selesai)->format('d M Y H:i') : '-' }}</b></div>
    <div class="baris"><span>Metode Pembayaran</span><b>{{ $nota->metode_pembayaran == 'transfer' ? 'Transfer Bank' : 'Tunai' }}</b></div>

    <div class="divider"></div>

    <div class="baris"><span>Biaya Sewa</span><span>Rp {{ number_format($nota->total_biaya, 0, ',', '.') }}</span></div>
    <div class="baris">
        <span>Denda Keterlambatan</span>
        <span style="{{ $nota->total_denda > 0 ? 'color:#dc2626; font-weight:700;' : '' }}">
            Rp {{ number_format($nota->total_denda, 0, ',', '.') }}
        </span>
    </div>

    <div class="divider"></div>

    <div class="total-row"><span>Total Dibayar</span><span>Rp {{ number_format($nota->total_biaya + $nota->total_denda, 0, ',', '.') }}</span></div>

    <div class="lunas-badge">✔️ LUNAS — TRANSAKSI SELESAI</div>

    @if($nota->total_denda > 0)
        <p style="font-size: 11px; color: #dc2626; text-align:center;">*Denda dikenakan karena sepeda dikembalikan melewati batas waktu sewa.</p>
    @endif

    <div class="footer-note">Terima kasih telah menggunakan layanan rental sepeda kami.</div>
</div>

<button class="btn-download" id="btnDownload" onclick="unduhNota()">📥 Unduh Nota (PDF)</button>
<a href="javascript:history.back()" class="btn-back">← Kembali ke Riwayat Sewa</a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function unduhNota() {
        const btn = document.getElementById('btnDownload');
        const asli = btn.innerText;
        btn.disabled = true;
        btn.innerText = '⏳ Menyiapkan file...';

        const elemen = document.getElementById('notaBox');
        const opsi = {
            margin: 0.3,
            filename: 'nota-sewa-{{ $nota->id_penyewaan }}.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, backgroundColor: '#ffffff' },
            jsPDF: { unit: 'in', format: 'a5', orientation: 'portrait' }
        };

        html2pdf().set(opsi).from(elemen).save().then(function () {
            btn.disabled = false;
            btn.innerText = asli;
        }).catch(function () {
            btn.disabled = false;
            btn.innerText = asli;
            alert('Gagal membuat file PDF, coba lagi ya.');
        });
    }
</script>

</body>
</html>
