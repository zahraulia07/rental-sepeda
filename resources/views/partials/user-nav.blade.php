<style>
    .user-nav {
        display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 24px;
        padding: 8px; background: #f8fafc; border-radius: 18px; border: 1px solid #eef2f7;
    }
    .user-nav a {
        text-decoration: none; font-size: 13.5px; font-weight: 700; color: #64748b;
        background: transparent; padding: 10px 18px; border-radius: 14px; border: 1px solid transparent;
        transition: all 0.2s ease; letter-spacing: 0.1px;
    }
    .user-nav a:hover { background: #ffffff; color: #0f172a; box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06); }
    .user-nav a.active {
        background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
        color: #fff; border-color: transparent;
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35);
    }
</style>
<div class="user-nav">
    <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">🚲 Sewa Sepeda</a>
    <a href="/profile" class="{{ request()->is('profile') ? 'active' : '' }}">👤 Profil Saya</a>
    <a href="/panduan" class="{{ request()->is('panduan') ? 'active' : '' }}">📖 Panduan Cara Sewa</a>
    <a href="/syarat-ketentuan" class="{{ request()->is('syarat-ketentuan') ? 'active' : '' }}">📃 Syarat & Ketentuan</a>
</div>
