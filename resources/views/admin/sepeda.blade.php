<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Rental Sepeda</title>
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

        .container {
            max-width: 1180px;
            margin: auto;
            background: #ffffff;
            padding: 32px;
            border-radius: 24px;
            box-shadow: 0px 14px 40px rgba(15, 23, 42, 0.07);
            border: 1px solid #eef2f7;
        }

        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; font-size: 13px; color: #64748b; }
        .brand { display: flex; align-items: center; gap: 8px; font-weight: 800; color: #0f172a; font-size: 15px; }
        .brand .dot { width: 10px; height: 10px; border-radius: 50%; background: linear-gradient(135deg, #6366f1, #8b5cf6); }
        .topbar .user-info b { color: #0f172a; }
        .topbar .role-badge { background: linear-gradient(135deg, #ede9fe, #ddd6fe); color: #6d28d9; font-weight: 700; padding: 3px 10px; border-radius: 999px; font-size: 11px; text-transform: uppercase; margin-left: 6px; }
        .btn-logout { background: #fff; color: #ef4444; border: 1px solid #fecaca; padding: 8px 16px; border-radius: 999px; font-size: 13px; cursor: pointer; font-weight: 700; transition: all 0.15s; }
        .btn-logout:hover { background: #ef4444; color: #fff; border-color: #ef4444; }

        .header-wrapper { display: flex; flex-direction: column; align-items: center; border-bottom: 2px solid #f1f5f9; padding-bottom: 22px; margin-bottom: 24px; }
        .header-title { width: 100%; text-align: center; }
        .header-title h2 { margin: 0 0 16px 0; font-size: 22px; color: #0f172a; letter-spacing: 0.2px; text-align: center; }
        .btn-center-wrapper { display: flex; justify-content: center; width: 100%; }

        button { border: none; border-radius: 999px; cursor: pointer; font-weight: 700; transition: all 0.2s; }
        .btn-trigger {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); color: white; font-size: 14px;
            display: flex; align-items: center; gap: 8px; padding: 12px 24px;
            box-shadow: 0 10px 22px rgba(99, 102, 241, 0.30);
        }
        .btn-trigger:hover { transform: translateY(-1px); box-shadow: 0 14px 26px rgba(99, 102, 241, 0.38); }

        .alert { padding: 13px 16px; background-color: #ecfdf5; color: #047857; border-radius: 12px; margin-bottom: 20px; font-size: 14px; border: 1px solid #a7f3d0; font-weight: 600; }

        .filter-bar {
            display: flex; gap: 10px; flex-wrap: wrap; align-items: center;
            margin-bottom: 20px; padding: 12px; background: #f8fafc; border-radius: 16px; border: 1px solid #eef2f7;
        }
        .filter-bar select, .filter-bar input[type="text"] {
            padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 999px; font-size: 13px; background: #fff;
        }
        .filter-bar input[type="text"] { flex: 1; min-width: 180px; }
        .filter-bar .btn-filter { background: linear-gradient(135deg, #0f172a, #334155); color: #fff; padding: 10px 22px; font-size: 13px; }
        .filter-bar .btn-filter:hover { opacity: 0.9; }
        .filter-bar .btn-reset { background: #fff; color: #475569; border: 1px solid #e2e8f0; padding: 10px 22px; font-size: 13px; text-decoration: none; font-weight: 700; }

        .table-wrapper { overflow-x: auto; border-radius: 16px; border: 1px solid #eef2f7; }
        table { width: 100%; border-collapse: collapse; background: transparent; }
        th, td { text-align: left; padding: 14px; font-size: 13.5px; border-bottom: 1px solid #f1f5f9; }
        th { background-color: #f8fafc; color: #64748b; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.4px; }
        td { background-color: #ffffff; color: #1e293b; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background-color: #fafbff; }

        .btn-edit { background-color: #fffbeb; color: #b45309; margin-right: 6px; border: 1px solid #fde68a; padding: 8px 16px; font-size: 13px; }
        .btn-edit:hover { background-color: #fef3c7; }
        .btn-delete { background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca; padding: 8px 16px; font-size: 13px; }
        .btn-delete:hover { background-color: #fee2e2; }

        .btn-add {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); color: white;
            width: 100%; padding: 13px; font-size: 15px; margin-top: 10px;
            box-shadow: 0 10px 22px rgba(99, 102, 241, 0.30);
        }
        .btn-add:hover { transform: translateY(-1px); }
        .btn-close { background-color: #f1f5f9; color: #475569; width: 100%; padding: 11px; margin-top: 8px; font-size: 14px; }
        .btn-close:hover { background-color: #e2e8f0; color: #0f172a; }

        .status-badge { font-weight: 700; padding: 4px 12px; border-radius: 999px; font-size: 12px; }
        .status-tersedia { color: #047857; background-color: #d1fae5; }
        .status-maintenance { color: #b45309; background-color: #fef3c7; }

        .stok-badge { font-weight: 700; }
        .stok-habis { color: #dc2626; }
        .stok-menipis { color: #b45309; }
        .stok-aman { color: #047857; }

        .kategori-chip { background: #eef2ff; color: #4338ca; padding: 3px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; }

        .foto-thumb { width: 46px; height: 46px; object-fit: cover; border-radius: 10px; border: 1px solid #eef2f7; }
        .foto-thumb-empty {
            width: 46px; height: 46px; border-radius: 10px;
            background: linear-gradient(135deg, #eef2ff, #f5f3ff);
            display: flex; align-items: center; justify-content: center; font-size: 18px;
        }

        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.45); display: none; justify-content: center; align-items: center; z-index: 9999; backdrop-filter: blur(4px); }
        .modal-box { background: #ffffff; padding: 26px 30px; border-radius: 20px; width: 100%; max-width: 460px; max-height: 85vh; overflow-y: auto; box-shadow: 0 20px 50px rgba(15, 23, 42, 0.18); border: 1px solid #eef2f7; animation: fadeIn 0.25s ease; }
        .modal-box h3 { position: sticky; top: -26px; background: #fff; margin: -26px -30px 14px; padding: 26px 30px 14px; z-index: 2; border-bottom: 2px solid #f1f5f9; font-size: 18px; color: #0f172a; }
        .form-group { margin-bottom: 14px; }
        label { display: block; margin-bottom: 5px; font-weight: 700; font-size: 13px; color: #475569; }
        input, select { width: 100%; padding: 10px 12px; box-sizing: border-box; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 13.5px; background-color: #f8fafc; color: #0f172a; }
        input:focus, select:focus { outline: none; border-color: #6366f1; box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12); background: #fff; }
        select option { background-color: #ffffff; color: #0f172a; }

        @keyframes fadeIn {
            from { transform: translateY(-16px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="topbar">
        <div class="user-info">
            Masuk sebagai <b>{{ Auth::user()->name }}</b>
            <span class="role-badge">{{ Auth::user()->role }}</span>
        </div>
        <form action="/logout" method="POST" onsubmit="return confirm('Keluar dari sistem?')">
            @csrf
            <button type="submit" class="btn-logout">Keluar</button>
        </form>
    </div>

    @include('partials.admin-nav')

    <div class="header-wrapper">
        <div class="header-title">
            <h2>🚲 Dashboard Admin — Inventaris Rental Sepeda</h2>
            <div class="btn-center-wrapper">
                <button class="btn-trigger" onclick="openModal('POST')">＋ Tambah Armada Sepeda</button>
            </div>
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
                <th style="width: 60px;">ID</th>
                <th style="width: 70px;">Foto</th>
                <th>Tipe Sepeda</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Harga / Jam</th>
                <th>Harga / Hari</th>
                <th>Denda / Jam</th>
                <th>Denda / Hari</th>
                <th>Status</th>
                <th style="width: 170px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($daftarSepeda as $sepeda)
            <tr>
                <td style="font-weight: bold; color: #94a3b8;">#{{ $loop->iteration }}</td>
                <td>
                    @if($sepeda->gambar)
                        <img src="{{ asset('storage/' . $sepeda->gambar) }}" alt="{{ $sepeda->tipe }}" class="foto-thumb">
                    @else
                        <div class="foto-thumb-empty">🚲</div>
                    @endif
                </td>
                <td style="font-weight: 600; color: #0f172a;">{{ $sepeda->tipe }}</td>
                <td><span class="kategori-chip">{{ $sepeda->kategori }}</span></td>
                <td>
                    <span class="stok-badge {{ $sepeda->stok == 0 ? 'stok-habis' : ($sepeda->stok <= 2 ? 'stok-menipis' : 'stok-aman') }}">
                        {{ $sepeda->stok }} unit
                    </span>
                </td>
                <td>Rp {{ number_format($sepeda->harga_per_jam, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($sepeda->harga_per_hari, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($sepeda->denda_per_jam ?? 0, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($sepeda->denda_per_hari ?? 0, 0, ',', '.') }}</td>
                <td>
                    <span class="status-badge {{ $sepeda->status == 'Tersedia' ? 'status-tersedia' : 'status-maintenance' }}">
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
            <tr><td colspan="11" style="text-align:center; color:#94a3b8; padding: 30px;">Tidak ada data sepeda yang cocok dengan filter.</td></tr>
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
            document.getElementById('btnSubmit').style.background = 'linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%)';
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
