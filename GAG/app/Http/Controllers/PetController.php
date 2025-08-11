<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;

class PetController extends Controller
{
    public function create()
    {
        return view('admin.pet.create');
    }

    public function index()
{
    $pets = Pet::all(); // Ambil semua data pets
    return view('admin.app', compact('pets')); // kirim ke view
}

public function edit($id)
{
    $pet = Pet::findOrFail($id);
    return view('admin.pet.edit', compact('pet'));
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
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Upload gambar
        $path = $request->file('gambar')->store('pets', 'public');

        Pet::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar' => $path
        ]);

        return redirect()->route('admin.pet.create')->with('success', 'Pet berhasil ditambahkan!');
    }
}
