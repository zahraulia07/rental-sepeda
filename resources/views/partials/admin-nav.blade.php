<style>
    .admin-nav {
        display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 24px;
        padding: 8px; background: #f8fafc; border-radius: 18px; border: 1px solid #eef2f7;
    }
    .admin-nav a {
        text-decoration: none; font-size: 13.5px; font-weight: 700; color: #64748b;
        background: transparent; padding: 10px 18px; border-radius: 14px; border: 1px solid transparent;
        transition: all 0.2s ease; letter-spacing: 0.1px;
    }
    .admin-nav a:hover { background: #ffffff; color: #0f172a; box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06); }
    .admin-nav a.active {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: #fff; border-color: transparent;
        box-shadow: 0 6px 16px rgba(99, 102, 241, 0.35);
    }
</style>
<div class="admin-nav">
    <a href="/admin/sepeda" class="{{ request()->is('admin/sepeda') ? 'active' : '' }}">🚲 Inventaris Sepeda</a>
    <a href="/admin/transaksi" class="{{ request()->is('admin/transaksi') ? 'active' : '' }}">📑 Transaksi Aktif</a>
    <a href="/admin/riwayat" class="{{ request()->is('admin/riwayat') ? 'active' : '' }}">📜 Riwayat</a>
    <a href="/admin/pelanggan" class="{{ request()->is('admin/pelanggan') ? 'active' : '' }}">👥 Pelanggan</a>
    <a href="/admin/laporan" class="{{ request()->is('admin/laporan') ? 'active' : '' }}">📊 Laporan Pendapatan</a>
    <a href="/admin/maintenance" class="{{ request()->is('admin/maintenance') ? 'active' : '' }}">🔧 Maintenance</a>
</div>
