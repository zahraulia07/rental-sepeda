@php
    $adminMenuItems = [
        ['url' => '/admin/sepeda', 'match' => 'admin/sepeda', 'icon' => '🚲', 'label' => 'Inventaris Sepeda'],
        ['url' => '/admin/transaksi', 'match' => 'admin/transaksi', 'icon' => '📑', 'label' => 'Transaksi Aktif'],
        ['url' => '/admin/riwayat', 'match' => 'admin/riwayat', 'icon' => '📜', 'label' => 'Riwayat'],
        ['url' => '/admin/pelanggan', 'match' => 'admin/pelanggan', 'icon' => '👥', 'label' => 'Pelanggan'],
        ['url' => '/admin/laporan', 'match' => 'admin/laporan', 'icon' => '📊', 'label' => 'Laporan Pendapatan'],
        ['url' => '/admin/maintenance', 'match' => 'admin/maintenance', 'icon' => '🔧', 'label' => 'Maintenance'],
    ];
    $adminCurrentItem = collect($adminMenuItems)->first(fn($item) => request()->is($item['match']));
@endphp

<style>
    .nav-menu-wrap { position: relative; display: inline-block; margin-bottom: 24px; }

    .nav-menu-trigger {
        display: flex; align-items: center; gap: 10px; cursor: pointer; user-select: none;
        background: #f8fafc; border: 1px solid #eef2f7; border-radius: 999px;
        padding: 9px 10px 9px 16px; transition: all 0.2s ease;
    }
    .nav-menu-trigger:hover { background: #fff; box-shadow: 0 4px 14px rgba(15, 23, 42, 0.08); }
    .nav-menu-trigger .current-icon { font-size: 15px; }
    .nav-menu-trigger .current-label { font-size: 13.5px; font-weight: 700; color: #0f172a; letter-spacing: 0.1px; }
    .nav-menu-trigger .kebab {
        width: 28px; height: 28px; border-radius: 50%; flex-shrink: 0;
        background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 15px; font-weight: 900; line-height: 1; letter-spacing: -1px;
        box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);
        transition: transform 0.2s ease;
    }
    .nav-menu-wrap.open .kebab { transform: rotate(90deg); }

    .nav-menu-dropdown {
        position: absolute; top: calc(100% + 10px); left: 0; z-index: 60;
        min-width: 250px; background: #fff; border: 1px solid #eef2f7; border-radius: 18px;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.16); padding: 8px;
        opacity: 0; visibility: hidden; transform: translateY(-8px);
        transition: all 0.18s ease;
    }
    .nav-menu-wrap.open .nav-menu-dropdown { opacity: 1; visibility: visible; transform: translateY(0); }

    .nav-menu-dropdown a {
        display: flex; align-items: center; gap: 10px; text-decoration: none;
        padding: 10px 12px; border-radius: 12px; font-size: 13.5px; font-weight: 700;
        color: #475569; margin-bottom: 2px; transition: all 0.15s ease;
    }
    .nav-menu-dropdown a:last-child { margin-bottom: 0; }
    .nav-menu-dropdown a:hover { background: #f8fafc; color: #0f172a; }
    .nav-menu-dropdown a.active {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: #fff; box-shadow: 0 6px 14px rgba(99, 102, 241, 0.3);
    }
    .nav-menu-dropdown .menu-icon { font-size: 15px; width: 20px; text-align: center; flex-shrink: 0; }
</style>

<div class="nav-menu-wrap" id="adminNavWrap">
    <div class="nav-menu-trigger" onclick="toggleAdminNav(event)">
        <span class="current-icon">{{ $adminCurrentItem['icon'] ?? '📋' }}</span>
        <span class="current-label">{{ $adminCurrentItem['label'] ?? 'Menu Admin' }}</span>
        <span class="kebab">⋮</span>
    </div>
    <div class="nav-menu-dropdown" id="adminNavDropdown">
        @foreach($adminMenuItems as $item)
            <a href="{{ $item['url'] }}" class="{{ request()->is($item['match']) ? 'active' : '' }}">
                <span class="menu-icon">{{ $item['icon'] }}</span> {{ $item['label'] }}
            </a>
        @endforeach
    </div>
</div>

<script>
    function toggleAdminNav(event) {
        event.stopPropagation();
        document.getElementById('adminNavWrap').classList.toggle('open');
    }
    document.addEventListener('click', function (event) {
        const wrap = document.getElementById('adminNavWrap');
        if (wrap && !wrap.contains(event.target)) {
            wrap.classList.remove('open');
        }
    });
</script>
