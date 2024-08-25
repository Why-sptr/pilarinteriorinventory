<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use App\Models\JenisBarang;
use App\Models\Vendor;
use Illuminate\Http\Request;

class DataBarangController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $dataBarang = DataBarang::with(['jenisBarang', 'vendor'])
                ->where('nama_barang', 'LIKE', "%{$query}%")
                ->orWhereHas('jenisBarang', function ($q) use ($query) {
                    $q->where('jenis', 'LIKE', "%{$query}%");
                })
                ->orWhereHas('vendor', function ($q) use ($query) {
                    $q->where('nama', 'LIKE', "%{$query}%");
                })
                ->orderBy('created_at', 'DESC')
                ->paginate(5);
        } else {
            $dataBarang = DataBarang::with(['jenisBarang', 'vendor'])
                ->orderBy('created_at', 'DESC')
                ->paginate(5);
        }

        return view('databarang', compact('dataBarang', 'query'));
    }

    public function create()
    {
        $jenisBarang = JenisBarang::all();
        $vendors = Vendor::orderBy('created_at', 'DESC')->get();
        return view('admin.tambahdatabarang', ['jenisBarang' => $jenisBarang, 'vendors' => $vendors]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'jenis_barang_id' => 'required|exists:jenis_barang,id',
            'vendor_id' => 'required|exists:vendors,id',
            'nama_barang' => 'required|string|max:255',
            'harga_barang' => 'required|numeric|min:0',
            'stok_barang' => 'required|integer|min:0',
        ], [
            'jenis_barang_id.required' => 'Jenis barang harus dipilih.',
            'jenis_barang_id.exists' => 'Jenis barang yang dipilih tidak valid.',
            'vendor_id.required' => 'Vendor harus dipilih.',
            'vendor_id.exists' => 'Vendor yang dipilih tidak valid.',
            'nama_barang.required' => 'Nama barang harus diisi.',
            'harga_barang.required' => 'Harga barang harus diisi.',
            'harga_barang.numeric' => 'Harga barang harus berupa angka.',
            'stok_barang.required' => 'Jumlah barang harus diisi.',
            'stok_barang.integer' => 'Jumlah barang harus berupa angka bulat.',
        ]);

        DataBarang::create($validatedData);
        return redirect()->route('data-barang')->with('success', 'Data Barang berhasil ditambahkan.');
    }

    public function searchJenisBarang(Request $request)
    {
        $query = $request->input('query');
        $jenisBarang = JenisBarang::where('jenis', 'like', "%{$query}%")->get();
        return response()->json($jenisBarang);
    }


    public function edit($id)
    {
        $dataBarang = DataBarang::findOrFail($id);
        $jenisBarang = JenisBarang::all();
        $vendors = Vendor::orderBy('created_at', 'DESC')->get();
        return view('admin.editdatabarang', compact('dataBarang', 'jenisBarang', 'vendors'));
    }

    public function update(Request $request, $id)
    {
        $dataBarang = DataBarang::findOrFail($id);

        $request->validate([
            'jenis_barang_id' => 'required|exists:jenis_barang,id',
            'vendor_id' => 'required|exists:vendors,id',
            'nama_barang' => 'required|string|max:255',
            'harga_barang' => 'required|numeric|min:0',
            'stok_barang' => 'required|integer|min:0',
        ], [
            'jenis_barang_id.required' => 'Jenis barang harus dipilih.',
            'jenis_barang_id.exists' => 'Jenis barang yang dipilih tidak valid.',
            'vendor_id.required' => 'Vendor harus dipilih.',
            'vendor_id.exists' => 'Vendor yang dipilih tidak valid.',
            'nama_barang.required' => 'Nama barang harus diisi.',
            'harga_barang.required' => 'Harga barang harus diisi.',
            'harga_barang.numeric' => 'Harga barang harus berupa angka.',
            'stok_barang.required' => 'Jumlah barang harus diisi.',
            'stok_barang.integer' => 'Jumlah barang harus berupa angka bulat.',
        ]);

        $dataBarang->update([
            'nama_barang' => $request->nama_barang,
            'jenis_barang_id' => $request->jenis_barang_id,
            'harga_barang' => $request->harga_barang,
            'stok_barang' => $request->stok_barang,
        ]);

        return redirect()->route('data-barang')->with('success', 'Data Barang berhasil diupdate.');
    }

    public function destroy($id)
    {
        $dataBarang = DataBarang::findOrFail($id);

        $dataBarang->delete();

        return redirect()->route('data-barang')->with('warning', 'Data Barang berhasil dihapus.');
    }
}
