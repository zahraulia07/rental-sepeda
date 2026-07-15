<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Rental Sepeda</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 40px;
            background: linear-gradient(135deg, #f0fdf4 0%, #e0f2fe 100%);
            color: #1e293b;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 10px 30px rgba(15, 23, 42, 0.06);
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
        }

        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; font-size: 13px; color: #64748b; }
        .topbar .user-info b { color: #0f172a; }
        .topbar .role-badge { background: #dbeafe; color: #1d4ed8; font-weight: 700; padding: 2px 8px; border-radius: 4px; font-size: 11px; text-transform: uppercase; margin-left: 6px; }
        .btn-logout { background: transparent; color: #ef4444; border: 1px solid #fecaca; padding: 6px 14px; border-radius: 6px; font-size: 13px; cursor: pointer; }
        .btn-logout:hover { background: #fef2f2; }

        .header-wrapper { border-bottom: 3px solid #f1f5f9; padding-bottom: 20px; margin-bottom: 25px; text-align: center; }
        .header-wrapper h2 { margin: 0; font-size: 24px; color: #0f172a; }
        .header-wrapper p { margin: 6px 0 0; font-size: 13px; color: #64748b; }

        .alert { padding: 12px; background-color: #f0fdf4; color: #15803d; border-radius: 6px; margin-bottom: 20px; font-size: 14px; border-left: 5px solid #10b981; }
        .alert-gagal { padding: 12px; background-color: #fef2f2; color: #b91c1c; border-radius: 6px; margin-bottom: 20px; font-size: 14px; border-left: 5px solid #ef4444; }
        .alert-blokir { padding: 14px; background-color: #fef2f2; color: #b91c1c; border-radius: 8px; margin-bottom: 20px; font-size: 14px; border: 1px solid #fecaca; text-align: center; font-weight: 600; }

        .filter-bar { display: flex; gap: 10px; margin-bottom: 22px; flex-wrap: wrap; }
        .filter-bar input, .filter-bar select { padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; }
        .filter-bar input { flex: 1; min-width: 180px; }
        .btn-filter { background: #10b981; color: #fff; border: none; padding: 9px 18px; border-radius: 6px; font-weight: bold; font-size: 13px; cursor: pointer; }
        .btn-filter:hover { background: #059669; }
        .btn-reset { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; padding: 9px 18px; border-radius: 6px; font-weight: bold; font-size: 13px; text-decoration: none; }

        .grid-sepeda { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 18px; align-items: stretch; }
        .card-sepeda { border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; background: #f8fafc; display: flex; flex-direction: column; }
        .card-sepeda.card-nonaktif { background: #f1f5f9; opacity: 0.75; }
        .card-sepeda .foto { width: 100%; height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 12px; background: #e2e8f0; }
        .card-sepeda .foto-kosong { width: 100%; height: 150px; border-radius: 8px; margin-bottom: 12px; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 40px; }
        .card-sepeda h3 { margin: 0 0 4px; font-size: 16px; color: #0f172a; }
        .card-sepeda .kategori { font-size: 11px; color: #4338ca; background: #eef2ff; display: inline-block; padding: 2px 8px; border-radius: 4px; font-weight: 600; margin-bottom: 6px; }
        .card-sepeda .status-chip { font-size: 11px; font-weight: 700; display: inline-block; padding: 2px 8px; border-radius: 4px; margin-bottom: 10px; margin-left: 6px; }
        .status-chip.chip-tersedia { color: #047857; background: #d1fae5; }
        .status-chip.chip-maintenance { color: #b45309; background: #fef3c7; }
        .status-chip.chip-disewa { color: #6d28d9; background: #ede9fe; }
        .status-chip.chip-habis { color: #b91c1c; background: #fef2f2; }
        .card-sepeda .harga { font-size: 13px; color: #475569; margin-bottom: 4px; }
        .card-sepeda .harga b { color: #0f172a; }
        .card-sepeda .stok { font-size: 12px; color: #64748b; margin-top: 4px; }

        .form-sewa { margin-top: auto; padding-top: 14px; display: flex; flex-direction: column; gap: 8px; }
        .form-sewa select, .form-sewa input { padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; }
        .form-sewa label.tnc-check { display: flex; align-items: flex-start; gap: 6px; font-size: 11px; color: #64748b; line-height: 1.4; }
        .form-sewa label.tnc-check input { width: auto; margin-top: 2px; }
        .form-sewa label.tnc-check a { color: #2563eb; }
        .btn-sewa { padding: 10px; border: none; border-radius: 8px; background: #10b981; color: #fff; font-weight: bold; font-size: 14px; cursor: pointer; }
        .btn-sewa:hover { background: #059669; }
        .btn-sewa-disabled { margin-top: auto; padding: 10px; border: none; border-radius: 8px; background: #cbd5e1; color: #64748b; font-weight: bold; font-size: 14px; cursor: not-allowed; text-align: center; }
        .empty-state { text-align: center; color: #94a3b8; padding: 30px 0; font-size: 14px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #e2e8f0; text-align: left; padding: 12px; font-size: 13px; }
        th { background-color: #f8fafc; color: #64748b; font-weight: 600; }
        td { background-color: #ffffff; color: #1e293b; }

        .status-badge { font-weight: bold; padding: 4px 8px; border-radius: 4px; font-size: 12px; white-space: nowrap; }
        .status-pending { color: #b45309; background-color: #fef3c7; border: 1px solid #fde68a; }
        .status-disetujui { color: #1d4ed8; background-color: #dbeafe; border: 1px solid #bfdbfe; }
        .status-sedang-disewa { color: #6d28d9; background-color: #ede9fe; border: 1px solid #ddd6fe; }
        .status-selesai { color: #047857; background-color: #d1fae5; border: 1px solid #a7f3d0; }
        .status-ditolak { color: #dc2626; background-color: #fef2f2; border: 1px solid #fecaca; }
        .denda-tag { color: #dc2626; font-weight: 700; }

        .btn-upload { padding: 6px 12px; border: 1px solid #bfdbfe; border-radius: 6px; background: #eff6ff; color: #1d4ed8; font-size: 12px; cursor: pointer; font-weight: bold; }
        .btn-nota { padding: 6px 12px; border: 1px solid #a7f3d0; border-radius: 6px; background: #ecfdf5; color: #047857; font-size: 12px; text-decoration: none; font-weight: bold; display: inline-block; }
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.4); display: none; justify-content: center; align-items: center; z-index: 9999; }
        .modal-box { background: #fff; padding: 24px; border-radius: 10px; width: 100%; max-width: 440px; max-height: 88vh; overflow-y: auto; border: 1px solid #e2e8f0; }
        .modal-box label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #475569; }
        .modal-box select, .modal-box input { width: 100%; padding: 9px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; margin-bottom: 14px; box-sizing: border-box; }
        .btn-kirim { background: #10b981; color: #fff; width: 100%; padding: 10px; border: none; border-radius: 6px; font-weight: bold; }
        .btn-batal { background: #f1f5f9; color: #475569; width: 100%; padding: 9px; border: none; border-radius: 6px; margin-top: 8px; }

        .status-aktif-card { border: 1px solid #ddd6fe; border-radius: 12px; padding: 20px; background: #f5f3ff; margin-bottom: 10px; }
        .status-aktif-card .judul { font-size: 12px; font-weight: 700; color: #6d28d9; text-transform: uppercase; margin-bottom: 6px; }
        .status-aktif-card .isi { font-size: 15px; color: #0f172a; font-weight: 600; margin-bottom: 4px; }
        .status-aktif-card .sub { font-size: 13px; color: #64748b; }
        .countdown { font-size: 20px; font-weight: 800; color: #6d28d9; margin-top: 8px; letter-spacing: 0.5px; }
        .countdown.telat { color: #dc2626; }

        .payment-info { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 16px; margin-bottom: 16px; }
        .payment-total { font-size: 14px; color: #475569; margin-bottom: 12px; }
        .payment-total b { color: #0f172a; font-size: 17px; }
        .payment-tabs { display: flex; gap: 10px; margin-bottom: 12px; flex-wrap: wrap; }
        .payment-method-box { flex: 1; min-width: 140px; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 12px; }
        .payment-label { font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 6px; }
        .payment-value { font-size: 12px; color: #334155; line-height: 1.5; }
        .payment-value .rekening { font-size: 15px; font-weight: 800; color: #10b981; letter-spacing: 0.5px; }
        .qris-box { background: #f1f5f9; border-radius: 6px; text-align: center; padding: 14px 6px; font-weight: 700; color: #475569; font-size: 12px; letter-spacing: 1px; }
        .qris-box small { display: block; font-weight: 400; color: #94a3b8; margin-top: 4px; letter-spacing: normal; }
        .payment-deadline { font-size: 12px; color: #64748b; border-top: 1px dashed #bbf7d0; padding-top: 10px; }
        .countdown-bayar { font-size: 16px; font-weight: 800; color: #b45309; margin-top: 4px; }
        .countdown-bayar.telat { color: #dc2626; }
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

    @include('partials.user-nav')

    <div class="header-wrapper">
        <h2>🚲 Sewa Sepeda</h2>
        <p>Pilih armada yang tersedia dan ajukan sewa sekarang</p>
    </div>

    @if(session('sukses'))
        <div class="alert">✔️ {{ session('sukses') }}</div>
    @endif
    @if(session('gagal'))
        <div class="alert-gagal">⚠️ {{ session('gagal') }}</div>
    @endif

    @if(Auth::user()->is_blocked)
        <div class="alert-blokir">
            🚫 Akun Anda diblokir dan tidak dapat mengajukan sewa baru.
            @if(Auth::user()->alasan_blokir) <br>Alasan: {{ Auth::user()->alasan_blokir }} @endif
        </div>
    @endif

    <form method="GET" action="/dashboard" class="filter-bar">
        <input type="text" name="cari" placeholder="Cari tipe sepeda..." value="{{ request('cari') }}">
        <select name="status">
            <option value="">Semua Status</option>
            <option value="Tersedia" {{ request('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
            <option value="Disewa" {{ request('status') == 'Disewa' ? 'selected' : '' }}>Disewa</option>
            <option value="Maintenance" {{ request('status') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
        </select>
        <select name="kategori">
            <option value="">Semua Kategori</option>
            @foreach($daftarKategori as $kategori)
                <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-filter">Filter</button>
        <a href="/dashboard" class="btn-reset">Reset</a>
    </form>

    @if($sepedaTersedia->isEmpty())
        <div class="empty-state">Tidak ada sepeda yang cocok dengan filter.</div>
    @else
        <div class="grid-sepeda">
            @foreach($sepedaTersedia as $sepeda)
            @php
                $bisaSewa = $sepeda->status === 'Tersedia' && $sepeda->stok > 0;
                $chipClass = match(true) {
                    $sepeda->status === 'Tersedia' && $sepeda->stok > 0 => 'chip-tersedia',
                    $sepeda->status === 'Tersedia' && $sepeda->stok <= 0 => 'chip-habis',
                    $sepeda->status === 'Maintenance' => 'chip-maintenance',
                    $sepeda->status === 'Disewa' => 'chip-disewa',
                    default => 'chip-habis',
                };
                $labelStatus = ($sepeda->status === 'Tersedia' && $sepeda->stok <= 0) ? 'Stok Habis' : $sepeda->status;
            @endphp
            <div class="card-sepeda {{ $bisaSewa ? '' : 'card-nonaktif' }}">
                @if($sepeda->gambar)
                    <img src="{{ asset('storage/' . $sepeda->gambar) }}" alt="{{ $sepeda->tipe }}" class="foto">
                @else
                    <div class="foto-kosong">🚲</div>
                @endif
                <h3>{{ $sepeda->tipe }}</h3>
                <div class="kategori">{{ $sepeda->kategori }}</div>
                <span class="status-chip {{ $chipClass }}">{{ $labelStatus }}</span>
                <div class="harga">Per Jam: <b>Rp {{ number_format($sepeda->harga_per_jam, 0, ',', '.') }}</b></div>
                <div class="harga">Per Hari: <b>Rp {{ number_format($sepeda->harga_per_hari, 0, ',', '.') }}</b></div>
                <div class="stok">Stok tersedia: {{ $sepeda->stok }} unit</div>

                @if(!$bisaSewa)
                    <div class="btn-sewa-disabled">
                        {{ $sepeda->status === 'Maintenance' ? 'Sedang Maintenance' : ($sepeda->status === 'Disewa' ? 'Sedang Disewa' : 'Stok Habis') }}
                    </div>
                @elseif(!Auth::user()->is_blocked)
                <div class="form-sewa">
                    <button type="button" class="btn-sewa" onclick="openSewa({{ $sepeda->id_sepeda }}, '{{ addslashes($sepeda->tipe) }}', {{ $sepeda->harga_per_jam }}, {{ $sepeda->harga_per_hari }})">Ajukan Sewa</button>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    @endif
</div>

@php
    $statusAktif = $riwayatSewa->whereIn('status', ['Pending', 'Disetujui', 'Sedang Disewa'])->first();
@endphp
@if($statusAktif)
<div class="container">
    <div class="header-wrapper" style="border-bottom: 3px solid #f1f5f9; margin-bottom: 20px;">
        <h2 style="font-size: 20px;">⏱️ Status Sewa Aktif Anda</h2>
    </div>
    <div class="status-aktif-card">
        <div class="judul">Transaksi #{{ $statusAktif->id_penyewaan }} · {{ $statusAktif->tipe }}</div>

        @if($statusAktif->status == 'Pending')
            <div class="isi">🕓 Menunggu Persetujuan Admin</div>
            <div class="sub">Pengajuan sewamu sedang ditinjau. Kamu akan bisa mengambil sepeda setelah disetujui admin.</div>
        @elseif($statusAktif->status == 'Disetujui')
            <div class="isi">✅ Silakan Ambil Sepeda</div>
            <div class="sub">Pesananmu sudah disetujui. Datang ke lokasi rental dengan membawa NIK asli untuk mengambil sepeda, lalu lakukan pembayaran.</div>
        @elseif($statusAktif->status == 'Sedang Disewa')
            <div class="isi">🚲 Sedang Disewa</div>
            <div class="sub">Batas waktu pengembalian: {{ \Carbon\Carbon::parse($statusAktif->deadline_kembali)->format('d M Y H:i') }}</div>
            <div class="countdown" id="countdown" data-deadline="{{ \Carbon\Carbon::parse($statusAktif->deadline_kembali)->toIso8601String() }}">Menghitung sisa waktu...</div>
        @endif
    </div>
</div>
@endif

<div class="container">
    <div class="header-wrapper" style="border-bottom: 3px solid #f1f5f9; margin-bottom: 20px;">
        <h2 style="font-size: 20px;">📋 Riwayat Sewa Saya</h2>
    </div>

    @if($riwayatSewa->isEmpty())
        <div class="empty-state">Kamu belum pernah menyewa sepeda.</div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Tipe Sepeda</th>
                    <th>Durasi</th>
                    <th>Total Biaya</th>
                    <th>Status</th>
                    <th>Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riwayatSewa as $sewa)
                <tr>
                    <td>{{ $sewa->tipe }}</td>
                    <td>{{ $sewa->durasi }} {{ $sewa->jenis_sewa == 'per_jam' ? 'jam' : 'hari' }}</td>
                    <td>
                        Rp {{ number_format($sewa->total_biaya, 0, ',', '.') }}
                        @if($sewa->total_denda > 0)
                            <br><span class="denda-tag">+ Denda Rp {{ number_format($sewa->total_denda, 0, ',', '.') }}</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $statusClass = [
                                'Pending' => 'status-pending',
                                'Disetujui' => 'status-disetujui',
                                'Sedang Disewa' => 'status-sedang-disewa',
                                'Selesai' => 'status-selesai',
                                'Ditolak' => 'status-ditolak',
                            ][$sewa->status] ?? 'status-pending';
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ $sewa->status }}</span>
                    </td>
                    <td>
                        @if($sewa->status_pembayaran == 'Sudah Dibayar')
                            <span class="status-badge status-selesai">Sudah Dibayar</span>
                        @else
                            <span class="status-badge status-pending">Belum Dibayar</span>
                        @endif
                    </td>
                    <td>
                        @if($sewa->status == 'Disetujui' && $sewa->status_pembayaran != 'Sudah Dibayar')
                            <button type="button" class="btn-upload" onclick="openUpload({{ $sewa->id_penyewaan }}, {{ $sewa->total_biaya }}, '{{ $sewa->batas_pembayaran ? \Carbon\Carbon::parse($sewa->batas_pembayaran)->toIso8601String() : '' }}')">Bayar Sekarang</button>
                        @elseif($sewa->status == 'Selesai')
                            <a href="/riwayat/{{ $sewa->id_penyewaan }}/nota" class="btn-nota" target="_blank">🧾 Lihat Nota</a>
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

<div class="modal-overlay" id="modalSewa">
    <div class="modal-box">
        <h3 style="margin-top:0;" id="sewaJudul">🚲 Ajukan Sewa</h3>

        <form id="formSewa" method="POST" onsubmit="return confirm('Ajukan sewa sekarang?')">
            @csrf
            <label>Jenis Sewa:</label>
            <select name="jenis_sewa" id="sewaJenis" required onchange="updateSewaTotal()">
                <option value="per_jam">Per Jam</option>
                <option value="per_hari">Per Hari</option>
            </select>
            <label>Durasi:</label>
            <input type="number" name="durasi" id="sewaDurasi" min="1" value="1" required oninput="updateSewaTotal()">

            <div class="payment-info" style="padding:12px 14px;">
                <div class="payment-total" style="margin-bottom:0;">Estimasi Total: <b id="sewaTotal">Rp 0</b></div>
            </div>
            <br>

            <label class="tnc-check" style="margin-bottom:14px;">
                <input type="checkbox" name="setuju_syarat" value="1" required>
                Saya sudah membaca &amp; menyetujui <a href="/syarat-ketentuan" target="_blank">Syarat &amp; Ketentuan</a> penyewaan (wajib membawa NIK asli saat ambil sepeda, denda keterlambatan berlaku).
            </label>

            <button type="submit" class="btn-kirim">✅ Ajukan Sewa</button>
            <button type="button" class="btn-batal" onclick="document.getElementById('modalSewa').style.display='none'">Batal</button>
        </form>
    </div>
</div>

<div class="modal-overlay" id="modalUpload">
    <div class="modal-box">
        <h3 style="margin-top:0;">💳 Pembayaran Sewa</h3>

        <div class="payment-info">
            <div class="payment-total">Total Tagihan: <b id="bayarTotal">Rp 0</b></div>

            <div class="payment-tabs">
                <div class="payment-method-box">
                    <div class="payment-label">Transfer Bank (VA Dummy)</div>
                    <div class="payment-value">BCA Virtual Account<br><span class="rekening">8808 1234 5678 901</span><br>a.n. Rental Sepeda ID</div>
                </div>
                <div class="payment-method-box">
                    <div class="payment-label">QRIS (Dummy)</div>
                    <div class="qris-box">▦▦▦ QRIS DEMO ▦▦▦<br><small>Simulasi — tidak untuk transaksi nyata</small></div>
                </div>
            </div>

            <div class="payment-deadline" id="bayarDeadlineWrap">
                Batas waktu pembayaran:
                <div class="countdown-bayar" id="countdownBayar">Menghitung...</div>
            </div>
        </div>

        <form id="formUpload" method="POST" onsubmit="return confirm('Konfirmasi bahwa pembayaran sudah kamu lakukan?')">
            @csrf
            <label>Metode Pembayaran:</label>
            <select name="metode_pembayaran" required>
                <option value="transfer">Transfer Bank (VA)</option>
                <option value="tunai">Tunai (bayar di lokasi)</option>
            </select>
            <button type="submit" class="btn-kirim">✅ Konfirmasi Pembayaran</button>
            <button type="button" class="btn-batal" onclick="document.getElementById('modalUpload').style.display='none'">Batal</button>
        </form>
    </div>
</div>

<script>
    let sewaHargaJam = 0;
    let sewaHargaHari = 0;

    function openSewa(id, tipe, hargaJam, hargaHari) {
        document.getElementById('formSewa').action = '/sewa/' + id;
        document.getElementById('sewaJudul').innerText = '🚲 Ajukan Sewa: ' + tipe;
        sewaHargaJam = hargaJam;
        sewaHargaHari = hargaHari;
        document.getElementById('sewaJenis').value = 'per_jam';
        document.getElementById('sewaDurasi').value = 1;
        updateSewaTotal();
        document.getElementById('modalSewa').style.display = 'flex';
    }

    function updateSewaTotal() {
        const jenis = document.getElementById('sewaJenis').value;
        const durasi = parseInt(document.getElementById('sewaDurasi').value) || 0;
        const harga = jenis === 'per_jam' ? sewaHargaJam : sewaHargaHari;
        document.getElementById('sewaTotal').innerText = 'Rp ' + (harga * durasi).toLocaleString('id-ID');
    }

    let bayarDeadline = null;

    function openUpload(id, total, batasPembayaran) {
        document.getElementById('formUpload').action = '/pembayaran/' + id + '/konfirmasi';
        document.getElementById('bayarTotal').innerText = 'Rp ' + Number(total).toLocaleString('id-ID');
        document.getElementById('modalUpload').style.display = 'flex';

        bayarDeadline = batasPembayaran ? new Date(batasPembayaran) : null;
        updateCountdownBayar();
    }

    function updateCountdownBayar() {
        const el = document.getElementById('countdownBayar');
        if (!bayarDeadline) { el.innerText = '-'; return; }
        const now = new Date();
        let diff = bayarDeadline - now;
        if (diff <= 0) {
            const telat = Math.abs(diff);
            const jam = Math.floor(telat / 3600000);
            const menit = Math.floor((telat % 3600000) / 60000);
            el.innerText = '⚠️ Sudah lewat ' + jam + ' jam ' + menit + ' menit — segera hubungi admin.';
            el.classList.add('telat');
            return;
        }
        const jam = Math.floor(diff / 3600000);
        const menit = Math.floor((diff % 3600000) / 60000);
        const detik = Math.floor((diff % 60000) / 1000);
        el.innerText = jam + ' jam ' + menit + ' menit ' + detik + ' detik lagi';
    }
    setInterval(updateCountdownBayar, 1000);

    window.onclick = function(event) {
        const modalBayar = document.getElementById('modalUpload');
        const modalSewa = document.getElementById('modalSewa');
        if (event.target == modalBayar) modalBayar.style.display = 'none';
        if (event.target == modalSewa) modalSewa.style.display = 'none';
    }

    // Hitung mundur sisa waktu sewa untuk transaksi yang sedang berjalan
    const countdownEl = document.getElementById('countdown');
    if (countdownEl) {
        const deadline = new Date(countdownEl.dataset.deadline);
        function updateCountdown() {
            const now = new Date();
            let diff = deadline - now;
            if (diff <= 0) {
                countdownEl.classList.add('telat');
                const telat = Math.abs(diff);
                const j = Math.floor(telat / 3600000);
                const m = Math.floor((telat % 3600000) / 60000);
                countdownEl.innerText = '⚠️ Sudah telat ' + j + ' jam ' + m + ' menit — segera kembalikan!';
                return;
            }
            const hari = Math.floor(diff / 86400000);
            const jam = Math.floor((diff % 86400000) / 3600000);
            const menit = Math.floor((diff % 3600000) / 60000);
            const detik = Math.floor((diff % 60000) / 1000);
            let teks = 'Sisa waktu: ';
            if (hari > 0) teks += hari + ' hari ';
            teks += jam + ' jam ' + menit + ' menit ' + detik + ' detik';
            countdownEl.innerText = teks;
        }
        updateCountdown();
        setInterval(updateCountdown, 1000);
    }
</script>

</body>
</html>
