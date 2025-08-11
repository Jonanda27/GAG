<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Testi;
use Exception;
use finfo;

class ShopController extends Controller
{
    public function index()
    {
        try {
            $pets = Pet::all()->map(function ($pet) {
                if ($pet->gambar) {
                    $mime = (new finfo(FILEINFO_MIME_TYPE))->buffer($pet->gambar);
                    $pet->gambar_url = "data:{$mime};base64," . base64_encode($pet->gambar);
                } else {
                    $pet->gambar_url = null;
                }
                return $pet;
            });

            $testis = Testi::all()->map(function ($testi) {
                if ($testi->gambar) {
                    $mime = (new finfo(FILEINFO_MIME_TYPE))->buffer($testi->gambar);
                    $testi->gambar_url = "data:{$mime};base64," . base64_encode($testi->gambar);
                } else {
                    $testi->gambar_url = null;
                }
                return $testi;
            });

            return view('shop.app', compact('pets', 'testis'));
        } catch (Exception $e) {
            Log::error("Error in index(): " . $e->getMessage());
            return back()->with('error', 'Gagal memuat data pet.');
        }
    }
}
