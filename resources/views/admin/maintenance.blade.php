<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Maintenance - Rental Sepeda</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background: linear-gradient(135deg, #f0fdf4 0%, #e0f2fe 100%); color: #1e293b; }
        .container { max-width: 1100px; margin: auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0px 10px 30px rgba(15, 23, 42, 0.06); border: 1px solid #e2e8f0; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; font-size: 13px; color: #64748b; }
        .topbar .role-badge { background: #d1fae5; color: #047857; font-weight: 700; padding: 2px 8px; border-radius: 4px; font-size: 11px; text-transform: uppercase; margin-left: 6px; }
        .btn-logout { background: transparent; color: #ef4444; border: 1px solid #fecaca; padding: 6px 14px; border-radius: 6px; font-size: 13px; cursor: pointer; }
        .header-wrapper { display: flex; flex-direction: column; align-items: center; border-bottom: 3px solid #f1f5f9; padding-bottom: 20px; margin-bottom: 25px; }
        h2 { margin: 0 0 15px; font-size: 24px; color: #0f172a; text-align: center; }
        .alert { padding: 12px; background-color: #f0fdf4; color: #15803d; border-radius: 6px; margin-bottom: 20px; font-size: 14px; border-left: 5px solid #10b981; }
        .alert-gagal { padding: 12px; background-color: #fef2f2; color: #b91c1c; border-radius: 6px; margin-bottom: 20px; font-size: 14px; border-left: 5px solid #ef4444; }

        button { padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .btn-trigger { background-color: #10b981; color: white; font-size: 14px; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.25); }
        .btn-trigger:hover { background-color: #059669; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #e2e8f0; text-align: left; padding: 12px; font-size: 13px; }
        th { background-color: #f8fafc; color: #64748b; font-weight: 600; }
        td { background-color: #fff; color: #1e293b; }

        .status-badge { font-weight: bold; padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .status-proses { color: #b45309; background-color: #fef3c7; border: 1px solid #fde68a; }
        .status-selesai { color: #047857; background-color: #d1fae5; border: 1px solid #a7f3d0; }
        .btn-aksi { padding: 6px 12px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 12px; background: #0ea5e9; color: #fff; }
        .empty-state { text-align: center; color: #94a3b8; padding: 30px 0; font-size: 14px; }

        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.4); display: none; justify-content: center; align-items: center; z-index: 9999; }
        .modal-box { background: #fff; padding: 26px; border-radius: 10px; width: 100%; max-width: 460px; border: 1px solid #e2e8f0; }
        .form-group { margin-bottom: 14px; }
        label { display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #475569; }
        input, select, textarea { width: 100%; padding: 9px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box; }
        small.hint { display: block; margin-top: 4px; font-size: 12px; color: #94a3b8; }
        .btn-simpan { background: #10b981; color: #fff; width: 100%; padding: 10px; border: none; border-radius: 6px; font-weight: bold; margin-top: 4px; }
        .btn-batal { background: #f1f5f9; color: #475569; width: 100%; padding: 9px; border: none; border-radius: 6px; margin-top: 8px; }
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
                    <th style="width: 120px;">Aksi</th>
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
    @endif
</div>

<div class="modal-overlay" id="modalTambah">
    <div class="modal-box">
        <h3 style="margin-top:0;">Catat Kerusakan / Servis Baru</h3>
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
