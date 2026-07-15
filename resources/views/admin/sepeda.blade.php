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
            margin: 40px;
            background: linear-gradient(135deg, #f0fdf4 0%, #e0f2fe 100%);
            color: #1e293b;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 10px 30px rgba(15, 23, 42, 0.06);
            border: 1px solid #e2e8f0;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            font-size: 13px;
            color: #64748b;
        }
        .topbar .user-info b { color: #0f172a; }
        .topbar .role-badge {
            background: #d1fae5; color: #047857; font-weight: 700;
            padding: 2px 8px; border-radius: 4px; font-size: 11px; text-transform: uppercase;
            margin-left: 6px;
        }
        .btn-logout {
            background: transparent; color: #ef4444; border: 1px solid #fecaca;
            padding: 6px 14px; border-radius: 6px; font-size: 13px; cursor: pointer;
        }
        .btn-logout:hover { background: #fef2f2; }

        .header-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            border-bottom: 3px solid #f1f5f9;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }
        .header-title { width: 100%; text-align: center; }
        .header-title h2 { margin: 0 0 15px 0; font-size: 26px; color: #0f172a; letter-spacing: 0.5px; text-align: center; }

        .btn-center-wrapper { display: flex; justify-content: center; width: 100%; }

        .filter-bar {
            display: flex; gap: 10px; flex-wrap: wrap; align-items: center;
            margin-bottom: 18px; padding: 14px; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;
        }
        .filter-bar select, .filter-bar input[type="text"] {
            padding: 8px 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; background: #fff;
        }
        .filter-bar .btn-filter { background: #0f172a; color: #fff; padding: 8px 16px; font-size: 13px; border-radius: 6px; }
        .filter-bar .btn-reset { background: #f1f5f9; color: #475569; padding: 8px 16px; font-size: 13px; border-radius: 6px; text-decoration: none; }

        table { width: 100%; border-collapse: collapse; margin-top: 15px; background: transparent; }
        th, td { border: 1px solid #e2e8f0; text-align: left; padding: 14px; font-size: 14px; }
        th { background-color: #f8fafc; color: #64748b; font-weight: 600; }
        td { background-color: #ffffff; color: #1e293b; }
        tr:hover td { background-color: #f8fafc; }

        button { padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; transition: all 0.2s; }
        .btn-trigger { background-color: #10b981; color: white; font-size: 14px; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.25); }
        .btn-trigger:hover { background-color: #059669; }
        .btn-add { background-color: #10b981; color: white; width: 100%; padding: 12px; font-size: 15px; margin-top: 10px; }
        .btn-add:hover { background-color: #059669; }

        .btn-edit { background-color: #fffbeb; color: #b45309; margin-right: 5px; border: 1px solid #fde68a; }
        .btn-edit:hover { background-color: #fef3c7; }

        .btn-delete { background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .btn-delete:hover { background-color: #fee2e2; }

        .btn-close { background-color: #f1f5f9; color: #475569; width: 100%; padding: 10px; margin-top: 8px; font-size: 14px; }
        .btn-close:hover { background-color: #e2e8f0; color: #0f172a; }

        .status-badge { font-weight: bold; padding: 4px 8px; border-radius: 4px; font-size: 13px; }
        .status-tersedia { color: #047857; background-color: #d1fae5; border: 1px solid #a7f3d0; }
        .status-maintenance { color: #b45309; background-color: #fef3c7; border: 1px solid #fde68a; }

        .stok-badge { font-weight: 700; }
        .stok-habis { color: #dc2626; }
        .stok-menipis { color: #b45309; }
        .stok-aman { color: #047857; }

        .kategori-chip {
            background: #eef2ff; color: #4338ca; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;
        }

        .alert { padding: 12px; background-color: #f0fdf4; color: #15803d; border-radius: 6px; margin-bottom: 20px; font-size: 14px; border-left: 5px solid #10b981; }

        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.4); display: none; justify-content: center; align-items: center; z-index: 9999; backdrop-filter: blur(3px); }
        .modal-box { background: #ffffff; padding: 24px 30px; border-radius: 10px; width: 100%; max-width: 460px; max-height: 85vh; overflow-y: auto; box-shadow: 0 5px 20px rgba(15, 23, 42, 0.15); border: 1px solid #e2e8f0; animation: fadeIn 0.3s ease; }
        .modal-box h3 { position: sticky; top: -24px; background: #fff; margin: -24px -30px 10px; padding: 24px 30px 10px; z-index: 2; }
        .form-group { margin-bottom: 12px; }
        label { display: block; margin-bottom: 4px; font-weight: 600; font-size: 13px; color: #475569; }
        input, select { width: 100%; padding: 8px 10px; box-sizing: border-box; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; background-color: #f8fafc; color: #0f172a; }
        input:focus, select:focus { outline: none; border-color: #10b981; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15); background: #fff; }
        select option { background-color: #ffffff; color: #0f172a; }

        @keyframes fadeIn {
            from { transform: translateY(-20px); opacity: 0; }
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
            <h2>DASHBOARD ADMIN — INVENTARIS RENTAL SEPEDA</h2>
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
                <th style="width: 160px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($daftarSepeda as $sepeda)
            <tr>
                <td style="font-weight: bold; color: #94a3b8;">#{{ $loop->iteration }}</td>
                <td>
                    @if($sepeda->gambar)
                        <img src="{{ asset('storage/' . $sepeda->gambar) }}" alt="{{ $sepeda->tipe }}" style="width:50px;height:50px;object-fit:cover;border-radius:6px;border:1px solid #e2e8f0;">
                    @else
                        <div style="width:50px;height:50px;border-radius:6px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;font-size:18px;">🚲</div>
                    @endif
                </td>
                <td style="font-weight: 500; color: #0f172a;">{{ $sepeda->tipe }}</td>
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
                <td>
                    <button class="btn-edit" onclick="editData('{{ $sepeda->id_sepeda }}', '{{ $sepeda->tipe }}', '{{ $sepeda->kategori }}', '{{ $sepeda->stok }}', '{{ $sepeda->harga_per_jam }}', '{{ $sepeda->harga_per_hari }}', '{{ $sepeda->denda_per_jam ?? 5000 }}', '{{ $sepeda->denda_per_hari ?? 0 }}', '{{ $sepeda->status }}', {{ $sepeda->gambar ? "'".asset('storage/' . $sepeda->gambar)."'" : 'null' }})">Edit</button>

                    <form action="/admin/sepeda/{{ $sepeda->id_sepeda }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data asset sepeda ini dari sistem?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="11" style="text-align:center; color:#94a3b8;">Tidak ada data sepeda yang cocok dengan filter.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="modal-overlay" id="formModal">
    <div class="modal-box">
        <h3 id="modalTitle" style="margin-top: 0; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px; color: #0f172a;">Tambah Data Sepeda</h3>
        <form action="/admin/sepeda" method="POST" id="formSepeda" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="form-group">
                <label>Foto Sepeda:</label>
                <input type="file" name="gambar" id="gambar" accept="image/*">
                <small style="color:#94a3b8; font-weight: 400;">Opsional. Format JPG/PNG, maks 2MB. Kosongkan saat edit jika tidak ingin ganti foto.</small>
                <div id="previewWrapper" style="margin-top:10px; display:none;">
                    <img id="previewGambar" src="" alt="Preview" style="width:90px;height:90px;object-fit:cover;border-radius:8px;border:1px solid #e2e8f0;">
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
            document.getElementById('btnSubmit').style.backgroundColor = '#10b981';
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
        document.getElementById('btnSubmit').style.backgroundColor = '#f59e0b';
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
