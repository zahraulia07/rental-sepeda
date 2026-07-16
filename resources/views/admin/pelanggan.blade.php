<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pelanggan - Rental Sepeda</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0; padding: 40px 24px;
            background-color: #f4f8fb;
            background-image:
                radial-gradient(circle at 8% 8%, rgba(99, 102, 241, 0.14), transparent 32%),
                radial-gradient(circle at 92% 18%, rgba(139, 92, 246, 0.14), transparent 34%),
                radial-gradient(circle at 50% 95%, rgba(16, 185, 129, 0.08), transparent 38%);
            background-attachment: fixed;
            color: #1e293b;
        }
        .container { max-width: 900px; margin: auto; background: #fff; padding: 32px; border-radius: 24px; box-shadow: 0px 14px 40px rgba(15, 23, 42, 0.07); border: 1px solid #eef2f7; }

        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; font-size: 13px; color: #64748b; }
        .brand { display: flex; align-items: center; gap: 8px; font-weight: 800; color: #0f172a; font-size: 15px; }
        .brand .dot { width: 10px; height: 10px; border-radius: 50%; background: linear-gradient(135deg, #6366f1, #8b5cf6); }
        .topbar .role-badge { background: linear-gradient(135deg, #ede9fe, #ddd6fe); color: #6d28d9; font-weight: 700; padding: 3px 10px; border-radius: 999px; font-size: 11px; text-transform: uppercase; margin-left: 6px; }
        .btn-logout { background: #fff; color: #ef4444; border: 1px solid #fecaca; padding: 8px 16px; border-radius: 999px; font-size: 13px; cursor: pointer; font-weight: 700; transition: all 0.15s; }
        .btn-logout:hover { background: #ef4444; color: #fff; border-color: #ef4444; }

        h2 { text-align: center; font-size: 22px; color: #0f172a; border-bottom: 2px solid #f1f5f9; padding-bottom: 22px; margin: 0 0 24px; }
        .alert { padding: 13px 16px; background-color: #ecfdf5; color: #047857; border-radius: 12px; margin-bottom: 20px; font-size: 14px; border: 1px solid #a7f3d0; font-weight: 600; }

        .filter-bar { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; margin-bottom: 20px; padding: 12px; background: #f8fafc; border-radius: 16px; border: 1px solid #eef2f7; }
        .filter-bar input[type="text"] { padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 999px; font-size: 13px; background: #fff; flex: 1; min-width: 200px; }
        .filter-bar .btn-filter { background: linear-gradient(135deg, #0f172a, #334155); color: #fff; padding: 10px 22px; font-size: 13px; border-radius: 999px; border: none; cursor: pointer; font-weight: 700; }
        .filter-bar .btn-reset { background: #fff; color: #475569; border: 1px solid #e2e8f0; padding: 10px 22px; font-size: 13px; border-radius: 999px; text-decoration: none; font-weight: 700; }

        .table-wrapper { overflow-x: auto; border-radius: 16px; border: 1px solid #eef2f7; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 15px; font-size: 13.5px; border-bottom: 1px solid #f1f5f9; }
        th { background-color: #f8fafc; color: #64748b; font-weight: 700; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.4px; }
        td { background-color: #fff; color: #1e293b; }
        tbody tr:last-child td { border-bottom: none; }

        .status-badge { font-weight: 700; padding: 3px 10px; border-radius: 999px; font-size: 11px; margin-left: 8px; }
        .status-blokir { color: #dc2626; background-color: #fef2f2; }

        .row-pelanggan { cursor: pointer; }
        .row-pelanggan:hover td { background-color: #fafbff; }
        .hint-klik { color: #94a3b8; font-size: 11px; float: right; }

        /* Modal detail akun */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.45); display: none; justify-content: center; align-items: center; z-index: 9999; backdrop-filter: blur(4px); }
        .modal-box-detail { background: #fff; padding: 28px; border-radius: 20px; width: 100%; max-width: 480px; border: 1px solid #eef2f7; max-height: 88vh; overflow-y: auto; box-shadow: 0 20px 50px rgba(15,23,42,0.18); }
        .detail-foto-wrap { text-align: center; margin-bottom: 16px; }
        .detail-foto-wrap img, .detail-foto-wrap .no-foto { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #a5b4fc; }
        .detail-foto-wrap .no-foto { display: flex; align-items: center; justify-content: center; font-size: 42px; background: linear-gradient(135deg, #eef2ff, #f5f3ff); margin: 0 auto; }
        .detail-nama { text-align: center; font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 2px; }
        .detail-username { text-align: center; font-size: 13px; color: #64748b; margin-bottom: 18px; }
        .detail-grid { display: grid; grid-template-columns: 130px 1fr; gap: 11px 12px; font-size: 13px; margin: 0; }
        .detail-grid dt { color: #64748b; font-weight: 700; }
        .detail-grid dd { margin: 0; color: #0f172a; }
        .detail-status-blokir { color: #dc2626; font-weight: 700; }
        .detail-status-aktif { color: #047857; font-weight: 700; }

        /* Modal blokir */
        .modal-box { background: #fff; padding: 26px; border-radius: 20px; width: 100%; max-width: 420px; border: 1px solid #eef2f7; box-shadow: 0 20px 50px rgba(15,23,42,0.18); }
        .modal-box h3 { margin-top: 0; font-size: 18px; color: #0f172a; }
        .form-group { margin-bottom: 14px; }
        label { display: block; margin-bottom: 6px; font-weight: 700; font-size: 13px; color: #475569; }
        textarea { width: 100%; padding: 11px 12px; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 13px; font-family: inherit; resize: vertical; }
        textarea:focus { outline: none; border-color: #6366f1; box-shadow: 0 0 0 4px rgba(99,102,241,0.12); }
        .btn-simpan { background: linear-gradient(135deg, #ef4444, #dc2626); color: #fff; width: 100%; padding: 12px; border: none; border-radius: 999px; font-weight: 700; margin-top: 4px; cursor: pointer; }
        .btn-batal { background: #f1f5f9; color: #475569; width: 100%; padding: 11px; border: none; border-radius: 999px; margin-top: 8px; font-weight: 700; cursor: pointer; }
        .btn-batal:hover { background: #e2e8f0; color: #0f172a; }
        .btn-aksi { padding: 12px 16px; border: none; border-radius: 999px; cursor: pointer; font-weight: 700; font-size: 13.5px; width: 100%; margin-top: 20px; }
        .btn-blokir { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .btn-blokir:hover { background: #fee2e2; }
        .btn-buka { background: linear-gradient(135deg, #10b981, #06b6d4); color: #fff; }
    </style>
</head>
<body>

<div class="container">
    <div class="topbar">
        <div class="brand"><span class="dot"></span> BikeRent Admin</div>
        <div>Masuk sebagai <b>{{ Auth::user()->name }}</b><span class="role-badge">{{ Auth::user()->role }}</span></div>
        <form action="/logout" method="POST" onsubmit="return confirm('Keluar dari sistem?')">
            @csrf
            <button type="submit" class="btn-logout">Keluar</button>
        </form>
    </div>

    @include('partials.admin-nav')

    <h2>👥 Manajemen Pelanggan</h2>

    @if(session('sukses'))
        <div class="alert">✔️ {{ session('sukses') }}</div>
    @endif

    <form method="GET" action="/admin/pelanggan" class="filter-bar">
        <input type="text" name="cari" placeholder="Cari nama / username / NIK..." value="{{ request('cari') }}">
        <button type="submit" class="btn-filter">Cari</button>
        <a href="/admin/pelanggan" class="btn-reset">Reset</a>
    </form>

    <div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th style="width: 200px;">Total Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($daftarPelanggan as $p)
            <tr class="row-pelanggan" onclick="openDetail(this)"
                data-id="{{ $p->id }}"
                data-nama="{{ $p->name }}"
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
                <td style="font-weight:600;">
                    {{ $p->name }}
                    @if($p->is_blocked)
                        <span class="status-badge status-blokir">Diblokir</span>
                    @endif
                </td>
                <td>{{ $p->total_transaksi }} transaksi <span class="hint-klik">Klik untuk detail →</span></td>
            </tr>
            @empty
            <tr><td colspan="2" style="text-align:center; color:#94a3b8; padding: 30px;">Belum ada pelanggan terdaftar.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
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

        <button type="button" class="btn-aksi btn-blokir" id="detBtnBlokir" onclick="fromDetailBlokir()">Blokir Akun Ini</button>

        <form id="formBukaBlokirDetail" method="POST" style="display:none;">
            @csrf
            <button type="submit" class="btn-aksi btn-buka">Buka Blokir</button>
        </form>

        <button type="button" class="btn-batal" style="margin-top:10px;" onclick="document.getElementById('modalDetail').style.display='none'">Tutup</button>
    </div>
</div>

<div class="modal-overlay" id="modalBlokir">
    <div class="modal-box">
        <h3>Blokir Akun <span id="namaTarget"></span></h3>
        <form id="formBlokir" method="POST">
            @csrf
            <div class="form-group">
                <label>Alasan Pemblokiran:</label>
                <textarea name="alasan_blokir" rows="3" required placeholder="Contoh: Sering telat mengembalikan sepeda"></textarea>
            </div>
            <button type="submit" class="btn-simpan">Blokir Akun Ini</button>
            <button type="button" class="btn-batal" onclick="document.getElementById('modalBlokir').style.display='none'">Batal</button>
        </form>
    </div>
</div>

<script>
    let currentId = null;
    let currentNama = '';

    function openDetail(row) {
        const d = row.dataset;
        currentId = d.id;
        currentNama = d.nama;

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
        const btnBlokir = document.getElementById('detBtnBlokir');
        const formBuka = document.getElementById('formBukaBlokirDetail');

        if (d.status === 'Diblokir') {
            alasanLabel.style.display = '';
            alasanEl.style.display = '';
            alasanEl.innerText = d.alasan || '-';
            btnBlokir.style.display = 'none';
            formBuka.style.display = 'block';
            formBuka.action = '/admin/pelanggan/' + d.id + '/buka-blokir';
        } else {
            alasanLabel.style.display = 'none';
            alasanEl.style.display = 'none';
            btnBlokir.style.display = 'block';
            formBuka.style.display = 'none';
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

    function fromDetailBlokir() {
        document.getElementById('modalDetail').style.display = 'none';
        openBlokir(currentId, currentNama);
    }

    function openBlokir(id, nama) {
        document.getElementById('namaTarget').innerText = nama;
        document.getElementById('formBlokir').action = '/admin/pelanggan/' + id + '/blokir';
        document.getElementById('modalBlokir').style.display = 'flex';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('modalBlokir');
        const modalDet = document.getElementById('modalDetail');
        if (event.target == modal) modal.style.display = 'none';
        if (event.target == modalDet) modalDet.style.display = 'none';
    }
</script>

</body>
</html>
