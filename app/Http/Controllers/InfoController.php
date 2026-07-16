<?php

namespace App\Http\Controllers;

class InfoController extends Controller
{
    // Halaman Syarat & Ketentuan penyewaan
    public function syaratKetentuan()
    {
        return view('user.syarat-ketentuan');
    }

    // Halaman Panduan Cara Menyewa
    public function panduan()
    {
        return view('user.panduan');
    }

    // Halaman Tentang Kami
    public function tentangKami()
    {
        return view('user.tentang-kami');
    }
}
