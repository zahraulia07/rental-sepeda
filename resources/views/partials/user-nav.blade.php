<style>
    .user-nav { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 20px; }
    .user-nav a {
        text-decoration: none; font-size: 13px; font-weight: 600; color: #475569;
        background: #f1f5f9; padding: 8px 14px; border-radius: 8px; border: 1px solid #e2e8f0;
        transition: all 0.15s;
    }
    .user-nav a:hover { background: #e2e8f0; color: #0f172a; }
    .user-nav a.active { background: #10b981; color: #fff; border-color: #10b981; }
</style>
<div class="user-nav">
    <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">🚲 Sewa Sepeda</a>
    <a href="/profile" class="{{ request()->is('profile') ? 'active' : '' }}">👤 Profil Saya</a>
    <a href="/panduan" class="{{ request()->is('panduan') ? 'active' : '' }}">📖 Panduan Cara Sewa</a>
    <a href="/syarat-ketentuan" class="{{ request()->is('syarat-ketentuan') ? 'active' : '' }}">📃 Syarat & Ketentuan</a>
</div>
