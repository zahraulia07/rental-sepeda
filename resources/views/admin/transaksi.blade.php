<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Transaksi - Rental Sepeda</title>
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
        .container { max-width: 1220px; margin: auto; background: #fff; padding: 32px; border-radius: 24px; box-shadow: 0px 14px 40px rgba(15, 23, 42, 0.07); border: 1px solid #eef2f7; }

        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; font-size: 13px; color: #64748b; }
        .brand { display: flex; align-items: center; gap: 8px; font-weight: 800; color: #0f172a; font-size: 15px; }
        .brand .dot { width: 10px; height: 10px; border-radius: 50%; background: linear-gradient(135deg, #6366f1, #8b5cf6); }
        .topbar .user-info b { color: #0f172a; }
        .topbar .role-badge { background: linear-gradient(135deg, #ede9fe, #ddd6fe); color: #6d28d9; font-weight: 700; padding: 3px 10px; border-radius: 999px; font-size: 11px; text-transform: uppercase; margin-left: 6px; }
        .btn-logout { background: #fff; color: #ef4444; border: 1px solid #fecaca; padding: 8px 16px; border-radius: 999px; font-size: 13px; cursor: pointer; font-weight: 700; transition: all 0.15s; }
        .btn-logout:hover { background: #ef4444; color: #fff; border-color: #ef4444; }

        h2 { text-align: center; font-size: 22px; color: #0f172a; border-bottom: 2px solid #f1f5f9; padding-bottom: 22px; margin: 0 0 24px; }

        .alert { padding: 13px 16px; background-color: #ecfdf5; color: #047857; border-radius: 12px; margin-bottom: 20px; font-size: 14px; border: 1px solid #a7f3d0; font-weight: 600; }
        .alert-gagal { padding: 13px 16px; background-color: #fef2f2; color: #b91c1c; border-radius: 12px; margin-bottom: 20px; font-size: 14px; border: 1px solid #fecaca; font-weight: 600; }

        .filter-bar { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; margin-bottom: 20px; padding: 12px; background: #f8fafc; border-radius: 16px; border: 1px solid #eef2f7; }
        .filter-bar select, .filter-bar input[type="text"] { padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 999px; font-size: 13px; background: #fff; }
        .filter-bar input[type="text"] { flex: 1; min-width: 200px; }
        .filter-bar .btn-filter { background: linear-gradient(135deg, #0f172a, #334155); color: #fff; padding: 10px 22px; font-size: 13px; border-radius: 999px; border: none; cursor: pointer; font-weight: 700; }
        .filter-bar .btn-reset { background: #fff; color: #475569; border: 1px solid #e2e8f0; padding: 10px 22px; font-size: 13px; border-radius: 999px; text-decoration: none; font-weight: 700; }

        .table-wrapper { overflow-x: auto; border-radius: 16px; border: 1px solid #eef2f7; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 13px 14px; font-size: 13px; border-bottom: 1px solid #f1f5f9; }
        th { background-color: #f8fafc; color: #64748b; font-weight: 700; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.4px; }
        td { background-color: #fff; color: #1e293b; }
        tbody tr:last-child td { border-bottom: none; }

        .row-transaksi { cursor: pointer; }
        .row-transaksi:hover td { background-color: #fafbff; }
        .hint-klik { color: #94a3b8; font-size: 10.5px; display: block; margin-top: 2px; }

        .status-badge { font-weight: 700; padding: 4px 10px; border-radius: 999px; font-size: 11.5px; white-space: nowrap; }
        .status-pending { color: #b45309; background-color: #fef3c7; }
        .status-disetujui { color: #1d4ed8; background-color: #dbeafe; }
        .status-sedang-disewa { color: #6d28d9; background-color: #ede9fe; }
        .status-belum-bayar { color: #b45309; background-color: #fef3c7; }
        .status-sudah-bayar { color: #047857; background-color: #d1fae5; }
        .status-blokir { color: #dc2626; background-color: #fef2f2; font-size: 10.5px; margin-left: 6px; }

        button.btn-aksi { padding: 8px 14px; border: none; border-radius: 999px; cursor: pointer; font-weight: 700; font-size: 12px; margin: 2px; }
        .btn-setuju { background: linear-gradient(135deg, #10b981, #06b6d4); color: #fff; }
        .btn-tolak { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .btn-ambil { background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; }
        .btn-kembali { background: #0ea5e9; color: #fff; }

        .empty-state { text-align: center; color: #94a3b8; padding: 40px 0; font-size: 14px; }
        .denda-tag { color: #dc2626; font-weight: 700; }
        .estimasi-denda { display: block; margin-top: 4px; font-size: 10.5px; color: #dc2626; font-weight: 700; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 3px 8px; }

        /* Modal detail akun pelanggan */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.45); display: none; justify-content: center; align-items: center; z-index: 9999; backdrop-filter: blur(4px); }
        .modal-box-detail { background: #fff; padding: 28px; border-radius: 20px; width: 100%; max-width: 480px; border: 1px solid #eef2f7; max-height: 88vh; overflow-y: auto; box-shadow: 0 20px 50px rgba(15,23,42,0.18); }
        .detail-foto-wrap { text-align: center; margin-bottom: 16px; }
        .detail-foto-wrap img, .detail-foto-wrap .no-foto { width: 96px; height: 96px; border-radius: 50%; object-fit: cover; border: 3px solid #a5b4fc; }
        .detail-foto-wrap .no-foto { display: flex; align-items: center; justify-content: center; font-size: 40px; background: linear-gradient(135deg, #eef2ff, #f5f3ff); margin: 0 auto; }
        .detail-nama { text-align: center; font-size: 17px; font-weight: 800; color: #0f172a; margin-bottom: 2px; }
        .detail-username { text-align: center; font-size: 13px; color: #64748b; margin-bottom: 18px; }
        .detail-grid { display: grid; grid-template-columns: 130px 1fr; gap: 11px 12px; font-size: 13px; margin: 0; }
        .detail-grid dt { color: #64748b; font-weight: 700; }
        .detail-grid dd { margin: 0; color: #0f172a; }
        .detail-status-blokir { color: #dc2626; font-weight: 700; }
        .detail-status-aktif { color: #047857; font-weight: 700; }
        .btn-tutup-detail { background: #f1f5f9; color: #475569; width: 100%; padding: 11px; border: none; border-radius: 999px; margin-top: 18px; font-weight: 700; cursor: pointer; }
        .btn-tutup-detail:hover { background: #e2e8f0; color: #0f172a; }
    </style>
</head>
<body>

<div class="app-shell">
@include('partials.admin-sidebar')
<main class="admin-main">
<div class="container">

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
    <div class="table-wrapper">
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
                    <th style="width: 230px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($daftarTransaksi as $t)
                <tr class="row-transaksi" onclick="openDetail(this)"
                    data-id="{{ $t->user_id }}"
                    data-nama="{{ $t->nama_penyewa }}"
                    data-username="{{ $t->username }}"
                    data-email="{{ $t->email }}"
                    data-tempat-lahir="{{ $t->tempat_lahir }}"
                    data-tanggal-lahir="{{ $t->tanggal_lahir ? \Carbon\Carbon::parse($t->tanggal_lahir)->format('d M Y') : '-' }}"
                    data-jenis-kelamin="{{ $t->jenis_kelamin }}"
                    data-ktp="{{ $t->no_ktp }}"
                    data-hp="{{ $t->no_hp }}"
                    data-alamat="{{ $t->alamat }}"
                    data-total="{{ $t->total_transaksi }}"
                    data-status="{{ $t->is_blocked ? 'Diblokir' : 'Aktif' }}"
                    data-alasan="{{ $t->alasan_blokir }}"
                    data-foto="{{ $t->foto_profil ? asset('storage/' . $t->foto_profil) : '' }}">
                    <td>#{{ $t->id_penyewaan }}</td>
                    <td>
                        {{ $t->nama_penyewa }}
                        @if($t->is_blocked)<span class="status-badge status-blokir">Diblokir</span>@endif
                        <span class="hint-klik">Klik baris untuk lihat akun →</span>
                    </td>
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
                    <td onclick="event.stopPropagation()">
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
    </div>
    @endif
</div>

<div class="modal-overlay" id="modalDetail">
    <div class="modal-box-detail">
        <div class="detail-foto-wrap">
            <img id="detFoto" src="" alt="Foto Profil" style="display:none;">
            <div id="detNoFoto" class="no-foto">👤</div>
        </div>
        <div class="detail-nama" id="detNama"></div>
        <div class="detail-username" id="detUsername"></div>

        <dl class="detail-grid">
            <dt>Email</dt><dd id="detEmail"></dd>
            <dt>Tempat, Tgl Lahir</dt><dd id="detTtl"></dd>
            <dt>Jenis Kelamin</dt><dd id="detGender"></dd>
            <dt>No. KTP</dt><dd id="detKtp"></dd>
            <dt>No. HP</dt><dd id="detHp"></dd>
            <dt>Alamat</dt><dd id="detAlamat"></dd>
            <dt>Total Transaksi</dt><dd id="detTotal"></dd>
            <dt>Status Akun</dt><dd id="detStatus"></dd>
            <dt id="detAlasanLabel" style="display:none;">Alasan Blokir</dt><dd id="detAlasan" style="display:none;"></dd>
        </dl>

        <button type="button" class="btn-tutup-detail" onclick="document.getElementById('modalDetail').style.display='none'">Tutup</button>
    </div>
</div>

<script>
    function openDetail(row) {
        const d = row.dataset;

        document.getElementById('detNama').innerText = d.nama;
        document.getElementById('detUsername').innerText = '@' + d.username;
        document.getElementById('detEmail').innerText = d.email || '-';
        document.getElementById('detTtl').innerText = (d.tempatLahir || '-') + ', ' + (d.tanggalLahir || '-');
        document.getElementById('detGender').innerText = d.jenisKelamin || '-';
        document.getElementById('detKtp').innerText = d.ktp || '-';
        document.getElementById('detHp').innerText = d.hp || '-';
        document.getElementById('detAlamat').innerText = d.alamat || '-';
        document.getElementById('detTotal').innerText = d.total + ' transaksi';

        const statusEl = document.getElementById('detStatus');
        statusEl.innerText = d.status;
        statusEl.className = d.status === 'Diblokir' ? 'detail-status-blokir' : 'detail-status-aktif';

        const alasanLabel = document.getElementById('detAlasanLabel');
        const alasanEl = document.getElementById('detAlasan');
        if (d.status === 'Diblokir') {
            alasanLabel.style.display = '';
            alasanEl.style.display = '';
            alasanEl.innerText = d.alasan || '-';
        } else {
            alasanLabel.style.display = 'none';
            alasanEl.style.display = 'none';
        }

        const fotoEl = document.getElementById('detFoto');
        const noFotoEl = document.getElementById('detNoFoto');
        if (d.foto) {
            fotoEl.src = d.foto;
            fotoEl.style.display = 'inline-block';
            noFotoEl.style.display = 'none';
        } else {
            fotoEl.style.display = 'none';
            noFotoEl.style.display = 'flex';
        }

        document.getElementById('modalDetail').style.display = 'flex';
    }

    window.onclick = function(event) {
        const modalDet = document.getElementById('modalDetail');
        if (event.target == modalDet) modalDet.style.display = 'none';
    }
</script>

</main>
</div>

</body>
</html>
