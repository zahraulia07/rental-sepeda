<style>
    .admin-nav { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 20px; }
    .admin-nav a {
        text-decoration: none; font-size: 13px; font-weight: 600; color: #475569;
        background: #f1f5f9; padding: 8px 14px; border-radius: 8px; border: 1px solid #e2e8f0;
        transition: all 0.15s;
    }
    .admin-nav a:hover { background: #e2e8f0; color: #0f172a; }
    .admin-nav a.active { background: #10b981; color: #fff; border-color: #10b981; }
</style>
<div class="admin-nav">
    <a href="/admin/sepeda" class="{{ request()->is('admin/sepeda') ? 'active' : '' }}">🚲 Inventaris Sepeda</a>
    <a href="/admin/transaksi" class="{{ request()->is('admin/transaksi') ? 'active' : '' }}">📑 Transaksi Aktif</a>
    <a href="/admin/riwayat" class="{{ request()->is('admin/riwayat') ? 'active' : '' }}">📜 Riwayat</a>
    <a href="/admin/pelanggan" class="{{ request()->is('admin/pelanggan') ? 'active' : '' }}">👥 Pelanggan</a>
    <a href="/admin/laporan" class="{{ request()->is('admin/laporan') ? 'active' : '' }}">📊 Laporan Pendapatan</a>
    <a href="/admin/maintenance" class="{{ request()->is('admin/maintenance') ? 'active' : '' }}">🔧 Maintenance</a>
</div>
