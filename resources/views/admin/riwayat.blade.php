<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - Rental Sepeda</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background: linear-gradient(135deg, #f0fdf4 0%, #e0f2fe 100%); color: #1e293b; }
        .container { max-width: 1200px; margin: auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0px 10px 30px rgba(15, 23, 42, 0.06); border: 1px solid #e2e8f0; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; font-size: 13px; color: #64748b; }
        .topbar .role-badge { background: #d1fae5; color: #047857; font-weight: 700; padding: 2px 8px; border-radius: 4px; font-size: 11px; text-transform: uppercase; margin-left: 6px; }
        .btn-logout { background: transparent; color: #ef4444; border: 1px solid #fecaca; padding: 6px 14px; border-radius: 6px; font-size: 13px; cursor: pointer; }
        h2 { text-align: center; font-size: 24px; color: #0f172a; border-bottom: 3px solid #f1f5f9; padding-bottom: 20px; margin-bottom: 20px; }

        .filter-bar { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; margin-bottom: 18px; padding: 14px; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0; }
        .filter-bar select, .filter-bar input[type="text"] { padding: 8px 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; background: #fff; }
        .filter-bar .btn-filter { background: #0f172a; color: #fff; padding: 8px 16px; font-size: 13px; border-radius: 6px; border: none; cursor: pointer; }
        .filter-bar .btn-reset { background: #f1f5f9; color: #475569; padding: 8px 16px; font-size: 13px; border-radius: 6px; text-decoration: none; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #e2e8f0; text-align: left; padding: 12px; font-size: 13px; }
        th { background-color: #f8fafc; color: #64748b; font-weight: 600; }
        td { background-color: #fff; color: #1e293b; }

        .status-badge { font-weight: bold; padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .status-selesai { color: #047857; background-color: #d1fae5; border: 1px solid #a7f3d0; }
        .status-ditolak { color: #dc2626; background-color: #fef2f2; border: 1px solid #fecaca; }
        .denda-tag { color: #dc2626; font-weight: 700; }
        .empty-state { text-align: center; color: #94a3b8; padding: 30px 0; font-size: 14px; }
        .pagination { margin-top: 16px; }
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

    <h2>📜 Riwayat Transaksi Selesai</h2>

    <form method="GET" action="/admin/riwayat" class="filter-bar">
        <input type="text" name="cari" placeholder="Cari nama penyewa / no transaksi..." value="{{ request('cari') }}">
        <select name="status">
            <option value="">Semua Status</option>
            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
        <button type="submit" class="btn-filter">Filter</button>
        <a href="/admin/riwayat" class="btn-reset">Reset</a>
    </form>

    @if($riwayat->isEmpty())
        <div class="empty-state">Belum ada riwayat transaksi.</div>
    @else
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Penyewa</th>
                    <th>Sepeda</th>
                    <th>Tgl Sewa</th>
                    <th>Tgl Selesai</th>
                    <th>Total Biaya</th>
                    <th>Denda</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riwayat as $t)
                <tr>
                    <td>#{{ $t->id_penyewaan }}</td>
                    <td>{{ $t->nama_penyewa }}</td>
                    <td>{{ $t->tipe }}</td>
                    <td>{{ \Carbon\Carbon::parse($t->tanggal_sewa)->format('d M Y H:i') }}</td>
                    <td>{{ $t->tanggal_selesai ? \Carbon\Carbon::parse($t->tanggal_selesai)->format('d M Y H:i') : '-' }}</td>
                    <td>Rp {{ number_format($t->total_biaya, 0, ',', '.') }}</td>
                    <td>
                        @if($t->total_denda > 0)
                            <span class="denda-tag">Rp {{ number_format($t->total_denda, 0, ',', '.') }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <span class="status-badge {{ $t->status == 'Selesai' ? 'status-selesai' : 'status-ditolak' }}">{{ $t->status }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination">{{ $riwayat->links() }}</div>
    @endif
</div>

</body>
</html>
