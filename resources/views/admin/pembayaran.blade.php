<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pembayaran - Rental Sepeda</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background: linear-gradient(135deg, #f0fdf4 0%, #e0f2fe 100%); color: #1e293b; }
        .container { max-width: 1100px; margin: auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0px 10px 30px rgba(15, 23, 42, 0.06); border: 1px solid #e2e8f0; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; font-size: 13px; color: #64748b; }
        .topbar .role-badge { background: #d1fae5; color: #047857; font-weight: 700; padding: 2px 8px; border-radius: 4px; font-size: 11px; text-transform: uppercase; margin-left: 6px; }
        .btn-logout { background: transparent; color: #ef4444; border: 1px solid #fecaca; padding: 6px 14px; border-radius: 6px; font-size: 13px; cursor: pointer; }
        h2 { text-align: center; font-size: 24px; color: #0f172a; border-bottom: 3px solid #f1f5f9; padding-bottom: 20px; margin-bottom: 20px; }
        .alert { padding: 12px; background-color: #f0fdf4; color: #15803d; border-radius: 6px; margin-bottom: 20px; font-size: 14px; border-left: 5px solid #10b981; }

        .card-list { display: flex; flex-direction: column; gap: 14px; }
        .card { border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; }
        .card .info b { color: #0f172a; }
        .card .info .meta { font-size: 12px; color: #64748b; margin-top: 4px; }
        .card .bukti a { font-size: 12px; color: #2563eb; text-decoration: underline; }

        .status-badge { font-weight: bold; padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .status-menunggu { color: #b45309; background-color: #fef3c7; border: 1px solid #fde68a; }
        .status-terverifikasi { color: #047857; background-color: #d1fae5; border: 1px solid #a7f3d0; }
        .status-ditolak { color: #dc2626; background-color: #fef2f2; border: 1px solid #fecaca; }

        .btn-aksi { padding: 8px 14px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 12px; margin-left: 4px; }
        .btn-verif { background: #10b981; color: #fff; }
        .btn-tolak { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .empty-state { text-align: center; color: #94a3b8; padding: 30px 0; font-size: 14px; }
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

    @include('partials.admin-nav')

    <h2>💳 Verifikasi Pembayaran</h2>

    @if(session('sukses'))
        <div class="alert">✔️ {{ session('sukses') }}</div>
    @endif

    @if($daftarPembayaran->isEmpty())
        <div class="empty-state">Belum ada bukti pembayaran yang perlu diverifikasi.</div>
    @else
        <div class="card-list">
            @foreach($daftarPembayaran as $p)
            <div class="card">
                <div class="info">
                    <div><b>#{{ $p->id_penyewaan }} — {{ $p->nama_penyewa }}</b></div>
                    <div class="meta">{{ $p->tipe }} · {{ $p->metode_pembayaran == 'transfer' ? 'Transfer Bank' : 'Tunai' }} · Total: Rp {{ number_format($p->total_biaya + $p->total_denda, 0, ',', '.') }}</div>
                    @if($p->bukti_pembayaran)
                        <div class="bukti"><a href="/storage/{{ $p->bukti_pembayaran }}" target="_blank">Lihat bukti transfer →</a></div>
                    @endif
                </div>
                <div style="display:flex; align-items:center; gap:10px;">
                    <span class="status-badge {{ $p->status_pembayaran == 'Menunggu' ? 'status-menunggu' : ($p->status_pembayaran == 'Terverifikasi' ? 'status-terverifikasi' : 'status-ditolak') }}">
                        {{ $p->status_pembayaran }}
                    </span>
                    @if($p->status_pembayaran == 'Menunggu')
                        <form action="/admin/pembayaran/{{ $p->id_penyewaan }}/verifikasi" method="POST">
                            @csrf
                            <button type="submit" class="btn-aksi btn-verif">Verifikasi</button>
                        </form>
                        <form action="/admin/pembayaran/{{ $p->id_penyewaan }}/tolak" method="POST">
                            @csrf
                            <button type="submit" class="btn-aksi btn-tolak">Tolak</button>
                        </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

</body>
</html>
