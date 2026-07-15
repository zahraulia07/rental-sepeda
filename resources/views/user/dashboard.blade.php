<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - BikeRent Pro</title>
    <!-- Koneksi Aset Vite & Tailwind CSS Bawaan Proyek -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Google Fonts untuk tampilan font modern -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

<div class="flex h-screen overflow-hidden">
    
    <!-- ========================================== -->
    <!-- SIDEBAR (KIRI) -->
    <!-- ========================================== -->
    <aside class="w-64 bg-white border-r border-slate-200 flex flex-col justify-between p-6 shrink-0">
        <div>
            <!-- Logo Brand -->
            <div class="mb-8 px-2">
                <h1 class="font-bold text-xl text-slate-900 tracking-tight">BikeRent <span class="text-emerald-600">Pro</span></h1>
                <p class="text-xs text-slate-400 font-medium">User Dashboard Hub</p>
            </div>
            
            <!-- Navigasi Menu (Menggunakan partial bawaan proyekmu) -->
            <div class="mb-4">
                @include('partials.user-nav')
            </div>

            <!-- Tambahan Menu Navigasi Modern -->
            <nav class="space-y-1">
                <a href="/dashboard" class="flex items-center gap-3 px-4 py-2.5 bg-emerald-50 text-emerald-700 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path></svg>
                    Sewa Sepeda
                </a>
                
                <!-- Tombol Keluar / Logout Sistem -->
                <form action="/logout" method="POST" onsubmit="return confirm('Keluar dari sistem?')" class="block w-full pt-4 border-t border-slate-100 mt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-red-500 hover:bg-red-50 rounded-xl font-medium text-sm transition text-left">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar
                    </button>
                </form>
            </nav>
        </div>
        
        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 text-center">
            <p class="text-xs text-slate-500 font-medium">Butuh bantuan sewa?<br><a href="#" class="text-emerald-600 font-bold underline">Hubungi Admin</a></p>
        </div>
    </aside>

    <!-- ========================================== -->
    <!-- MAIN CONTENT AREA (KANAN) -->
    <!-- ========================================== -->
    <div class="flex-1 flex flex-col overflow-y-auto">
        
        <!-- Top Navbar -->
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 sticky top-0 z-10 shrink-0">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Selamat Datang</span>
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2 mt-0.5">
                    {{ Auth::user()->name }} 
                    <span class="px-2 py-0.5 bg-blue-50 text-blue-600 font-bold text-[10px] rounded uppercase tracking-wider">{{ Auth::user()->role }}</span>
                </h2>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="h-8 w-px bg-slate-200"></div>
                <div class="w-9 h-9 bg-emerald-100 text-emerald-700 font-bold rounded-full flex items-center justify-center text-sm shadow-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
            </div>
        </header>

        <!-- Main Workspace Scrollable -->
        <main class="p-8 space-y-8 flex-1">
            
            <!-- ALERT NOTIFIKASI SYSTEM -->
            @if(session('sukses'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-xl text-sm font-medium shadow-sm">
                    ✔️ {{ session('sukses') }}
                </div>
            @endif
            @if(session('gagal'))
                <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 p-4 rounded-xl text-sm font-medium shadow-sm">
                    ⚠️ {{ session('gagal') }}
                </div>
            @endif
            @if(Auth::user()->is_blocked)
                <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-2xl text-sm font-semibold text-center shadow-sm">
                    🚫 Akun Anda diblokir dan tidak dapat mengajukan sewa baru.
                    @if(Auth::user()->alasan_blokir) <br><span class="font-normal text-slate-500 text-xs">Alasan: {{ Auth::user()->alasan_blokir }}</span> @endif
                </div>
            @endif

            <!-- HERO DASHBOARD BANNER -->
            <div class="bg-slate-900 rounded-3xl p-8 lg:p-10 relative overflow-hidden flex flex-col justify-center min-h-[260px] shadow-xl shadow-slate-900/10">
                <div class="absolute right-0 bottom-0 top-0 w-1/2 opacity-15 pointer-events-none bg-[url('https://images.unsplash.com/photo-1485965120184-e220f721d03e?auto=format&fit=crop&w=600&q=80')] bg-cover bg-center"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/95 to-transparent"></div>
                
                <div class="relative z-10 max-w-xl space-y-3">
                    <h2 class="text-2xl lg:text-3xl font-bold text-white tracking-tight leading-tight">Sewa Sepeda Pilihanmu</h2>
                    <p class="text-slate-400 text-xs lg:text-sm leading-relaxed">Pilih armada terbaik yang siap digunakan untuk menunjang aktivitas harian maupun olahraga santai kamu hari ini.</p>
                </div>
            </div>

            <!-- STATUS SEWA AKTIF DINAMIS -->
            @php
                $statusAktif = $riwayatSewa->whereIn('status', ['Pending', 'Disetujui', 'Sedang Disewa'])->first();
            @endphp
            @if($statusAktif)
            <div class="bg-white p-6 rounded-2xl border border-indigo-100 shadow-sm bg-gradient-to-br from-white to-indigo-50/20 space-y-4">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-900 tracking-tight flex items-center gap-2">
                        <span class="animate-pulse w-2 h-2 rounded-full bg-indigo-600"></span> ⏱️ Status Sewa Aktif Anda
                    </h3>
                    <span class="text-xs font-semibold text-slate-400">Transaksi #{{ $statusAktif->id_penyewaan }}</span>
                </div>
                
                <div class="p-4 bg-white border border-indigo-100 rounded-xl shadow-inner">
                    <div class="font-bold text-base text-slate-900 flex items-center gap-2">
                        🚲 {{ $statusAktif->tipe }}
                    </div>

                    @if($statusAktif->status == 'Pending')
                        <div class="text-amber-600 font-bold text-sm mt-2 flex items-center gap-1.5">🕓 Menunggu Persetujuan Admin</div>
                        <p class="text-xs text-slate-400 mt-1">Pengajuan sewamu sedang ditinjau. Kamu akan bisa mengambil sepeda setelah disetujui admin.</p>
                    @elseif($statusAktif->status == 'Disetujui')
                        <div class="text-blue-600 font-bold text-sm mt-2 flex items-center gap-1.5">✅ Silakan Ambil Sepeda</div>
                        <p class="text-xs text-slate-400 mt-1">Pesananmu sudah disetujui. Datang ke lokasi rental dengan membawa NIK asli untuk mengambil sepeda, lalu lakukan pembayaran.</p>
                    @elseif($statusAktif->status == 'Sedang Disewa')
                        <div class="text-indigo-600 font-bold text-sm mt-2 flex items-center gap-1.5">🚀 Sepeda Sedang Disewa</div>
                        <p class="text-xs text-slate-400 mt-1">Batas waktu pengembalian: <span class="font-semibold text-slate-700">{{ \Carbon\Carbon::parse($statusAktif->deadline_kembali)->format('d M Y H:i') }}</span></p>
                        <div class="mt-3 text-lg font-extrabold text-indigo-600 tracking-wide bg-indigo-50 px-4 py-2 rounded-lg inline-block" id="countdown" data-deadline="{{ \Carbon\Carbon::parse($statusAktif->deadline_kembali)->toIso8601String() }}">
                            Menghitung sisa waktu...
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- FILTER SEARCH SECTION BAR -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/60 shadow-sm">
                <form method="GET" action="/dashboard" class="flex flex-col md:flex-row gap-3">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" name="cari" placeholder="Cari tipe sepeda..." value="{{ request('cari') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-xs focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition">
                    </div>
                    
                    <select name="status" class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-600 focus:outline-none focus:border-emerald-500 transition">
                        <option value="">Semua Status</option>
                        <option value="Tersedia" {{ request('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="Disewa" {{ request('status') == 'Disewa' ? 'selected' : '' }}>Disewa</option>
                        <option value="Maintenance" {{ request('status') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>

                    <select name="kategori" class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-600 focus:outline-none focus:border-emerald-500 transition">
                        <option value="">Semua Kategori</option>
                        @foreach($daftarKategori as $kategori)
                            <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                        @endforeach
                    </select>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-emerald-600 text-white text-xs font-bold px-5 py-2.5 rounded-xl hover:bg-emerald-700 transition flex-1 md:flex-none">Filter</button>
                        <a href="/dashboard" class="bg-slate-100 text-slate-600 text-xs font-bold px-5 py-2.5 rounded-xl hover:bg-slate-200 transition text-center flex-1 md:flex-none">Reset</a>
                    </div>
                </form>
            </div>

            <!-- GRID DATA CATALOG UNIT SEPEDA -->
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-slate-900 tracking-tight">Katalog Armada</h3>
                
                @if($sepedaTersedia->isEmpty())
                    <div class="bg-white p-12 text-center rounded-2xl border border-dashed border-slate-300 text-slate-400 text-sm font-medium">
                        Tidak ada sepeda yang cocok dengan filter pencarian kamu.
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($sepedaTersedia as $sepeda)
                        @php
                            $bisaSewa = $sepeda->status === 'Tersedia' && $sepeda->stok > 0;
                            $chipClass = match(true) {
                                $sepeda->status === 'Tersedia' && $sepeda->stok > 0 => 'bg-emerald-50 text-emerald-700',
                                $sepeda->status === 'Tersedia' && $sepeda->stok <= 0 => 'bg-rose-50 text-rose-700',
                                $sepeda->status === 'Maintenance' => 'bg-amber-50 text-amber-700',
                                $sepeda->status === 'Disewa' => 'bg-indigo-50 text-indigo-700',
                                default => 'bg-slate-100 text-slate-700',
                            };
                            $labelStatus = ($sepeda->status === 'Tersedia' && $sepeda->stok <= 0) ? 'Stok Habis' : $sepeda->status;
                        @endphp
                        
                        <div class="bg-white rounded-2xl border border-slate-200/60 overflow-hidden shadow-sm hover:shadow-md transition group flex flex-col justify-between {{ $bisaSewa ? '' : 'opacity-75' }}">
                            <div class="relative bg-slate-100 aspect-[4/3] overflow-hidden shrink-0">
                                @if($sepeda->gambar)
                                    <img src="{{ asset('storage/' . $sepeda->gambar) }}" alt="{{ $sepeda->tipe }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-slate-100 text-4xl">🚲</div>
                                @endif
                                <span class="absolute top-3 left-3 text-[10px] font-bold px-2.5 py-1 rounded-lg shadow-sm uppercase tracking-wider {{ $chipClass }}">
                                    {{ $labelStatus }}
                                </span>
                            </div>

                            <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                                <div class="space-y-1">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md">{{ $sepeda->kategori }}</span>
                                    <h4 class="font-bold text-slate-900 text-base line-clamp-1 pt-1">{{ $sepeda->tipe }}</h4>
                                </div>

                                <div class="space-y-1 bg-slate-50 p-3 rounded-xl border border-slate-100 text-xs text-slate-600">
                                    <div class="flex justify-between"><span>Per Jam:</span> <span class="font-bold text-slate-900">Rp {{ number_format($sepeda->harga_per_jam, 0, ',', '.') }}</span></div>
                                    <div class="flex justify-between"><span>Per Hari:</span> <span class="font-bold text-slate-900">Rp {{ number_format($sepeda->harga_per_hari, 0, ',', '.') }}</span></div>
                                    <div class="flex justify-between border-t border-slate-200/60 pt-1 mt-1 text-[11px] font-medium text-slate-400"><span>Sisa Stok:</span> <span>{{ $sepeda->stok }} unit</span></div>
                                </div>

                                @if(!$bisaSewa)
                                    <button class="w-full bg-slate-100 text-slate-400 text-xs font-bold py-2.5 rounded-xl cursor-not-allowed">
                                        {{ $sepeda->status === 'Maintenance' ? 'Sedang Maintenance' : ($sepeda->status === 'Disewa' ? 'Sedang Disewa' : 'Stok Habis') }}
                                    </button>
                                @elseif(!Auth::user()->is_blocked)
                                    <button type="button" class="w-full bg-slate-950 text-white text-xs font-bold py-2.5 rounded-xl hover:bg-emerald-600 transition shadow-sm shadow-slate-950/10" onclick="openSewa({{ $sepeda->id_sepeda }}, '{{ addslashes($sepeda->tipe) }}', {{ $sepeda->harga_per_jam }}, {{ $sepeda->harga_per_hari }})">
                                        Ajukan Sewa
                                    </button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- TABLE SECTION: RIWAYAT SEWA SAYA -->
            <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">📋 Riwayat Sewa Saya</h3>
                </div>
                
                @if($riwayatSewa->isEmpty())
                    <div class="p-8 text-center text-slate-400 text-xs font-medium">Kamu belum pernah menyewa sepeda di sistem kami.</div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs whitespace-nowrap">
                            <thead class="bg-slate-50 text-slate-400 text-[10px] font-bold uppercase tracking-wider border-b border-slate-100">
                                <tr>
                                    <th class="py-3.5 px-6">Tipe Sepeda</th>
                                    <th class="py-3.5 px-6">Durasi</th>
                                    <th class="py-3.5 px-6">Total Biaya</th>
                                    <th class="py-3.5 px-6">Status Transaksi</th>
                                    <th class="py-3.5 px-6">Pembayaran</th>
                                    <th class="py-3.5 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                                @foreach($riwayatSewa as $sewa)
                                <tr>
                                    <td class="py-4 px-6 font-semibold text-slate-900">{{ $sewa->tipe }}</td>
                                    <td class="py-4 px-6 text-slate-400">{{ $sewa->durasi }} {{ $sewa->jenis_sewa == 'per_jam' ? 'jam' : 'hari' }}</td>
                                    <td class="py-4 px-6 text-slate-900 font-semibold">
                                        Rp {{ number_format($sewa->total_biaya, 0, ',', '.') }}
                                        @if($sewa->total_denda > 0)
                                            <br><span class="text-rose-600 font-bold text-[10px] bg-rose-50 px-1.5 py-0.5 rounded inline-block mt-0.5">+ Denda Rp {{ number_format($sewa->total_denda, 0, ',', '.') }}</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        @php
                                            $statusStyle = [
                                                'Pending' => 'bg-amber-50 text-amber-700',
                                                'Disetujui' => 'bg-blue-50 text-blue-700',
                                                'Sedang Disewa' => 'bg-indigo-50 text-indigo-700',
                                                'Selesai' => 'bg-emerald-50 text-emerald-700',
                                                'Ditolak' => 'bg-rose-50 text-rose-700',
                                            ][$sewa->status] ?? 'bg-slate-50 text-slate-700';
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase {{ $statusStyle }}">{{ $sewa->status }}</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($sewa->status_pembayaran == 'Sudah Dibayar')
                                            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase bg-emerald-50 text-emerald-700">Sudah Dibayar</span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase bg-amber-50 text-amber-700">Belum Dibayar</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if($sewa->status == 'Disetujui' && $sewa->status_pembayaran != 'Sudah Dibayar')
                                            <button type="button" class="bg-blue-600 text-white text-[11px] font-bold px-3 py-1.5 rounded-lg hover:bg-blue-700 shadow-sm transition" onclick="openUpload({{ $sewa->id_penyewaan }}, {{ $sewa->total_biaya }}, '{{ $sewa->batas_pembayaran ? \Carbon\Carbon::parse($sewa->batas_pembayaran)->toIso8601String() : '' }}')">Bayar Sekarang</button>
                                        @elseif($sewa->status == 'Selesai')
                                            <a href="/riwayat/{{ $sewa->id_penyewaan }}/nota" class="inline-flex items-center gap-1 border border-emerald-200 bg-emerald-50 text-emerald-700 text-[11px] font-bold px-3 py-1.5 rounded-lg hover:bg-emerald-100 transition" target="_blank">🧾 Nota</a>
                                        @else
                                            <span class="text-slate-300">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </main>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL OVERLAY: AJUKAN SEWA -->
<!-- ========================================== -->
<div class="modal-overlay fixed inset-0 bg-slate-900/40 hidden justify-center items-center z-50 backdrop-blur-xs" id="modalSewa">
    <div class="modal-box bg-white p-6 rounded-2xl w-full max-w-md max-h-[88vh] overflow-y-auto shadow-xl border border-slate-100 space-y-4">
        <h3 class="text-base font-bold text-slate-900 flex items-center gap-1.5" id="sewaJudul">🚲 Ajukan Sewa</h3>

        <form id="formSewa" method="POST" onsubmit="return confirm('Ajukan sewa sekarang?')" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Jenis Sewa:</label>
                <select name="jenis_sewa" id="sewaJenis" required onchange="updateSewaTotal()" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-emerald-500 transition">
                    <option value="per_jam">Per Jam</option>
                    <option value="per_hari">Per Hari</option>
                </select>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Durasi:</label>
                <input type="number" name="durasi" id="sewaDurasi" min="1" value="1" required oninput="updateSewaTotal()" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-emerald-500 transition">
            </div>

            <div class="bg-emerald-50 p-4 rounded-xl border border-emerald-100">
                <div class="text-xs font-semibold text-emerald-700">Estimasi Total Biaya:</div>
                <div class="text-xl font-extrabold text-slate-900 mt-0.5" id="sewaTotal">Rp 0</div>
            </div>

            <label class="flex items-start gap-2 text-[11px] text-slate-400 leading-relaxed cursor-pointer">
                <input type="checkbox" name="setuju_syarat" value="1" required class="mt-0.5 rounded text-emerald-600 focus:ring-emerald-500/20 border-slate-300">
                <span>Saya menyetujui <a href="/syarat-ketentuan" target="_blank" class="text-indigo-600 font-semibold underline">Syarat &amp; Ketentuan</a> (wajib membawa NIK asli saat ambil unit dan menyetujui denda keterlambatan).</span>
            </label>

            <div class="pt-2 flex flex-col gap-2">
                <button type="submit" class="w-full bg-emerald-600 text-white text-xs font-bold py-3 rounded-xl hover:bg-emerald-700 transition shadow-sm shadow-emerald-200">✅ Kirim Pengajuan</button>
                <button type="button" class="w-full bg-slate-100 text-slate-500 text-xs font-bold py-2.5 rounded-xl hover:bg-slate-200 transition" onclick="document.getElementById('modalSewa').style.display='none'">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL OVERLAY: PEMBAYARAN SEWA -->
<!-- ========================================== -->
<div class="modal-overlay fixed inset-0 bg-slate-900/40 hidden justify-center items-center z-50 backdrop-blur-xs" id="modalUpload">
    <div class="modal-box bg-white p-6 rounded-2xl w-full max-w-md max-h-[88vh] overflow-y-auto shadow-xl border border-slate-100 space-y-4">
        <h3 class="text-base font-bold text-slate-900">💳 Konfirmasi Pembayaran</h3>

        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 space-y-3">
            <div>
                <span class="text-xs text-slate-400 font-medium">Total Tagihan Sewa:</span>
                <div class="text-xl font-extrabold text-slate-900" id="bayarTotal">Rp 0</div>
            </div>

            <div class="space-y-2 pt-2 border-t border-slate-200/60">
                <div class="bg-white p-3 rounded-lg border border-slate-200/60 shadow-xs">
                    <div class="text-[9px] font-bold text-indigo-600 uppercase tracking-wider">Transfer Bank (VA)</div>
                    <div class="text-[11px] font-medium text-slate-700 mt-0.5">BCA Virtual Account</div>
                    <div class="text-sm font-extrabold text-emerald-600 tracking-wider">8808 1234 5678 901</div>
                    <div class="text-[10px] text-slate-400 font-medium">a.n. Rental Sepeda ID</div>
                </div>
                <div class="bg-white p-3 rounded-lg border border-slate-200/60 shadow-xs text-center">
                    <div class="text-[9px] font-bold text-indigo-600 uppercase tracking-wider text-left">QRIS Payment Gateway</div>
                    <div class="bg-slate-100 py-3 font-mono font-bold text-slate-400 rounded-md text-[11px] tracking-widest mt-1">▦▦ QRIS SIMULASI ▦▦</div>
                </div>
            </div>

            <div class="border-t border-slate-200/60 pt-2 text-[11px] text-slate-400" id="bayarDeadlineWrap">
                Batas Akhir Waktu Pembayaran:
                <div class="text-xs font-bold text-amber-700 mt-0.5" id="countdownBayar">Menghitung...</div>
            </div>
        </div>

        <form id="formUpload" method="POST" onsubmit="return confirm('Konfirmasi bahwa pembayaran sudah kamu lakukan?')" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Pilih Metode Pembayaran:</label>
                <select name="metode_pembayaran" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-emerald-500 transition">
                    <option value="transfer">Transfer Bank (VA)</option>
                    <option value="tunai">Tunai (bayar langsung di lokasi)</option>
                </select>
            </div>
            
            <div class="pt-2 flex flex-col gap-2">
                <button type="submit" class="w-full bg-emerald-600 text-white text-xs font-bold py-3 rounded-xl hover:bg-emerald-700 transition shadow-sm shadow-emerald-200">✅ Konfirmasi Bayar</button>
                <button type="button" class="w-full bg-slate-100 text-slate-500 text-xs font-bold py-2.5 rounded-xl hover:bg-slate-200 transition" onclick="document.getElementById('modalUpload').style.display='none'">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- CORE JAVASCRIPT LOGIC FUNCTIONS -->
<!-- ========================================== -->
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
        if (!el) return;
        if (!bayarDeadline) { el.innerText = '-'; return; }
        const now = new Date();
        let diff = bayarDeadline - now;
        if (diff <= 0) {
            const telat = Math.abs(diff);
            const jam = Math.floor(telat / 3600000);
            const menit = Math.floor((telat % 3600000) / 60000);
            el.innerText = '⚠️ Waktu Habis (' + jam + ' jam ' + menit + ' m lalu) — Segera hubungi admin.';
            el.className = "text-xs font-bold text-rose-600 mt-0.5";
            return;
        }
        const jam = Math.floor(diff / 3600000);
        const menit = Math.floor((diff % 3600000) / 60000);
        const detik = Math.floor((diff % 60000) / 1000);
        el.innerText = jam + ' jam ' + menit + ' menit ' + detik + ' detik lagi';
        el.className = "text-xs font-bold text-amber-600 mt-0.5";
    }
    setInterval(updateCountdownBayar, 1000);

    window.onclick = function(event) {
        const modalBayar = document.getElementById('modalUpload');
        const modalSewa = document.getElementById('modalSewa');
        if (event.target == modalBayar) modalBayar.style.display = 'none';
        if (event.target == modalSewa) modalSewa.style.display = 'none';
    }

    // Sistem Hitung Mundur Sisa Waktu Pemakaian Rental Sepeda Aktif
    const countdownEl = document.getElementById('countdown');
    if (countdownEl) {
        const deadline = new Date(countdownEl.dataset.deadline);
        function updateCountdown() {
            const now = new Date();
            let diff = deadline - now;
            if (diff <= 0) {
                countdownEl.className = "mt-3 text-lg font-extrabold text-rose-600 tracking-wide bg-rose-50 px-4 py-2 rounded-lg inline-block";
                const telat = Math.abs(diff);
                const j = Math.floor(telat / 3600000);
                const m = Math.floor((telat % 3600000) / 60000);
                countdownEl.innerText = '⚠️ Terlambat ' + j + ' jam ' + m + ' menit — Harap segera kembalikan!';
                return;
            }
            const hari = Math.floor(diff / 86400000);
            const jam = Math.floor((diff % 86400000) / 3600000);
            const menit = Math.floor((diff % 3600000) / 60000);
            const detik = Math.floor((diff % 60000) / 1000);
            let teks = 'Sisa waktu sewa: ';
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