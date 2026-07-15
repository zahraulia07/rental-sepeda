<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan - Rental Sepeda</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background: linear-gradient(135deg, #f0fdf4 0%, #e0f2fe 100%); color: #1e293b; }
        .container { max-width: 1100px; margin: auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0px 10px 30px rgba(15, 23, 42, 0.06); border: 1px solid #e2e8f0; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; font-size: 13px; color: #64748b; }
        .topbar .role-badge { background: #d1fae5; color: #047857; font-weight: 700; padding: 2px 8px; border-radius: 4px; font-size: 11px; text-transform: uppercase; margin-left: 6px; }
        .btn-logout { background: transparent; color: #ef4444; border: 1px solid #fecaca; padding: 6px 14px; border-radius: 6px; font-size: 13px; cursor: pointer; }
        h2 { text-align: center; font-size: 24px; color: #0f172a; border-bottom: 3px solid #f1f5f9; padding-bottom: 20px; margin-bottom: 20px; }

        .periode-tabs { display: flex; gap: 8px; justify-content: center; margin-bottom: 24px; }
        .periode-tabs a { text-decoration: none; padding: 8px 18px; border-radius: 8px; font-size: 13px; font-weight: 600; color: #475569; background: #f1f5f9; border: 1px solid #e2e8f0; }
        .periode-tabs a.active { background: #0f172a; color: #fff; border-color: #0f172a; }

        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; margin-bottom: 26px; }
        .stat-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; }
        .stat-card .label { font-size: 12px; color: #64748b; text-transform: uppercase; font-weight: 600; }
        .stat-card .value { font-size: 22px; font-weight: 700; color: #0f172a; margin-top: 6px; }
        .stat-card.highlight { background: #ecfdf5; border-color: #a7f3d0; }
        .stat-card.highlight .value { color: #047857; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #e2e8f0; text-align: left; padding: 12px; font-size: 13px; }
        th { background-color: #f8fafc; color: #64748b; font-weight: 600; }
        td { background-color: #fff; color: #1e293b; }
        .denda-tag { color: #dc2626; font-weight: 700; }
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

    <h2>📊 Laporan & Rekap Pendapatan</h2>

    <div class="periode-tabs">
        <a href="/admin/laporan?periode=harian" class="{{ $periode == 'harian' ? 'active' : '' }}">Harian</a>
        <a href="/admin/laporan?periode=mingguan" class="{{ $periode == 'mingguan' ? 'active' : '' }}">Mingguan</a>
        <a href="/admin/laporan?periode=bulanan" class="{{ $periode == 'bulanan' ? 'active' : '' }}">Bulanan</a>
    </div>

    <div class="stat-grid">
        <div class="stat-card">
            <div class="label">Jumlah Transaksi Selesai</div>
            <div class="value">{{ $jumlahTransaksi }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Pendapatan Sewa</div>
            <div class="value">Rp {{ number_format($totalSewa, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Pendapatan Denda</div>
            <div class="value">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card highlight">
            <div class="label">Total Pendapatan</div>
            <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
    </div>

    @if($transaksiSelesai->isEmpty())
        <div class="empty-state">Belum ada transaksi selesai pada periode ini.</div>
    @else
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Penyewa</th>
                    <th>Sepeda</th>
                    <th>Selesai Pada</th>
                    <th>Biaya Sewa</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksiSelesai as $t)
                <tr>
                    <td>#{{ $t->id_penyewaan }}</td>
                    <td>{{ $t->nama_penyewa }}</td>
                    <td>{{ $t->tipe }}</td>
                    <td>{{ \Carbon\Carbon::parse($t->updated_at)->format('d M Y H:i') }}</td>
                    <td>Rp {{ number_format($t->total_biaya, 0, ',', '.') }}</td>
                    <td>
                        @if($t->total_denda > 0)
                            <span class="denda-tag">Rp {{ number_format($t->total_denda, 0, ',', '.') }}</span>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

</body>
</html>
