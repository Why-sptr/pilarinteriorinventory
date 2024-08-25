<?php

namespace App\Http\Controllers;

use App\Models\BiayaOperasional;
use Illuminate\Http\Request;

class BiayaOperasionalController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $biayaOperasional = BiayaOperasional::where('nama_biaya', 'LIKE', "%{$query}%")
                ->orderBy('created_at', 'DESC')
                ->paginate(5);
        } else {
            $biayaOperasional = BiayaOperasional::orderBy('created_at', 'DESC')
                ->paginate(5);
        }

        return view('biayaoperasional', compact('biayaOperasional', 'query'));
    }

    public function create()
    {
        return view('admin.tambahbiayaoperasional');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_biaya' => 'required|string|max:255',
            'biaya' => 'required|numeric',
        ], [
            'nama_biaya.required' => 'Nama biaya harus diisi.',
            'biaya.required' => 'Biaya harus diisi.',
            'biaya.numeric' => 'Biaya harus berupa angka.',
        ]);

        BiayaOperasional::create($request->all());
        return redirect()->route('biaya-operasional')->with('success', 'Biaya Operasional berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $biayaOperasional = BiayaOperasional::findOrFail($id);

        return view('admin.editbiayaoperasional', compact('biayaOperasional'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_biaya' => 'required|string|max:255',
            'biaya' => 'required|numeric',
        ], [
            'nama_biaya.required' => 'Nama biaya harus diisi.',
            'biaya.required' => 'Biaya harus diisi.',
            'biaya.numeric' => 'Biaya harus berupa angka.',
        ]);

        $biayaOperasional = BiayaOperasional::findOrFail($id);

        $biayaOperasional->nama_biaya = $request->nama_biaya;
        $biayaOperasional->biaya = $request->biaya;
        $biayaOperasional->save();

        return redirect()->route('biaya-operasional')->with('success', 'Biaya Operasional berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $biayaOperasional = BiayaOperasional::findOrFail($id);

        $biayaOperasional->delete();

        return redirect()->route('biaya-operasional')->with('warning', 'Biaya Operasional berhasil dihapus.');
    }
}

