<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $vendorsQuery = Vendor::orderBy('created_at', 'DESC');

        if ($query) {
            $vendorsQuery->where(function ($q) use ($query) {
                $q->where('nama', 'LIKE', "%{$query}%")
                    ->orWhere('telepon', 'LIKE', "%{$query}%")
                    ->orWhere('alamat', 'LIKE', "%{$query}%");
            });
        }

        $vendors = $vendorsQuery->paginate(5);

        return view('vendor', compact('vendors', 'query'));
    }

    public function create()
    {
        return view('admin.tambahvendor');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
        ], [
            'nama.required' => 'Nama vendor harus diisi.',
            'telepon.required' => 'Telepon vendor harus diisi.',
            'alamat.required' => 'Alamat vendor harus diisi.',
        ]);

        Vendor::create($request->all());
        return redirect()->route('vendor')->with('success', 'Vendor berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('admin.editvendor', compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
        ], [
            'nama.required' => 'Nama vendor harus diisi.',
            'telepon.required' => 'Telepon vendor harus diisi.',
            'alamat.required' => 'Alamat vendor harus diisi.',
        ]);

        $vendor = Vendor::findOrFail($id);

        $vendor->nama = $request->nama;
        $vendor->telepon = $request->telepon;
        $vendor->alamat = $request->alamat;
        $vendor->save();

        return redirect()->route('vendor')->with('success', 'Vendor berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);

        $vendor->delete();

        return redirect()->route('vendor')->with('warning', 'Vendor berhasil dihapus.');
    }
}
