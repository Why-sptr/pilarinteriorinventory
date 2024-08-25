<?php

namespace App\Http\Controllers;

use App\Models\JenisBarang;
use Illuminate\Http\Request;

class JenisBarangController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $jenisBarang = JenisBarang::where('jenis', 'LIKE', "%{$query}%")
                ->orderBy('created_at', 'DESC')
                ->paginate(5);
        } else {
            $jenisBarang = JenisBarang::orderBy('created_at', 'DESC')
                ->paginate(5);
        }

        return view('jenisbarang', compact('jenisBarang', 'query'));
    }

    public function create()
    {
        return view('admin.tambahjenisbarang');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|string|max:255',
        ], [
            'jenis.required' => 'Jenis barang harus diisi.',
        ]);

        JenisBarang::create($request->all());
        return redirect()->route('jenis-barang')->with('success', 'Jenis Barang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jenisBarang = JenisBarang::findOrFail($id);

        return view('admin.editjenisbarang', compact('jenisBarang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis' => 'required|string|max:255',
        ], [
            'jenis.required' => 'Jenis barang harus diisi.',
        ]);

        $jenisBarang = JenisBarang::findOrFail($id);

        $jenisBarang->jenis = $request->jenis;
        $jenisBarang->save();

        return redirect()->route('jenis-barang')->with('success', 'Jenis Barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jenisBarang = JenisBarang::findOrFail($id);

        $jenisBarang->delete();

        return redirect()->route('jenis-barang')->with('warning', 'Jenis Barang berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $jenisBarang = JenisBarang::where('jenis', 'LIKE', '%' . $query . '%')->get();
        return response()->json($jenisBarang);
    }
}
