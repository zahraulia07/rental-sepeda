<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pembayaran - Rental Sepeda</title>
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
        .container { max-width: 1000px; margin: auto; background: #fff; padding: 32px; border-radius: 24px; box-shadow: 0px 14px 40px rgba(15, 23, 42, 0.07); border: 1px solid #eef2f7; }

        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; font-size: 13px; color: #64748b; }
        .brand { display: flex; align-items: center; gap: 8px; font-weight: 800; color: #0f172a; font-size: 15px; }
        .brand .dot { width: 10px; height: 10px; border-radius: 50%; background: linear-gradient(135deg, #6366f1, #8b5cf6); }
        .topbar .role-badge { background: linear-gradient(135deg, #ede9fe, #ddd6fe); color: #6d28d9; font-weight: 700; padding: 3px 10px; border-radius: 999px; font-size: 11px; text-transform: uppercase; margin-left: 6px; }
        .btn-logout { background: #fff; color: #ef4444; border: 1px solid #fecaca; padding: 8px 16px; border-radius: 999px; font-size: 13px; cursor: pointer; font-weight: 700; transition: all 0.15s; }
        .btn-logout:hover { background: #ef4444; color: #fff; border-color: #ef4444; }

        h2 { text-align: center; font-size: 22px; color: #0f172a; border-bottom: 2px solid #f1f5f9; padding-bottom: 22px; margin: 0 0 24px; }
        .alert { padding: 13px 16px; background-color: #ecfdf5; color: #047857; border-radius: 12px; margin-bottom: 20px; font-size: 14px; border: 1px solid #a7f3d0; font-weight: 600; }

        .card-list { display: flex; flex-direction: column; gap: 14px; }
        .card {
            border: 1px solid #eef2f7; border-radius: 18px; padding: 20px;
            display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap;
            transition: all 0.2s ease; cursor: pointer; background: #fff;
        }
        .card:hover { border-color: #c7d2fe; box-shadow: 0 8px 22px rgba(99,102,241,0.10); transform: translateY(-2px); }
        .card .info b { color: #0f172a; font-size: 14.5px; }
        .card .info .meta { font-size: 12.5px; color: #64748b; margin-top: 6px; }
        .card .bukti a { font-size: 12.5px; color: #6366f1; text-decoration: none; font-weight: 700; }
        .card .bukti a:hover { text-decoration: underline; }
        .card .hint-klik { display: block; font-size: 10.5px; color: #94a3b8; margin-top: 6px; }

        .status-badge { font-weight: 700; padding: 4px 12px; border-radius: 999px; font-size: 12px; }
        .status-menunggu { color: #b45309; background-color: #fef3c7; }
        .status-terverifikasi { color: #047857; background-color: #d1fae5; }
        .status-ditolak { color: #dc2626; background-color: #fef2f2; }
        .status-blokir { color: #dc2626; background-color: #fef2f2; font-size: 10.5px; margin-left: 6px; }

        .btn-aksi { padding: 9px 16px; border: none; border-radius: 999px; cursor: pointer; font-weight: 700; font-size: 12.5px; margin-left: 4px; }
        .btn-verif { background: linear-gradient(135deg, #10b981, #06b6d4); color: #fff; }
        .btn-tolak { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .empty-state { text-align: center; color: #94a3b8; padding: 40px 0; font-size: 14px; }

        /* Modal detail akun pelanggan (sama seperti halaman Pelanggan / Transaksi) */
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

    <h2>💳 Verifikasi Pembayaran</h2>

    @if(session('sukses'))
        <div class="alert">✔️ {{ session('sukses') }}</div>
    @endif

    @if($daftarPembayaran->isEmpty())
        <div class="empty-state">Belum ada bukti pembayaran yang perlu diverifikasi.</div>
    @else
        <div class="card-list">
            @foreach($daftarPembayaran as $p)
            <div class="card" onclick="openDetail(this)"
                data-id="{{ $p->user_id }}"
                data-nama="{{ $p->nama_penyewa }}"
                data-username="{{ $p->username }}"
                data-email="{{ $p->email }}"
                data-tempat-lahir="{{ $p->tempat_lahir }}"
                data-tanggal-lahir="{{ $p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->format('d M Y') : '-' }}"
                data-jenis-kelamin="{{ $p->jenis_kelamin }}"
                data-ktp="{{ $p->no_ktp }}"
                data-hp="{{ $p->no_hp }}"
                data-alamat="{{ $p->alamat }}"
                data-total="{{ $p->total_transaksi }}"
                data-status="{{ $p->is_blocked ? 'Diblokir' : 'Aktif' }}"
                data-alasan="{{ $p->alasan_blokir }}"
                data-foto="{{ $p->foto_profil ? asset('storage/' . $p->foto_profil) : '' }}">
                <div class="info">
                    <div><b>#{{ $p->id_penyewaan }} — {{ $p->nama_penyewa }}</b>@if($p->is_blocked)<span class="status-badge status-blokir">Diblokir</span>@endif</div>
                    <div class="meta">{{ $p->tipe }} · {{ $p->metode_pembayaran == 'transfer' ? 'Transfer Bank' : 'Tunai' }} · Total: Rp {{ number_format($p->total_biaya + $p->total_denda, 0, ',', '.') }}</div>
                    @if($p->bukti_pembayaran)
                        <div class="bukti" onclick="event.stopPropagation()"><a href="/storage/{{ $p->bukti_pembayaran }}" target="_blank">Lihat bukti transfer →</a></div>
                    @endif
                    <span class="hint-klik">Klik kartu untuk lihat info akun →</span>
                </div>
                <div style="display:flex; align-items:center; gap:10px;" onclick="event.stopPropagation()">
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
    function openDetail(card) {
        const d = card.dataset;

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
