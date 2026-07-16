<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Setiap kali partial sidebar admin dirender (di semua halaman admin),
        // otomatis suplai daftar notifikasi + jumlah belum dibaca untuk lonceng.
        View::composer('partials.admin-sidebar', function ($view) {
            $daftarNotifikasiAdmin = collect();
            $jumlahNotifBelumDibacaAdmin = 0;

            if (Auth::check() && Auth::user()->role === 'admin') {
                $daftarNotifikasiAdmin = DB::table('notifikasis')
                    ->where('user_id', Auth::id())
                    ->orderByDesc('created_at')
                    ->limit(10)
                    ->get();

                // Badge dihitung per TRANSAKSI (id_penyewaan) yang belum dibaca,
                // bukan jumlah baris notifikasi mentah (1 transaksi bisa punya 2+ notif).
                $jumlahNotifBelumDibacaAdmin = DB::table('notifikasis')
                    ->where('user_id', Auth::id())
                    ->where('dibaca', false)
                    ->pluck('id_penyewaan')
                    ->unique()
                    ->count();
            }

            $view->with([
                'daftarNotifikasiAdmin' => $daftarNotifikasiAdmin,
                'jumlahNotifBelumDibacaAdmin' => $jumlahNotifBelumDibacaAdmin,
            ]);
        });
    }
}
