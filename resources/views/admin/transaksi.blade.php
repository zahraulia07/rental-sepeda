<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Transaksi - Rental Sepeda</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background: linear-gradient(135deg, #f0fdf4 0%, #e0f2fe 100%); color: #1e293b; }
        .container { max-width: 1200px; margin: auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0px 10px 30px rgba(15, 23, 42, 0.06); border: 1px solid #e2e8f0; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; font-size: 13px; color: #64748b; }
        .topbar .user-info b { color: #0f172a; }
        .topbar .role-badge { background: #d1fae5; color: #047857; font-weight: 700; padding: 2px 8px; border-radius: 4px; font-size: 11px; text-transform: uppercase; margin-left: 6px; }
        .btn-logout { background: transparent; color: #ef4444; border: 1px solid #fecaca; padding: 6px 14px; border-radius: 6px; font-size: 13px; cursor: pointer; }
        .btn-logout:hover { background: #fef2f2; }
        h2 { text-align: center; font-size: 24px; color: #0f172a; border-bottom: 3px solid #f1f5f9; padding-bottom: 20px; margin-bottom: 20px; }
        .alert { padding: 12px; background-color: #f0fdf4; color: #15803d; border-radius: 6px; margin-bottom: 20px; font-size: 14px; border-left: 5px solid #10b981; }
        .alert-gagal { padding: 12px; background-color: #fef2f2; color: #b91c1c; border-radius: 6px; margin-bottom: 20px; font-size: 14px; border-left: 5px solid #ef4444; }

        .filter-bar { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; margin-bottom: 18px; padding: 14px; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0; }
        .filter-bar select, .filter-bar input[type="text"] { padding: 8px 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; background: #fff; }
        .filter-bar .btn-filter { background: #0f172a; color: #fff; padding: 8px 16px; font-size: 13px; border-radius: 6px; border: none; cursor: pointer; }
        .filter-bar .btn-reset { background: #f1f5f9; color: #475569; padding: 8px 16px; font-size: 13px; border-radius: 6px; text-decoration: none; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #e2e8f0; text-align: left; padding: 12px; font-size: 13px; }
        th { background-color: #f8fafc; color: #64748b; font-weight: 600; }
        td { background-color: #fff; color: #1e293b; }

        .status-badge { font-weight: bold; padding: 4px 8px; border-radius: 4px; font-size: 12px; white-space: nowrap; }
        .status-pending { color: #b45309; background-color: #fef3c7; border: 1px solid #fde68a; }
        .status-disetujui { color: #1d4ed8; background-color: #dbeafe; border: 1px solid #bfdbfe; }
        .status-sedang-disewa { color: #6d28d9; background-color: #ede9fe; border: 1px solid #ddd6fe; }
        .status-belum-bayar { color: #b45309; background-color: #fef3c7; border: 1px solid #fde68a; }
        .status-sudah-bayar { color: #047857; background-color: #d1fae5; border: 1px solid #a7f3d0; }

        .btn-aksi { padding: 7px 12px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 12px; margin: 2px; }
        .btn-setuju { background: #10b981; color: #fff; }
        .btn-tolak { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .btn-ambil { background: #6d28d9; color: #fff; }
        .btn-kembali { background: #0ea5e9; color: #fff; }

        .empty-state { text-align: center; color: #94a3b8; padding: 30px 0; font-size: 14px; }
        .denda-tag { color: #dc2626; font-weight: 700; }
        .estimasi-denda { display: block; margin-top: 4px; font-size: 11px; color: #dc2626; font-weight: 700; background: #fef2f2; border: 1px solid #fecaca; border-radius: 4px; padding: 3px 6px; }
    </style>
</head>
<body>

<div class="container">
    <div class="topbar">
        <div class="user-info">Masuk sebagai <b>{{ Auth::user()->name }}</b><span class="role-badge">{{ Auth::user()->role }}</span></div>
        <form action="/logout" method="POST" onsubmit="return confirm('Keluar dari sistem?')">
            @csrf
            <button type="submit" class="btn-logout">Keluar</button>
        </form>
    </div>

    @include('partials.admin-nav')

    <h2>📑 Manajemen Transaksi Aktif</h2>

    @if(session('sukses'))
        <div class="alert">✔️ {{ session('sukses') }}</div>
    @endif
    @if(session('gagal'))
        <div class="alert-gagal">⚠️ {{ session('gagal') }}</div>
    @endif

    <form method="GET" action="/admin/transaksi" class="filter-bar">
        <input type="text" name="cari" placeholder="Cari nama penyewa / no transaksi..." value="{{ request('cari') }}">
        <select name="status">
            <option value="">Semua Status</option>
            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
            <option value="Sedang Disewa" {{ request('status') == 'Sedang Disewa' ? 'selected' : '' }}>Sedang Disewa</option>
        </select>
        <button type="submit" class="btn-filter">Filter</button>
        <a href="/admin/transaksi" class="btn-reset">Reset</a>
    </form>

    @if($daftarTransaksi->isEmpty())
        <div class="empty-state">Tidak ada transaksi aktif saat ini.</div>
    @else
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Penyewa</th>
                    <th>Sepeda</th>
                    <th>Durasi</th>
                    <th>Total Biaya</th>
                    <th>Batas Kembali</th>
                    <th>Status</th>
                    <th>Status Pembayaran</th>
                    <th style="width: 220px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($daftarTransaksi as $t)
                <tr>
                    <td>#{{ $t->id_penyewaan }}</td>
                    <td>{{ $t->nama_penyewa }}<br><small style="color:#94a3b8;">{{ $t->no_hp }}</small></td>
                    <td>{{ $t->tipe }}</td>
                    <td>{{ $t->durasi }} {{ $t->jenis_sewa == 'per_jam' ? 'jam' : 'hari' }}</td>
                    <td>Rp {{ number_format($t->total_biaya, 0, ',', '.') }}</td>
                    <td>
                        {{ $t->deadline_kembali ? \Carbon\Carbon::parse($t->deadline_kembali)->format('d M Y H:i') : '-' }}
                        @if($t->status == 'Sedang Disewa' && $t->deadline_kembali && now()->greaterThan(\Carbon\Carbon::parse($t->deadline_kembali)))
                            @php
                                $deadline = \Carbon\Carbon::parse($t->deadline_kembali);
                                $dendaPerJam = $t->denda_per_jam ?? 5000;
                                $dendaPerHari = $t->denda_per_hari ?? 0;
                                if ($t->jenis_sewa === 'per_hari' && $dendaPerHari > 0) {
                                    $telatUnit = ceil($deadline->diffInHours(now()) / 24);
                                    $labelTelat = $telatUnit . ' hari';
                                    $estimasiDenda = $telatUnit * $dendaPerHari;
                                } else {
                                    $telatUnit = ceil($deadline->diffInMinutes(now()) / 60);
                                    $labelTelat = $telatUnit . ' jam';
                                    $estimasiDenda = $telatUnit * $dendaPerJam;
                                }
                            @endphp
                            <span class="estimasi-denda">⚠️ Telat {{ $labelTelat }} · Estimasi denda Rp {{ number_format($estimasiDenda, 0, ',', '.') }}</span>
                        @endif
                    </td>
                    <td>
                        <span class="status-badge {{ $t->status == 'Pending' ? 'status-pending' : ($t->status == 'Disetujui' ? 'status-disetujui' : 'status-sedang-disewa') }}">
                            {{ $t->status }}
                        </span>
                    </td>
                    <td>
                        @if($t->status_pembayaran == 'Sudah Dibayar')
                            <span class="status-badge status-sudah-bayar">Sudah Dibayar</span>
                        @else
                            <span class="status-badge status-belum-bayar">Belum Dibayar</span>
                        @endif
                    </td>
                    <td>
                        @if($t->status == 'Pending')
                            <form action="/admin/transaksi/{{ $t->id_penyewaan }}/setujui" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn-aksi btn-setuju">Setujui</button>
                            </form>
                            <form action="/admin/transaksi/{{ $t->id_penyewaan }}/tolak" method="POST" style="display:inline;" onsubmit="return confirm('Tolak pesanan ini?')">
                                @csrf
                                <button type="submit" class="btn-aksi btn-tolak">Tolak</button>
                            </form>
                        @elseif($t->status == 'Disetujui')
                            <form action="/admin/transaksi/{{ $t->id_penyewaan }}/ambil" method="POST" style="display:inline;" onsubmit="return confirm('Konfirmasi sepeda sudah diambil penyewa?')">
                                @csrf
                                <button type="submit" class="btn-aksi btn-ambil">Konfirmasi Ambil</button>
                            </form>
                        @elseif($t->status == 'Sedang Disewa')
                            <form action="/admin/transaksi/{{ $t->id_penyewaan }}/kembalikan" method="POST" style="display:inline;" onsubmit="return confirm('Konfirmasi sepeda sudah dikembalikan? Denda akan dihitung otomatis jika telat.')">
                                @csrf
                                <button type="submit" class="btn-aksi btn-kembali">Konfirmasi Kembali</button>
                            </form>
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
