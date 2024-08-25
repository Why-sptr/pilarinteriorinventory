<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DataBarang;
use App\Models\Pengajuan;
use App\Models\StokCustomer;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $pengajuan = Pengajuan::with(['customer', 'dataBarang'])
                ->whereHas('customer', function ($q) use ($query) {
                    $q->where('nama', 'LIKE', "%{$query}%");
                })
                ->orWhereHas('dataBarang', function ($q) use ($query) {
                    $q->where('nama_barang', 'LIKE', "%{$query}%");
                })
                ->orderBy('created_at', 'DESC')
                ->paginate(10);
        } else {
            $pengajuan = Pengajuan::with(['customer', 'dataBarang'])
                ->orderBy('created_at', 'DESC')
                ->paginate(10);
        }

        return view('pengajuan', compact('pengajuan', 'query'));
    }

    public function create()
    {
        $customers = Customer::orderBy('created_at', 'DESC')->get();
        $dataBarang = DataBarang::with('vendor')->orderBy('created_at', 'DESC')->get();

        return view('admin.tambahpengajuan', compact('customers', 'dataBarang'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'data_barang_id' => 'required|exists:data_barang,id',
            'tanggal_pengajuan' => 'required|date',
            'biaya' => 'required|numeric|min:0',
            'status' => 'required|in:diajukan,disetujui,ditolak',
            'jumlah' => 'required|integer|min:0',
        ], [
            'customer_id.required' => 'Customer harus dipilih.',
            'customer_id.exists' => 'Customer yang dipilih tidak valid.',
            
            'data_barang_id.required' => 'Data barang harus dipilih.',
            'data_barang_id.exists' => 'Data barang yang dipilih tidak valid.',
            
            'tanggal_pengajuan.required' => 'Tanggal pengajuan harus diisi.',
            'tanggal_pengajuan.date' => 'Tanggal pengajuan harus berupa tanggal yang valid.',
            
            'biaya.required' => 'Biaya harus diisi.',
            'biaya.numeric' => 'Biaya harus berupa angka.',
            'biaya.min' => 'Biaya tidak boleh kurang dari 0.',
            
            'status.required' => 'Status harus dipilih.',
            'status.in' => 'Status harus berupa salah satu dari: diajukan, disetujui, ditolak.',
            
            'jumlah.required' => 'Jumlah harus diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka bulat.',
            'jumlah.min' => 'Jumlah tidak boleh kurang dari 0.',
        ]);        

        Pengajuan::create($validated);

        return redirect()->route('pengajuan')->with('success', 'Pengajuan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $customers = Customer::orderBy('created_at', 'DESC')->get();
        $dataBarang = DataBarang::with('vendor')->orderBy('created_at', 'DESC')->get();

        return view('admin.editpengajuan', compact('pengajuan', 'customers', 'dataBarang'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'data_barang_id' => 'required|exists:data_barang,id',
            'tanggal_pengajuan' => 'required|date',
            'biaya' => 'required|numeric|min:0',
            'jumlah' => 'required|integer|min:0',
        ], [
            'customer_id.required' => 'Customer harus dipilih.',
            'customer_id.exists' => 'Customer yang dipilih tidak valid.',
            
            'data_barang_id.required' => 'Data barang harus dipilih.',
            'data_barang_id.exists' => 'Data barang yang dipilih tidak valid.',
            
            'tanggal_pengajuan.required' => 'Tanggal pengajuan harus diisi.',
            'tanggal_pengajuan.date' => 'Tanggal pengajuan harus berupa tanggal yang valid.',
            
            'biaya.required' => 'Biaya harus diisi.',
            'biaya.numeric' => 'Biaya harus berupa angka.',
            'biaya.min' => 'Biaya tidak boleh kurang dari 0.',
            
            'jumlah.required' => 'Jumlah harus diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka bulat.',
            'jumlah.min' => 'Jumlah tidak boleh kurang dari 0.',
        ]);        

        $pengajuan = Pengajuan::findOrFail($id);

        $pengajuan->update($validated);

        return redirect()->route('pengajuan')->with('success', 'Pengajuan berhasil diperbarui.');
    }
    public function editfinance($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $customers = Customer::orderBy('created_at', 'DESC')->get();
        $dataBarang = DataBarang::with('vendor')->orderBy('created_at', 'DESC')->get();

        return view('admin.editpengajuanfinance', compact('pengajuan', 'customers', 'dataBarang'));
    }

    public function updatefinance(Request $request, $id)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'data_barang_id' => 'required|exists:data_barang,id',
            'tanggal_pengajuan' => 'required|date',
            'biaya' => 'required|numeric|min:0',
            'status' => 'required|in:diajukan,disetujui,ditolak',
            'jumlah' => 'required|integer|min:0',
            'bukti_tf' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'customer_id.required' => 'Customer harus dipilih.',
            'customer_id.exists' => 'Customer yang dipilih tidak valid.',
            
            'data_barang_id.required' => 'Data barang harus dipilih.',
            'data_barang_id.exists' => 'Data barang yang dipilih tidak valid.',
            
            'tanggal_pengajuan.required' => 'Tanggal pengajuan harus diisi.',
            'tanggal_pengajuan.date' => 'Tanggal pengajuan harus berupa tanggal yang valid.',
            
            'biaya.required' => 'Biaya harus diisi.',
            'biaya.numeric' => 'Biaya harus berupa angka.',
            'biaya.min' => 'Biaya tidak boleh kurang dari 0.',
            
            'status.required' => 'Status harus dipilih.',
            'status.in' => 'Status harus berupa salah satu dari: diajukan, disetujui, ditolak.',
            
            'jumlah.required' => 'Jumlah harus diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka bulat.',
            'jumlah.min' => 'Jumlah tidak boleh kurang dari 0.',
            
            'bukti_tf.image' => 'Bukti transfer harus berupa gambar.',
            'bukti_tf.mimes' => 'Bukti transfer harus berformat jpeg, png, jpg, atau gif.',
            'bukti_tf.max' => 'Bukti transfer tidak boleh lebih dari 2 MB.',
        ]);        

        $pengajuan = Pengajuan::findOrFail($id);

    if ($request->hasFile('bukti_tf')) {
        if ($pengajuan->bukti_tf) {
            $oldImagePath = public_path('assets/images/bukti_tf/' . $pengajuan->bukti_tf);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        $image = $request->file('bukti_tf');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('assets/images/bukti_tf'), $imageName);
        $validated['bukti_tf'] = $imageName;
    }

    // Cek perubahan status
    $oldStatus = $pengajuan->status;

    $pengajuan->update($validated);

    // Jika status diubah menjadi "disetujui"
    if ($validated['status'] == 'disetujui' && $oldStatus != 'disetujui') {
        // Tambahkan transaksi masuk
        Transaksi::create([
            'data_barang_id' => $pengajuan->data_barang_id,
            'customer_id' => $pengajuan->customer_id,
            'jumlah' => $pengajuan->jumlah,
            'status' => 'masuk',
            'tanggal_transaksi' => $pengajuan->tanggal_pengajuan,
        ]);

        // Update stok barang
        $dataBarang = DataBarang::findOrFail($pengajuan->data_barang_id);
        $dataBarang->stok_barang += $pengajuan->jumlah;
        $dataBarang->save();

        // Update stok customer
        $stokCustomer = StokCustomer::firstOrNew([
            'data_barang_id' => $pengajuan->data_barang_id,
            'customer_id' => $pengajuan->customer_id,
        ]);
        $stokCustomer->jumlah += $pengajuan->jumlah;
        $stokCustomer->save();

        } elseif ($validated['status'] == 'ditolak' && $oldStatus == 'disetujui') {
            // Hapus transaksi masuk jika status berubah menjadi "ditolak"
            $transaksi = Transaksi::where('data_barang_id', $pengajuan->data_barang_id)
                ->where('customer_id', $pengajuan->customer_id)
                ->where('status', 'masuk')
                ->first();

            if ($transaksi) {
                // Update stok barang
                $dataBarang = DataBarang::findOrFail($pengajuan->data_barang_id);
                $dataBarang->stok_barang -= $transaksi->jumlah;
                $dataBarang->save();

                // Update stok customer
                $stokCustomer = StokCustomer::where('data_barang_id', $pengajuan->data_barang_id)
                    ->where('customer_id', $pengajuan->customer_id)
                    ->first();
                if ($stokCustomer) {
                    $stokCustomer->jumlah -= $transaksi->jumlah;
                    $stokCustomer->save();
                }

                // Hapus transaksi
                $transaksi->delete();
            }
        }

        return redirect()->route('pengajuan')->with('success', 'Pengajuan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        $pengajuan->delete();

        return redirect()->route('pengajuan')->with('warning', 'Pengajuan berhasil dihapus.');
    }
}
