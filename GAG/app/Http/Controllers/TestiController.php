<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testi;

class TestiController extends Controller
{
    public function create()
    {
        return view('admin.testi');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Simpan gambar ke storage/public/testi
        $path = $request->file('gambar')->store('testi', 'public');

        // Simpan path gambar ke database
        Testi::create([
            'gambar' => $path
        ]);

        return redirect()->route('admin.app')->with('success', 'Testimoni berhasil diupload!');
    }
}
