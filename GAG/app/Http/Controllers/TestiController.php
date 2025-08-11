<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testi;
use Exception;
use finfo;


class TestiController extends Controller
{
    public function create()
    {
        return view('admin.testi');
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        // Ambil file gambar
            $file = $request->file('gambar');

            // Pastikan file valid
            if (!$file->isValid()) {
                return back()->withInput()->with('error', 'File gambar tidak valid.');
            }

            // Simpan binary gambar langsung ke database
            $gambarBinary = file_get_contents($file->getRealPath());

        // Simpan path gambar ke database
        Testi::create([
            'gambar' => $gambarBinary
        ]);
        return redirect()->route('admin.app')->with('success', 'Testimoni berhasil diupload!');

        } catch (Exception $e) {
            \Log::error("Error in store(): " . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menambahkan Testimoni.');
        }
    }
}
