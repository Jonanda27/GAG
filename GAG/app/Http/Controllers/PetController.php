<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use Exception;
use finfo;

class PetController extends Controller
{
    public function create()
    {
        return view('admin.pet.create');
    }

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

            return view('admin.app', compact('pets'));
        } catch (Exception $e) {
            Log::error("Error in index(): " . $e->getMessage());
            return back()->with('error', 'Gagal memuat data pet.');
        }
    }

    public function edit($id)
    {
        $pet = Pet::findOrFail($id);
        return view('admin.pet.edit', compact('pet'));
    }

    public function update(Request $request, $id)
    {
        try {
            $pet = Pet::findOrFail($id);

            // Validasi input
            $request->validate([
                'nama' => 'required|string|max:255',
                'harga' => 'required|numeric',
                'stok' => 'required|integer',
                'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
            ]);

            // Update data teks
            $pet->nama = $request->nama;
            $pet->harga = $request->harga;
            $pet->stok = $request->stok;

            // Jika ada gambar baru, update kolom gambar
            if ($request->hasFile('gambar')) {
                $pet->gambar = file_get_contents($request->file('gambar')->getRealPath());
            }

            $pet->save();

            return redirect()->route('admin.app')->with('success', 'Pet berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error("Error updating pet: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data pet.');
        }
    }


    public function destroy($id)
    {
        $pet = Pet::findOrFail($id);
        $pet->delete();

        return redirect()->route('admin.app')->with('success', 'Pet berhasil dihapus.');
    }

    public function sold($id)
    {
        $pet = Pet::findOrFail($id);
        $pet->status = 'sold';
        $pet->save();

        return redirect()->route('admin.app')->with('success', 'Pet berhasil ditandai sebagai terjual.');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required',
                'harga' => 'required|numeric',
                'stok' => 'required|integer',
                'gambar' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048'
            ]);

            // Ambil file gambar
            $file = $request->file('gambar');

            // Pastikan file valid
            if (!$file->isValid()) {
                return back()->withInput()->with('error', 'File gambar tidak valid.');
            }

            // Simpan binary gambar langsung ke database
            $gambarBinary = file_get_contents($file->getRealPath());

            Pet::create([
                'nama' => $request->nama,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'gambar' => $gambarBinary
            ]);

            return redirect()->route('admin.pet.create')
                            ->with('success', 'Pet berhasil ditambahkan!');
        } catch (Exception $e) {
            \Log::error("Error in store(): " . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menambahkan pet.');
        }
    }
}
