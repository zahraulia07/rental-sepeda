@php
    $sidebarMenuItems = [
        ['url' => '/admin/sepeda', 'match' => 'admin/sepeda', 'icon' => '🚲', 'label' => 'Kelola Sepeda'],
        ['url' => '/admin/pelanggan', 'match' => 'admin/pelanggan', 'icon' => '👥', 'label' => 'Kelola Pelanggan'],
        ['url' => '/admin/transaksi', 'match' => 'admin/transaksi', 'icon' => '📋', 'label' => 'Transaksi Aktif'],
        ['url' => '/admin/riwayat', 'match' => 'admin/riwayat', 'icon' => '📜', 'label' => 'Riwayat'],
        ['url' => '/admin/laporan', 'match' => 'admin/laporan', 'icon' => '💰', 'label' => 'Laporan Keuangan'],
        ['url' => '/admin/maintenance', 'match' => 'admin/maintenance', 'icon' => '🔧', 'label' => 'Maintenance'],
    ];
@endphp

<style>
    .app-shell { display: flex; align-items: flex-start; min-height: 100vh; }

    .sidebar {
        width: 250px; flex-shrink: 0; background: #ffffff;
        border-right: 1px solid #EEF0F7; min-height: 100vh;
        display: flex; flex-direction: column; padding: 26px 20px;
        position: sticky; top: 0; align-self: flex-start;
        font-family: 'Inter', sans-serif;
    }
    .sidebar-brand { display: flex; align-items: center; gap: 10px; margin-bottom: 18px; padding: 0 4px; }
    .sidebar-brand .logo-badge {
        width: 34px; height: 34px; border-radius: 10px; flex-shrink: 0;
        background: linear-gradient(135deg, #0F766E 0%, #10B981 100%);
        display: flex; align-items: center; justify-content: center; font-size: 17px; overflow: hidden;
    }
    .sidebar-brand .logo-badge img { width: 100%; height: 100%; object-fit: cover; }
    .sidebar-brand .brand-text h1 { font-family: 'Space Grotesk', sans-serif; font-size: 15.5px; font-weight: 700; color: #065F46; margin: 0; line-height: 1.25; }
    .sidebar-brand .brand-text span { font-size: 11px; color: #94A3B8; font-weight: 600; }

    /* Lonceng notifikasi */
    .sidebar-bell-wrap { position: relative; margin-bottom: 18px; }
    .sidebar-bell-trigger {
        width: 100%; display: flex; align-items: center; gap: 9px;
        padding: 10px 12px; border-radius: 12px; border: 1px solid #EEF0F7; background: #F8FAFC;
        cursor: pointer; font-family: 'Inter', sans-serif; font-size: 12.5px; font-weight: 700; color: #334155;
        transition: all 0.15s ease;
    }
    .sidebar-bell-trigger:hover { background: #F1F5F9; }
    .sidebar-bell-trigger .bell-icon { font-size: 15px; }
    .sidebar-bell-trigger .notif-badge {
        margin-left: auto; background: #E11D48; color: #fff; font-size: 10.5px; font-weight: 800;
        min-width: 18px; height: 18px; border-radius: 999px; display: flex; align-items: center; justify-content: center;
        padding: 0 5px;
    }
    .admin-notif-dropdown {
        position: absolute; top: 0; left: calc(100% + 10px); z-index: 70;
        width: 300px; max-height: 380px; overflow-y: auto;
        background: #fff; border: 1px solid #EEF0F7; border-radius: 16px;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.16); padding: 8px;
        opacity: 0; visibility: hidden; transform: translateX(-8px);
        transition: all 0.18s ease;
    }
    .sidebar-bell-wrap.open .admin-notif-dropdown { opacity: 1; visibility: visible; transform: translateX(0); }
    .notif-dropdown-head { padding: 8px 10px 10px; font-size: 13px; font-weight: 800; color: #10131C; border-bottom: 1px solid #EEF0F7; margin-bottom: 4px; }
    .notif-item { display: block; text-decoration: none; padding: 10px; border-radius: 12px; margin-bottom: 2px; }
    .notif-item:hover { background: #F8FAFC; }
    .notif-item.unread { background: #ECFDF5; }
    .notif-item.unread:hover { background: #D1FAE5; }
    .notif-item .notif-judul { font-size: 12.5px; font-weight: 800; color: #10131C; margin-bottom: 2px; display: flex; align-items: center; gap: 6px; }
    .notif-item.unread .notif-judul::before { content: ""; width: 7px; height: 7px; border-radius: 50%; background: #10B981; flex-shrink: 0; }
    .notif-item .notif-msg { font-size: 12px; color: #64748B; line-height: 1.5; }
    .notif-item .notif-time { font-size: 10.5px; color: #94A3B8; margin-top: 4px; font-weight: 700; text-transform: uppercase; }
    .notif-empty { padding: 24px 10px; text-align: center; font-size: 12.5px; color: #94A3B8; }

    .sidebar-nav { flex: 1; }
    .sidebar-item {
        display: flex; align-items: center; gap: 11px; padding: 11px 14px; margin-bottom: 4px;
        border-radius: 12px; text-decoration: none; color: #475569; font-size: 13.5px; font-weight: 600;
        transition: all 0.15s ease;
    }
    .sidebar-item .nav-icon { font-size: 16px; width: 18px; text-align: center; }
    .sidebar-item:hover { background: #F1F5F9; color: #10131C; }
    .sidebar-item.active {
        background: linear-gradient(135deg, #0F766E 0%, #10B981 100%); color: #fff;
        box-shadow: 0 8px 18px -6px rgba(15, 118, 110, 0.45);
    }

    .sidebar-bottom { border-top: 1px solid #EEF0F7; padding-top: 16px; margin-top: 16px; }
    .sidebar-bottom .btn-logout-side {
        width: 100%; display: flex; align-items: center; gap: 11px; padding: 11px 14px;
        border-radius: 12px; border: none; background: none; cursor: pointer; text-align: left;
        color: #E11D48; font-size: 13.5px; font-weight: 600; font-family: 'Inter', sans-serif;
    }
    .sidebar-bottom .btn-logout-side:hover { background: #FEF2F2; }

    .admin-profile { display: flex; align-items: center; gap: 10px; padding: 12px 6px 0; }
    .admin-profile .avatar {
        width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
        background: linear-gradient(135deg, #A7F3D0, #6EE7B7); display: flex; align-items: center; justify-content: center;
        font-weight: 700; color: #065F46; font-size: 13px;
    }
    .admin-profile .info p { margin: 0; font-size: 13px; font-weight: 700; color: #10131C; }
    .admin-profile .info span { font-size: 11px; color: #94A3B8; font-weight: 700; letter-spacing: 0.4px; }

    .admin-main { flex: 1; min-width: 0; padding: 40px 32px 48px; }

    @media (max-width: 900px) {
        .sidebar { display: none; }
        .admin-main { padding: 24px 16px 40px; }
    }
</style>

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="logo-badge"><img src="{{ asset('images/logo.png') }}" alt="Gowesin"></div>
        <div class="brand-text">
            <h1>Gowesin Admin</h1>
            <span>Management Portal</span>
        </div>
    </div>

    <div class="sidebar-bell-wrap" id="adminNotifWrap">
        <button type="button" class="sidebar-bell-trigger" onclick="toggleAdminNotif(event)">
            <span class="bell-icon">🔔</span>
            <span>Notifikasi</span>
            @if($jumlahNotifBelumDibacaAdmin > 0)
                <span class="notif-badge" id="adminNotifBadge">{{ $jumlahNotifBelumDibacaAdmin > 9 ? '9+' : $jumlahNotifBelumDibacaAdmin }}</span>
            @endif
        </button>
        <div class="admin-notif-dropdown" id="adminNotifDropdown">
            <div class="notif-dropdown-head">🔔 Notifikasi</div>
            @forelse($daftarNotifikasiAdmin as $notif)
                <a href="/notifikasi/{{ $notif->id_notifikasi }}/buka" class="notif-item {{ $notif->dibaca ? '' : 'unread' }}">
                    <div class="notif-judul">{{ $notif->judul }}</div>
                    <div class="notif-msg">{{ $notif->pesan }}</div>
                    <div class="notif-time">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</div>
                </a>
            @empty
                <div class="notif-empty">Belum ada notifikasi.</div>
            @endforelse
        </div>
    </div>

    <nav class="sidebar-nav">
        @foreach($sidebarMenuItems as $item)
            <a href="{{ $item['url'] }}" class="sidebar-item {{ request()->is($item['match']) ? 'active' : '' }}">
                <span class="nav-icon">{{ $item['icon'] }}</span> {{ $item['label'] }}
            </a>
        @endforeach
    </nav>

    <div class="sidebar-bottom">
        <form action="/logout" method="POST" onsubmit="return confirm('Keluar dari sistem?')">
            @csrf
            <button type="submit" class="btn-logout-side"><span class="nav-icon">🚪</span> Keluar</button>
        </form>
        <div class="admin-profile">
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}</div>
            <div class="info">
                <p>{{ Auth::user()->name ?? 'Admin' }}</p>
                <span>{{ strtoupper(Auth::user()->role ?? 'ADMIN') }}</span>
            </div>
        </div>
    </div>
</aside>

<script>
    function toggleAdminNotif(event) {
        event.stopPropagation();
        const wrap = document.getElementById('adminNotifWrap');
        const willOpen = !wrap.classList.contains('open');
        wrap.classList.toggle('open');

        if (willOpen) {
            const badge = document.getElementById('adminNotifBadge');
            if (badge) badge.remove();

            fetch('/notifikasi/tandai-dibaca', {
                method: 'POST',
                keepalive: true,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            }).then(() => {
                document.querySelectorAll('#adminNotifDropdown .notif-item.unread').forEach(el => el.classList.remove('unread'));
            }).catch(() => {});
        }
    }
    document.addEventListener('click', function (event) {
        const wrap = document.getElementById('adminNotifWrap');
        if (wrap && !wrap.contains(event.target)) {
            wrap.classList.remove('open');
        }
    });
</script>
