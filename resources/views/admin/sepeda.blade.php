<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Rental Sepeda</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            margin: 0; padding: 40px 24px;
            background-color: #F6F7FB;
            background-image:
                radial-gradient(circle at 6% 0%, rgba(6, 182, 212, 0.10), transparent 30%),
                radial-gradient(circle at 96% 12%, rgba(168, 85, 247, 0.10), transparent 32%);
            background-attachment: fixed;
            color: #10131C;
        }

        .container {
            max-width: 1180px; margin: auto;
            background: #ffffff; padding: 32px;
            border-radius: 24px;
            box-shadow: 0px 14px 40px rgba(15, 23, 42, 0.06);
            border: 1px solid #EEF0F7;
        }

        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; font-size: 13px; color: #6B7280; }
        .topbar .user-info b { color: #10131C; }
        .topbar .role-badge {
            background: linear-gradient(135deg, #E0E7FF, #F3E8FF); color: #6D28D9;
            font-weight: 700; padding: 3px 10px; border-radius: 999px; font-size: 11px;
            text-transform: uppercase; margin-left: 6px;
        }
        .btn-logout {
            background: #fff; color: #E11D48; border: 1px solid #FECDD3;
            padding: 8px 16px; border-radius: 999px; font-size: 13px; cursor: pointer; font-weight: 700;
        }
        .btn-logout:hover { background: #E11D48; color: #fff; border-color: #E11D48; }

        .header-wrapper { text-align: center; padding-bottom: 22px; margin-bottom: 8px; }
        .eyebrow {
            font-family: 'JetBrains Mono', monospace; font-size: 11px; font-weight: 600;
            letter-spacing: 2px; text-transform: uppercase; color: #635BFF; margin-bottom: 6px;
        }
        .header-wrapper h2 {
            font-family: 'Space Grotesk', sans-serif; margin: 0 0 18px 0;
            font-size: 25px; font-weight: 700; color: #10131C; letter-spacing: -0.3px;
        }

        button { border: none; border-radius: 999px; cursor: pointer; font-weight: 700; transition: all 0.18s; font-family: 'Inter', sans-serif; }
        .btn-trigger {
            background: linear-gradient(135deg, #06B6D4 0%, #635BFF 55%, #A855F7 100%); color: white; font-size: 14px;
            display: inline-flex; align-items: center; gap: 8px; padding: 12px 26px;
            box-shadow: 0 10px 22px -6px rgba(99, 91, 255, 0.45);
        }
        .btn-trigger:hover { transform: translateY(-1px); box-shadow: 0 14px 26px -6px rgba(99, 91, 255, 0.55); }

        /* Strip statistik */
        .stat-strip { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin: 26px 0; }
        .stat-chip { border: 1px solid #EEF0F7; border-radius: 16px; padding: 14px 16px; position: relative; overflow: hidden; }
        .stat-chip::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; }
        .stat-chip .stat-label { font-size: 11px; font-weight: 600; color: #8A8FA3; text-transform: uppercase; letter-spacing: 0.5px; }
        .stat-chip .stat-value { font-family: 'JetBrains Mono', monospace; font-size: 22px; font-weight: 600; color: #10131C; margin-top: 4px; }
        .stat-total::before { background: linear-gradient(90deg, #06B6D4, #635BFF); }
        .stat-tersedia::before { background: #059669; }
        .stat-maintenance::before { background: #D97706; }
        .stat-unit::before { background: #A855F7; }

        .alert { padding: 13px 16px; background-color: #ECFDF5; color: #047857; border-radius: 12px; margin-bottom: 20px; font-size: 14px; border: 1px solid #A7F3D0; font-weight: 600; }

        .filter-bar { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; margin-bottom: 20px; padding: 12px; background: #F8FAFC; border-radius: 16px; border: 1px solid #EEF0F7; }
        .filter-bar select, .filter-bar input[type="text"] { padding: 10px 14px; border: 1px solid #E2E8F0; border-radius: 999px; font-size: 13px; background: #fff; font-family: 'Inter', sans-serif; }
        .filter-bar input[type="text"] { flex: 1; min-width: 180px; }
        .filter-bar .btn-filter { background: linear-gradient(135deg, #10131C, #333849); color: #fff; padding: 10px 22px; font-size: 13px; }
        .filter-bar .btn-reset { background: #fff; color: #475569; border: 1px solid #e2e8f0; padding: 10px 22px; font-size: 13px; text-decoration: none; font-weight: 700; }

        .table-wrapper { overflow-x: auto; border-radius: 14px; border: 1px solid #EEF0F7; }
        table { width: 100%; border-collapse: collapse; background: transparent; }
        th, td { text-align: left; padding: 9px 12px; font-size: 12.5px; border-bottom: 1px solid #F2F3F9; }
        th { background-color: #FAFAFD; color: #8A8FA3; font-weight: 700; font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.5px; }
        td { background-color: #ffffff; color: #10131C; }
        tbody tr { border-left: 3px solid transparent; }
        tbody tr:hover { border-left-color: #635BFF; }
        tbody tr:hover td { background-color: #FAFAFF; }
        tbody tr:last-child td { border-bottom: none; }
        .col-num { font-family: 'JetBrains Mono', monospace; text-align: right; }

        .btn-edit, .btn-delete { padding: 6px 13px; font-size: 12px; }
        .btn-edit { background-color: #FFFBEB; color: #B45309; margin-right: 4px; border: 1px solid #FDE68A; }
        .btn-edit:hover { background-color: #FEF3C7; }
        .btn-delete { background-color: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }
        .btn-delete:hover { background-color: #FEE2E2; }

        .btn-add { background: linear-gradient(135deg, #06B6D4 0%, #635BFF 55%, #A855F7 100%); color: white; width: 100%; padding: 13px; font-size: 15px; margin-top: 10px; box-shadow: 0 10px 22px -6px rgba(99, 91, 255, 0.4); }
        .btn-close { background-color: #F1F5F9; color: #475569; width: 100%; padding: 11px; margin-top: 8px; font-size: 14px; }
        .btn-close:hover { background-color: #E2E8F0; color: #10131C; }

        .pill-dot { display: inline-flex; align-items: center; gap: 6px; font-weight: 700; font-size: 12px; padding: 3px 10px 3px 8px; border-radius: 999px; }
        .pill-dot::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
        .status-tersedia { color: #047857; background: #ECFDF5; } .status-tersedia::before { background: #10B981; }
        .status-maintenance { color: #B45309; background: #FFFBEB; } .status-maintenance::before { background: #F59E0B; }

        .stok-badge { font-family: 'JetBrains Mono', monospace; font-weight: 600; }
        .stok-habis { color: #DC2626; }
        .stok-menipis { color: #B45309; }
        .stok-aman { color: #047857; }

        .kategori-chip { background: #EEF2FF; color: #4338CA; padding: 3px 10px; border-radius: 999px; font-size: 11.5px; font-weight: 700; }

        .foto-thumb { width: 38px; height: 38px; object-fit: cover; border-radius: 9px; border: 1px solid #EEF0F7; }
        .foto-thumb-empty { width: 38px; height: 38px; border-radius: 9px; background: linear-gradient(135deg, #EEF2FF, #F5F3FF); display: flex; align-items: center; justify-content: center; font-size: 16px; }

        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.45); display: none; justify-content: center; align-items: center; z-index: 9999; backdrop-filter: blur(4px); }
        .modal-box { background: #ffffff; padding: 26px 30px; border-radius: 20px; width: 100%; max-width: 460px; max-height: 85vh; overflow-y: auto; box-shadow: 0 20px 50px rgba(15, 23, 42, 0.18); border: 1px solid #EEF0F7; animation: fadeIn 0.25s ease; }
        .modal-box h3 { position: sticky; top: -26px; background: #fff; margin: -26px -30px 14px; padding: 26px 30px 14px; z-index: 2; border-bottom: 2px solid #F1F5F9; font-family: 'Space Grotesk', sans-serif; font-size: 18px; color: #10131C; }
        .form-group { margin-bottom: 14px; }
        label { display: block; margin-bottom: 5px; font-weight: 700; font-size: 13px; color: #475569; }
        input, select { width: 100%; padding: 10px 12px; box-sizing: border-box; border: 1px solid #E2E8F0; border-radius: 12px; font-size: 13.5px; background-color: #F8FAFC; color: #10131C; font-family: 'Inter', sans-serif; }
        input:focus, select:focus { outline: none; border-color: #635BFF; box-shadow: 0 0 0 4px rgba(99, 91, 255, 0.12); background: #fff; }

        @keyframes fadeIn { from { transform: translateY(-16px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
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

    <div class="header-wrapper">
        <div class="eyebrow">Panel Kendali Armada</div>
        <h2>Inventaris Rental Sepeda</h2>
        <button class="btn-trigger" onclick="openModal('POST')">＋ Tambah Armada Sepeda</button>
    </div>

    <div class="stat-strip">
        <div class="stat-chip stat-total">
            <div class="stat-label">Total Tipe</div>
            <div class="stat-value">{{ $daftarSepeda->count() }}</div>
        </div>
        <div class="stat-chip stat-tersedia">
            <div class="stat-label">Tersedia</div>
            <div class="stat-value">{{ $daftarSepeda->where('status', 'Tersedia')->count() }}</div>
        </div>
        <div class="stat-chip stat-maintenance">
            <div class="stat-label">Maintenance</div>
            <div class="stat-value">{{ $daftarSepeda->where('status', 'Maintenance')->count() }}</div>
        </div>
        <div class="stat-chip stat-unit">
            <div class="stat-label">Total Unit</div>
            <div class="stat-value">{{ $daftarSepeda->sum('stok') }}</div>
        </div>
    </div>

    @if(session('sukses'))
        <div class="alert">✔️ {{ session('sukses') }}</div>
    @endif

    <form method="GET" action="/admin/sepeda" class="filter-bar">
        <input type="text" name="cari" placeholder="Cari tipe sepeda..." value="{{ request('cari') }}">
        <select name="status">
            <option value="">Semua Status</option>
            <option value="Tersedia" {{ request('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
            <option value="Maintenance" {{ request('status') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
        </select>
        <select name="kategori">
            <option value="">Semua Kategori</option>
            @foreach($daftarKategori as $kategori)
                <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-filter">Filter</button>
        <a href="/admin/sepeda" class="btn-reset">Reset</a>
    </form>

    <div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th style="width: 46px;">ID</th>
                <th style="width: 54px;">Foto</th>
                <th>Tipe Sepeda</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th class="col-num">Harga/Jam</th>
                <th class="col-num">Harga/Hari</th>
                <th class="col-num">Denda/Jam</th>
                <th>Status</th>
                <th style="width: 140px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($daftarSepeda as $sepeda)
            <tr>
                <td style="font-weight: bold; color: #B5B9C9;">#{{ $loop->iteration }}</td>
                <td>
                    @if($sepeda->gambar)
                        <img src="{{ asset('storage/' . $sepeda->gambar) }}" alt="{{ $sepeda->tipe }}" class="foto-thumb">
                    @else
                        <div class="foto-thumb-empty">🚲</div>
                    @endif
                </td>
                <td style="font-weight: 600;">{{ $sepeda->tipe }}</td>
                <td><span class="kategori-chip">{{ $sepeda->kategori }}</span></td>
                <td>
                    <span class="stok-badge {{ $sepeda->stok == 0 ? 'stok-habis' : ($sepeda->stok <= 2 ? 'stok-menipis' : 'stok-aman') }}">
                        {{ $sepeda->stok }} unit
                    </span>
                </td>
                <td class="col-num">Rp {{ number_format($sepeda->harga_per_jam, 0, ',', '.') }}</td>
                <td class="col-num">Rp {{ number_format($sepeda->harga_per_hari, 0, ',', '.') }}</td>
                <td class="col-num">Rp {{ number_format($sepeda->denda_per_jam ?? 0, 0, ',', '.') }}</td>
                <td>
                    <span class="pill-dot {{ $sepeda->status == 'Tersedia' ? 'status-tersedia' : 'status-maintenance' }}">
                        {{ $sepeda->status }}
                    </span>
                </td>
                <td style="white-space: nowrap;">
                    <button class="btn-edit" onclick="editData('{{ $sepeda->id_sepeda }}', '{{ $sepeda->tipe }}', '{{ $sepeda->kategori }}', '{{ $sepeda->stok }}', '{{ $sepeda->harga_per_jam }}', '{{ $sepeda->harga_per_hari }}', '{{ $sepeda->denda_per_jam ?? 5000 }}', '{{ $sepeda->denda_per_hari ?? 0 }}', '{{ $sepeda->status }}', {{ $sepeda->gambar ? "'".asset('storage/' . $sepeda->gambar)."'" : 'null' }})">Edit</button>

                    <form action="/admin/sepeda/{{ $sepeda->id_sepeda }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data asset sepeda ini dari sistem?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="10" style="text-align:center; color:#94a3b8; padding: 30px;">Tidak ada data sepeda yang cocok dengan filter.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>

<div class="modal-overlay" id="formModal">
    <div class="modal-box">
        <h3 id="modalTitle">Tambah Data Sepeda</h3>
        <form action="/admin/sepeda" method="POST" id="formSepeda" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="form-group">
                <label>Foto Sepeda:</label>
                <input type="file" name="gambar" id="gambar" accept="image/*">
                <small style="color:#94a3b8; font-weight: 400;">Opsional. Format JPG/PNG, maks 2MB. Kosongkan saat edit jika tidak ingin ganti foto.</small>
                <div id="previewWrapper" style="margin-top:10px; display:none;">
                    <img id="previewGambar" src="" alt="Preview" style="width:90px;height:90px;object-fit:cover;border-radius:12px;border:1px solid #eef2f7;">
                </div>
            </div>
            <div class="form-group">
                <label>Tipe Sepeda:</label>
                <input type="text" name="tipe" id="tipe" required placeholder="Contoh: Sepeda Lipat Exotic">
            </div>
            <div class="form-group">
                <label>Kategori:</label>
                <select name="kategori" id="kategori" required>
                    <option value="MTB">MTB</option>
                    <option value="Sepeda Listrik">Sepeda Listrik</option>
                    <option value="Roadbike">Roadbike</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div class="form-group">
                <label>Stok (jumlah unit):</label>
                <input type="number" name="stok" id="stok" min="0" required placeholder="0">
            </div>
            <div class="form-group">
                <label>Harga per Jam (Rp):</label>
                <input type="number" name="harga_per_jam" id="harga_per_jam" step="1000" required placeholder="0">
            </div>
            <div class="form-group">
                <label>Harga per Hari (Rp):</label>
                <input type="number" name="harga_per_hari" id="harga_per_hari" step="1000" required placeholder="0">
            </div>
            <div class="form-group">
                <label>Denda per Jam Telat (Rp):</label>
                <input type="number" name="denda_per_jam" id="denda_per_jam" step="1000" required placeholder="5000" value="5000">
            </div>
            <div class="form-group">
                <label>Denda per Hari Telat (Rp):</label>
                <input type="number" name="denda_per_hari" id="denda_per_hari" step="1000" required placeholder="0" value="0">
                <small style="color:#94a3b8; font-weight: 400;">Isi 0 jika sewa per hari cukup dihitung denda per jam telat.</small>
            </div>
            <div class="form-group">
                <label>Status:</label>
                <select name="status" id="status" required>
                    <option value="Tersedia">Tersedia</option>
                    <option value="Maintenance">Maintenance</option>
                </select>
            </div>
            <button type="submit" class="btn-add" id="btnSubmit">Simpan Data Sepeda</button>
            <button type="button" class="btn-close" onclick="closeModal()">Batal / Tutup</button>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('formModal');

    function openModal(method) {
        modal.style.display = 'flex';
        if (method === 'POST') {
            document.getElementById('modalTitle').innerText = 'Tambah Data Sepeda';
            document.getElementById('formSepeda').action = '/admin/sepeda';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('formSepeda').reset();
            document.getElementById('previewWrapper').style.display = 'none';
            document.getElementById('btnSubmit').innerText = 'Simpan Data Sepeda';
            document.getElementById('btnSubmit').style.background = 'linear-gradient(135deg, #06B6D4 0%, #635BFF 55%, #A855F7 100%)';
            document.getElementById('btnSubmit').style.color = 'white';
        }
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    function editData(id, tipe, kategori, stok, hargaJam, hargaHari, dendaJam, dendaHari, status, gambarUrl) {
        openModal('PUT');
        document.getElementById('modalTitle').innerText = 'Edit Data Sepeda';
        document.getElementById('formSepeda').action = '/admin/sepeda/' + id;
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('tipe').value = tipe;
        document.getElementById('kategori').value = kategori;
        document.getElementById('stok').value = stok;
        document.getElementById('gambar').value = '';

        if (gambarUrl) {
            document.getElementById('previewGambar').src = gambarUrl;
            document.getElementById('previewWrapper').style.display = 'block';
        } else {
            document.getElementById('previewWrapper').style.display = 'none';
        }

        document.getElementById('harga_per_jam').value = Math.round(hargaJam);
        document.getElementById('harga_per_hari').value = Math.round(hargaHari);
        document.getElementById('denda_per_jam').value = Math.round(dendaJam);
        document.getElementById('denda_per_hari').value = Math.round(dendaHari);
        document.getElementById('status').value = status;

        document.getElementById('btnSubmit').innerText = 'Simpan Perubahan';
        document.getElementById('btnSubmit').style.background = 'linear-gradient(135deg, #f59e0b, #f97316)';
        document.getElementById('btnSubmit').style.color = 'white';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    }
</script>

</body>
</html>
