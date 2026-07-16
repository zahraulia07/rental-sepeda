@php
    $userMenuItems = [
        ['url' => '/dashboard', 'match' => 'dashboard', 'icon' => '🚲', 'label' => 'Sewa Sepeda'],
        ['url' => '/profile', 'match' => 'profile', 'icon' => '👤', 'label' => 'Profil Saya'],
        ['url' => '/panduan', 'match' => 'panduan', 'icon' => '📖', 'label' => 'Panduan Cara Sewa'],
        ['url' => '/syarat-ketentuan', 'match' => 'syarat-ketentuan', 'icon' => '📃', 'label' => 'Syarat & Ketentuan'],
    ];
    $userCurrentItem = collect($userMenuItems)->first(fn($item) => request()->is($item['match']));
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
        background: linear-gradient(135deg, #10b981, #06b6d4); color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 15px; font-weight: 900; line-height: 1; letter-spacing: -1px;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
        transition: transform 0.2s ease;
    }
    .nav-menu-wrap.open .kebab { transform: rotate(90deg); }

    .nav-menu-dropdown {
        position: absolute; top: calc(100% + 10px); left: 0; z-index: 60;
        min-width: 240px; background: #fff; border: 1px solid #eef2f7; border-radius: 18px;
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
        background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
        color: #fff; box-shadow: 0 6px 14px rgba(16, 185, 129, 0.3);
    }
    .nav-menu-dropdown .menu-icon { font-size: 15px; width: 20px; text-align: center; flex-shrink: 0; }
</style>

<div class="nav-menu-wrap" id="userNavWrap">
    <div class="nav-menu-trigger" onclick="toggleUserNav(event)">
        <span class="current-icon">{{ $userCurrentItem['icon'] ?? '📋' }}</span>
        <span class="current-label">{{ $userCurrentItem['label'] ?? 'Menu' }}</span>
        <span class="kebab">⋮</span>
    </div>
    <div class="nav-menu-dropdown" id="userNavDropdown">
        @foreach($userMenuItems as $item)
            <a href="{{ $item['url'] }}" class="{{ request()->is($item['match']) ? 'active' : '' }}">
                <span class="menu-icon">{{ $item['icon'] }}</span> {{ $item['label'] }}
            </a>
        @endforeach
    </div>
</div>

<script>
    function toggleUserNav(event) {
        event.stopPropagation();
        document.getElementById('userNavWrap').classList.toggle('open');
    }
    document.addEventListener('click', function (event) {
        const wrap = document.getElementById('userNavWrap');
        if (wrap && !wrap.contains(event.target)) {
            wrap.classList.remove('open');
        }
    });
</script>
