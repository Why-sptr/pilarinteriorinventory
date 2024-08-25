<?php

namespace App\Http\Controllers;

use App\Models\KategoriKlasifikasi;
use Illuminate\Http\Request;

class KategoriKlasifikasiController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $kategoriKlasifikasi = KategoriKlasifikasi::where('kategori', 'LIKE', "%{$query}%")->paginate(5);
        } else {
            $kategoriKlasifikasi = KategoriKlasifikasi::paginate(5);
        }

        return view('kategori', compact('kategoriKlasifikasi', 'query'));
    }

    public function create()
    {
        return view('admin.tambahkategori');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:255',
        ], [
            'kategori.required' => 'Kategori harus diisi.',
        ]);

        KategoriKlasifikasi::create($request->all());
        return redirect()->route('kategori')->with('success', 'Kategori Klasifikasi berhasi ditambahkan.');
    }


    public function edit($id)
    {
        $kategoriKlasifikasi = KategoriKlasifikasi::findOrFail($id);
        return view('admin.editkategori', compact('kategoriKlasifikasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori' => 'required|string|max:255',
        ], [
            'kategori.required' => 'Kategori harus diisi.',
        ]);

        $kategoriKlasifikasi = KategoriKlasifikasi::findOrFail($id);
        $kategoriKlasifikasi->update($request->all());
        return redirect()->route('kategori')->with('success', 'Kategori Klasifikasi berhasil diupdate.');
    }

    public function destroy($id)
    {
        $kategoriKlasifikasi = KategoriKlasifikasi::findOrFail($id);
        $kategoriKlasifikasi->delete();
        return redirect()->route('kategori')->with('warning', 'Kategori Klasifikasi berhasil dihapus.');
    }
}
