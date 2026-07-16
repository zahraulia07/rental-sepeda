@php
    $sidebarMenuItems = [
        ['url' => '/admin/sepeda', 'match' => 'admin/sepeda', 'icon' => '🚲', 'label' => 'Kelola Sepeda'],
        ['url' => '/admin/pelanggan', 'match' => 'admin/pelanggan', 'icon' => '👥', 'label' => 'Kelola Pelanggan'],
        ['url' => '/admin/transaksi', 'match' => 'admin/transaksi', 'icon' => '📋', 'label' => 'Transaksi Aktif'],
        ['url' => '/admin/riwayat', 'match' => 'admin/riwayat', 'icon' => '📜', 'label' => 'Riwayat'],
        ['url' => '/admin/pembayaran', 'match' => 'admin/pembayaran', 'icon' => '💳', 'label' => 'Pembayaran'],
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
    .sidebar-brand { display: flex; align-items: center; gap: 10px; margin-bottom: 30px; padding: 0 4px; }
    .sidebar-brand .logo-badge {
        width: 34px; height: 34px; border-radius: 10px; flex-shrink: 0;
        background: linear-gradient(135deg, #0F766E 0%, #10B981 100%);
        display: flex; align-items: center; justify-content: center; font-size: 17px;
    }
    .sidebar-brand .brand-text h1 { font-family: 'Space Grotesk', sans-serif; font-size: 15.5px; font-weight: 700; color: #065F46; margin: 0; line-height: 1.25; }
    .sidebar-brand .brand-text span { font-size: 11px; color: #94A3B8; font-weight: 600; }

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
        <div class="logo-badge">🚲</div>
        <div class="brand-text">
            <h1>Gowesin Admin</h1>
            <span>Management Portal</span>
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
