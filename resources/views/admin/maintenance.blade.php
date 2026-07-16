<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Maintenance - Rental Sepeda</title>
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
        .container { max-width: 1100px; margin: auto; background: #fff; padding: 32px; border-radius: 24px; box-shadow: 0px 14px 40px rgba(15, 23, 42, 0.07); border: 1px solid #eef2f7; }

        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; font-size: 13px; color: #64748b; }
        .brand { display: flex; align-items: center; gap: 8px; font-weight: 800; color: #0f172a; font-size: 15px; }
        .brand .dot { width: 10px; height: 10px; border-radius: 50%; background: linear-gradient(135deg, #6366f1, #8b5cf6); }
        .topbar .role-badge { background: linear-gradient(135deg, #ede9fe, #ddd6fe); color: #6d28d9; font-weight: 700; padding: 3px 10px; border-radius: 999px; font-size: 11px; text-transform: uppercase; margin-left: 6px; }
        .btn-logout { background: #fff; color: #ef4444; border: 1px solid #fecaca; padding: 8px 16px; border-radius: 999px; font-size: 13px; cursor: pointer; font-weight: 700; transition: all 0.15s; }
        .btn-logout:hover { background: #ef4444; color: #fff; border-color: #ef4444; }

        .header-wrapper { display: flex; flex-direction: column; align-items: center; border-bottom: 2px solid #f1f5f9; padding-bottom: 22px; margin-bottom: 24px; }
        h2 { margin: 0 0 16px; font-size: 22px; color: #0f172a; text-align: center; }
        .alert { padding: 13px 16px; background-color: #ecfdf5; color: #047857; border-radius: 12px; margin-bottom: 20px; font-size: 14px; border: 1px solid #a7f3d0; font-weight: 600; }
        .alert-gagal { padding: 13px 16px; background-color: #fef2f2; color: #b91c1c; border-radius: 12px; margin-bottom: 20px; font-size: 14px; border: 1px solid #fecaca; font-weight: 600; }

        button { border: none; border-radius: 999px; cursor: pointer; font-weight: 700; transition: all 0.2s; }
        .btn-trigger {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); color: white; font-size: 14px; padding: 12px 24px;
            box-shadow: 0 10px 22px rgba(99, 102, 241, 0.30);
        }
        .btn-trigger:hover { transform: translateY(-1px); box-shadow: 0 14px 26px rgba(99, 102, 241, 0.38); }

        .table-wrapper { overflow-x: auto; border-radius: 16px; border: 1px solid #eef2f7; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 13px 14px; font-size: 13px; border-bottom: 1px solid #f1f5f9; }
        th { background-color: #f8fafc; color: #64748b; font-weight: 700; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.4px; }
        td { background-color: #fff; color: #1e293b; }
        tbody tr:last-child td { border-bottom: none; }

        .status-badge { font-weight: 700; padding: 4px 12px; border-radius: 999px; font-size: 12px; }
        .status-proses { color: #b45309; background-color: #fef3c7; }
        .status-selesai { color: #047857; background-color: #d1fae5; }
        .btn-aksi { padding: 8px 14px; font-size: 12.5px; background: #0ea5e9; color: #fff; }
        .empty-state { text-align: center; color: #94a3b8; padding: 40px 0; font-size: 14px; }

        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.45); display: none; justify-content: center; align-items: center; z-index: 9999; backdrop-filter: blur(4px); }
        .modal-box { background: #fff; padding: 26px 28px; border-radius: 20px; width: 100%; max-width: 460px; max-height: 88vh; overflow-y: auto; border: 1px solid #eef2f7; box-shadow: 0 20px 50px rgba(15,23,42,0.18); }
        .modal-box h3 { margin-top: 0; font-size: 18px; color: #0f172a; border-bottom: 2px solid #f1f5f9; padding-bottom: 14px; }
        .form-group { margin-bottom: 14px; }
        label { display: block; margin-bottom: 6px; font-weight: 700; font-size: 13px; color: #475569; }
        input, select, textarea { width: 100%; padding: 10px 12px; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 13.5px; box-sizing: border-box; font-family: inherit; background: #f8fafc; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #6366f1; box-shadow: 0 0 0 4px rgba(99,102,241,0.12); background: #fff; }
        small.hint { display: block; margin-top: 5px; font-size: 12px; color: #94a3b8; }
        .btn-simpan { background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; width: 100%; padding: 12px; border: none; border-radius: 999px; font-weight: 700; margin-top: 6px; box-shadow: 0 10px 22px rgba(99,102,241,0.30); }
        .btn-simpan:hover { transform: translateY(-1px); }
        .btn-batal { background: #f1f5f9; color: #475569; width: 100%; padding: 11px; border: none; border-radius: 999px; margin-top: 8px; font-weight: 700; }
        .btn-batal:hover { background: #e2e8f0; color: #0f172a; }
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

    <div class="header-wrapper">
        <h2>🔧 Log & Riwayat Maintenance Sepeda</h2>
        <button class="btn-trigger" onclick="document.getElementById('modalTambah').style.display='flex'">＋ Catat Kerusakan Baru</button>
    </div>

    @if(session('sukses'))
        <div class="alert">✔️ {{ session('sukses') }}</div>
    @endif
    @if(session('gagal'))
        <div class="alert-gagal">⚠️ {{ session('gagal') }}</div>
    @endif

    @if($logMaintenance->isEmpty())
        <div class="empty-state">Belum ada catatan maintenance.</div>
    @else
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Sepeda</th>
                    <th>Jumlah Unit</th>
                    <th>Kerusakan</th>
                    <th>Tgl Servis</th>
                    <th>Biaya</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th style="width: 130px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logMaintenance as $log)
                <tr>
                    <td style="font-weight:600;">{{ $log->tipe }}</td>
                    <td style="text-align:center;">{{ $log->jumlah }} unit</td>
                    <td>{{ $log->kerusakan }}</td>
                    <td>{{ \Carbon\Carbon::parse($log->tanggal_servis)->format('d M Y') }}</td>
                    <td>Rp {{ number_format($log->biaya, 0, ',', '.') }}</td>
                    <td>{{ $log->catatan ?: '-' }}</td>
                    <td>
                        <span class="status-badge {{ $log->status == 'Proses' ? 'status-proses' : 'status-selesai' }}">{{ $log->status }}</span>
                    </td>
                    <td>
                        @if($log->status == 'Proses')
                        <form action="/admin/maintenance/{{ $log->id }}/selesai" method="POST" onsubmit="return confirm('Tandai servis selesai? ' + {{ $log->jumlah }} + ' unit akan dikembalikan ke stok tersedia.')">
                            @csrf
                            <button type="submit" class="btn-aksi">Selesai Servis</button>
                        </form>
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

<div class="modal-overlay" id="modalTambah">
    <div class="modal-box">
        <h3>Catat Kerusakan / Servis Baru</h3>
        <form action="/admin/maintenance" method="POST">
            @csrf
            <div class="form-group">
                <label>Sepeda:</label>
                <select name="id_sepeda" id="pilihSepeda" required onchange="tampilkanStok()">
                    <option value="" disabled selected>Pilih tipe sepeda</option>
                    @foreach($daftarSepeda as $s)
                        <option value="{{ $s->id_sepeda }}" data-stok="{{ $s->stok }}">{{ $s->tipe }} ({{ $s->kategori }})</option>
                    @endforeach
                </select>
                <small class="hint" id="infoStok">Pilih sepeda untuk melihat sisa stok tersedia.</small>
            </div>
            <div class="form-group">
                <label>Jumlah Unit yang Di-maintenance:</label>
                <input type="number" name="jumlah" id="jumlahUnit" min="1" value="1" required>
                <small class="hint">Cuma unit sejumlah ini yang akan dikurangi dari stok tersedia — sisanya tetap bisa disewa.</small>
            </div>
            <div class="form-group">
                <label>Bagian yang Rusak / Dikerjakan:</label>
                <input type="text" name="kerusakan" required placeholder="Contoh: Rantai putus, rem blong">
            </div>
            <div class="form-group">
                <label>Tanggal Servis:</label>
                <input type="date" name="tanggal_servis" required>
            </div>
            <div class="form-group">
                <label>Biaya Perbaikan (Rp):</label>
                <input type="number" name="biaya" min="0" placeholder="0">
            </div>
            <div class="form-group">
                <label>Catatan Tambahan:</label>
                <textarea name="catatan" rows="2" placeholder="Opsional"></textarea>
            </div>
            <button type="submit" class="btn-simpan">Simpan & Kurangi Stok</button>
            <button type="button" class="btn-batal" onclick="document.getElementById('modalTambah').style.display='none'">Batal</button>
        </form>
    </div>
</div>

<script>
    function tampilkanStok() {
        const select = document.getElementById('pilihSepeda');
        const opt = select.options[select.selectedIndex];
        const stok = opt.dataset.stok ?? 0;
        document.getElementById('infoStok').innerText = 'Stok tersedia saat ini: ' + stok + ' unit.';
        document.getElementById('jumlahUnit').max = stok;
    }

    window.onclick = function(event) {
        const modal = document.getElementById('modalTambah');
        if (event.target == modal) modal.style.display = 'none';
    }
</script>

</body>
</html>
