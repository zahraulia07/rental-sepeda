<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan - Rental Sepeda</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0; padding: 0;
            background-color: #f4f8fb;
            background-image:
                radial-gradient(circle at 8% 8%, rgba(99, 102, 241, 0.14), transparent 32%),
                radial-gradient(circle at 92% 18%, rgba(139, 92, 246, 0.14), transparent 34%),
                radial-gradient(circle at 50% 95%, rgba(16, 185, 129, 0.08), transparent 38%);
            background-attachment: fixed;
            color: #1e293b;
        }
        .container { max-width: 1100px; margin: auto; background: #fff; padding: 32px; border-radius: 24px; box-shadow: 0px 14px 40px rgba(15, 23, 42, 0.07); border: 1px solid #eef2f7; }

        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; font-size: 13px; color: #64748b; }
        .brand { display: flex; align-items: center; gap: 8px; font-weight: 800; color: #0f172a; font-size: 15px; }
        .brand .dot { width: 10px; height: 10px; border-radius: 50%; background: linear-gradient(135deg, #6366f1, #8b5cf6); }
        .topbar .role-badge { background: linear-gradient(135deg, #ede9fe, #ddd6fe); color: #6d28d9; font-weight: 700; padding: 3px 10px; border-radius: 999px; font-size: 11px; text-transform: uppercase; margin-left: 6px; }
        .btn-logout { background: #fff; color: #ef4444; border: 1px solid #fecaca; padding: 8px 16px; border-radius: 999px; font-size: 13px; cursor: pointer; font-weight: 700; transition: all 0.15s; }
        .btn-logout:hover { background: #ef4444; color: #fff; border-color: #ef4444; }

        h2 { text-align: center; font-size: 22px; color: #0f172a; border-bottom: 2px solid #f1f5f9; padding-bottom: 22px; margin: 0 0 24px; }

        .periode-tabs { display: flex; gap: 8px; justify-content: center; margin-bottom: 26px; background: #f8fafc; padding: 6px; border-radius: 999px; border: 1px solid #eef2f7; max-width: 420px; margin-left: auto; margin-right: auto; }
        .periode-tabs a { text-decoration: none; padding: 9px 20px; border-radius: 999px; font-size: 13px; font-weight: 700; color: #64748b; flex: 1; text-align: center; transition: all 0.2s; }
        .periode-tabs a:hover { color: #0f172a; }
        .periode-tabs a.active { background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; box-shadow: 0 8px 18px rgba(99,102,241,0.30); }

        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 16px; margin-bottom: 28px; }
        .stat-card { background: #f8fafc; border: 1px solid #eef2f7; border-radius: 18px; padding: 20px; position: relative; overflow: hidden; }
        .stat-card .ico { width: 38px; height: 38px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; margin-bottom: 12px; background: #e0e7ff; }
        .stat-card .label { font-size: 12px; color: #64748b; text-transform: uppercase; font-weight: 700; letter-spacing: 0.3px; }
        .stat-card .value { font-size: 22px; font-weight: 800; color: #0f172a; margin-top: 6px; }
        .stat-card.highlight { background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%); border-color: transparent; }
        .stat-card.highlight .ico { background: rgba(255,255,255,0.22); }
        .stat-card.highlight .label { color: rgba(255,255,255,0.85); }
        .stat-card.highlight .value { color: #fff; }

        .table-wrapper { overflow-x: auto; border-radius: 16px; border: 1px solid #eef2f7; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 13px 14px; font-size: 13px; border-bottom: 1px solid #f1f5f9; }
        th { background-color: #f8fafc; color: #64748b; font-weight: 700; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.4px; }
        td { background-color: #fff; color: #1e293b; }
        tbody tr:last-child td { border-bottom: none; }
        .denda-tag { color: #dc2626; font-weight: 700; }
        .empty-state { text-align: center; color: #94a3b8; padding: 40px 0; font-size: 14px; }
    </style>
</head>
<body>

<div class="app-shell">
@include('partials.admin-sidebar')
<main class="admin-main">
<div class="container">

    <h2>📊 Laporan & Rekap Pendapatan</h2>

    <div class="periode-tabs">
        <a href="/admin/laporan?periode=harian" class="{{ $periode == 'harian' ? 'active' : '' }}">Harian</a>
        <a href="/admin/laporan?periode=mingguan" class="{{ $periode == 'mingguan' ? 'active' : '' }}">Mingguan</a>
        <a href="/admin/laporan?periode=bulanan" class="{{ $periode == 'bulanan' ? 'active' : '' }}">Bulanan</a>
    </div>

    <div class="stat-grid">
        <div class="stat-card">
            <div class="ico">📦</div>
            <div class="label">Jumlah Transaksi Selesai</div>
            <div class="value">{{ $jumlahTransaksi }}</div>
        </div>
        <div class="stat-card">
            <div class="ico">🚲</div>
            <div class="label">Pendapatan Sewa</div>
            <div class="value">Rp {{ number_format($totalSewa, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="ico">⏱️</div>
            <div class="label">Pendapatan Denda</div>
            <div class="value">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card highlight">
            <div class="ico">💰</div>
            <div class="label">Total Pendapatan</div>
            <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
    </div>

    @if($transaksiSelesai->isEmpty())
        <div class="empty-state">Belum ada transaksi selesai pada periode ini.</div>
    @else
    <div class="table-wrapper">
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
    </div>
    @endif
</div>

</main>
</div>

</body>
</html>
