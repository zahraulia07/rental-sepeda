<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota #{{ $nota->id_penyewaan }} - Rental Sepeda</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background: linear-gradient(135deg, #f0fdf4 0%, #e0f2fe 100%); color: #1e293b; }
        .nota-box { max-width: 480px; margin: auto; background: #fff; padding: 32px; border-radius: 12px; box-shadow: 0px 10px 30px rgba(15, 23, 42, 0.08); border: 1px solid #e2e8f0; }
        .brand { text-align: center; margin-bottom: 20px; }
        .brand h2 { margin: 0; font-size: 20px; color: #0f172a; }
        .brand p { margin: 4px 0 0; font-size: 12px; color: #94a3b8; }
        .divider { border-top: 1px dashed #cbd5e1; margin: 18px 0; }
        .baris { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 8px; color: #475569; }
        .baris b { color: #0f172a; }
        .total-row { display: flex; justify-content: space-between; font-size: 15px; font-weight: 800; color: #0f172a; margin-top: 10px; }
        .lunas-badge { display: block; text-align: center; margin: 18px 0 6px; background: #d1fae5; color: #047857; font-weight: 700; padding: 8px; border-radius: 8px; font-size: 13px; }
        .footer-note { text-align: center; font-size: 11px; color: #94a3b8; margin-top: 20px; }
        .btn-print { display: block; width: 100%; margin: 20px auto 0; padding: 10px; background: #10b981; color: #fff; border: none; border-radius: 8px; font-weight: bold; font-size: 14px; cursor: pointer; }
        .btn-print:hover { background: #059669; }

        @media print {
            body { margin: 0; background: #fff; }
            .btn-print { display: none; }
            .nota-box { box-shadow: none; border: none; }
        }
    </style>
</head>
<body>

<div class="nota-box">
    <div class="brand">
        <h2>🚲 Nota Digital Rental Sepeda</h2>
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

    <button class="btn-print" onclick="window.print()">🖨️ Cetak / Unduh Nota (PDF)</button>

    <div class="footer-note">Terima kasih telah menggunakan layanan rental sepeda kami.</div>
</div>

</body>
</html>
