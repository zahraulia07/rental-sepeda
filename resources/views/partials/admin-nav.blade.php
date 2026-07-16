@php
    $adminMenuItems = [
        ['url' => '/admin/sepeda', 'match' => 'admin/sepeda', 'icon' => '🚲', 'label' => 'Inventaris'],
        ['url' => '/admin/transaksi', 'match' => 'admin/transaksi', 'icon' => '📑', 'label' => 'Transaksi Aktif'],
        ['url' => '/admin/riwayat', 'match' => 'admin/riwayat', 'icon' => '📜', 'label' => 'Riwayat'],
        ['url' => '/admin/pelanggan', 'match' => 'admin/pelanggan', 'icon' => '👥', 'label' => 'Pelanggan'],
        ['url' => '/admin/laporan', 'match' => 'admin/laporan', 'icon' => '📊', 'label' => 'Laporan'],
        ['url' => '/admin/maintenance', 'match' => 'admin/maintenance', 'icon' => '🔧', 'label' => 'Maintenance'],
    ];
@endphp

<style>
    .admin-tabs {
        display: flex; flex-wrap: wrap; gap: 5px;
        padding: 6px; margin-bottom: 28px;
        background: #F1F2F8; border: 1px solid #E7E9F5; border-radius: 16px;
    }
    .admin-tab {
        display: flex; align-items: center; gap: 7px;
        padding: 9px 16px; border-radius: 11px;
        text-decoration: none; white-space: nowrap;
        font-family: 'Inter', sans-serif; font-weight: 600; font-size: 12.5px;
        color: #5B5F73; transition: all 0.16s ease;
    }
    .admin-tab .tab-icon { font-size: 14px; line-height: 1; }
    .admin-tab:hover { color: #10131C; background: #ffffffaa; }
    .admin-tab.active {
        color: #fff;
        background: linear-gradient(135deg, #06B6D4 0%, #635BFF 55%, #A855F7 100%);
        box-shadow: 0 8px 18px -6px rgba(99, 91, 255, 0.55);
    }
    @media (max-width: 640px) {
        .admin-tab { padding: 8px 12px; font-size: 12px; }
        .admin-tab .tab-icon { font-size: 13px; }
    }
</style>

<nav class="admin-tabs">
    @foreach($adminMenuItems as $item)
        <a href="{{ $item['url'] }}" class="admin-tab {{ request()->is($item['match']) ? 'active' : '' }}">
            <span class="tab-icon">{{ $item['icon'] }}</span>{{ $item['label'] }}
        </a>
    @endforeach
</nav>
