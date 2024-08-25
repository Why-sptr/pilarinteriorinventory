<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\StokCustomer;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $customers = Customer::with('user')
                ->where('nama', 'LIKE', "%{$query}%")
                ->orderBy('created_at', 'DESC')
                ->paginate(5);
        } else {
            $customers = Customer::with('user')
                ->orderBy('created_at', 'DESC')
                ->paginate(5);
        }

        return view('customer', compact('customers', 'query'));
    }
    public function create()
    {
        return view('admin.tambahcustomer');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'dana' => 'required|numeric|min:0',
            'project' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
        ], [
            'nama.required' => 'Nama customer harus diisi.',
            'nama.string' => 'Nama customer harus berupa teks.',
            'nama.max' => 'Nama customer tidak boleh lebih dari 255 karakter.',

            'dana.required' => 'Dana harus diisi.',
            'dana.numeric' => 'Dana harus berupa angka.',
            'dana.min' => 'Dana tidak boleh kurang dari 0.',

            'project.required' => 'Nama proyek harus diisi.',
            'project.string' => 'Nama proyek harus berupa teks.',
            'project.max' => 'Nama proyek tidak boleh lebih dari 255 karakter.',

            'alamat.required' => 'Alamat harus diisi.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'alamat.max' => 'Alamat tidak boleh lebih dari 255 karakter.',

            'telepon.required' => 'Nomor telepon harus diisi.',
            'telepon.string' => 'Nomor telepon harus berupa teks.',
            'telepon.max' => 'Nomor telepon tidak boleh lebih dari 15 karakter.',
        ]);

        $customer = new Customer();
        $customer->nama = $request->input('nama');
        $customer->dana = $request->input('dana');
        $customer->project = $request->input('project');
        $customer->alamat = $request->input('alamat');
        $customer->telepon = $request->input('telepon');
        $customer->user_id = Auth::id();
        $customer->save();

        return redirect()->route('customer')->with('success', 'Customer berhasil ditambahkan.');
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);

        $stokCustomer = StokCustomer::with(['dataBarang'])
            ->where('customer_id', $id)
            ->get();

        $biayaDipakai = 0;
        foreach ($stokCustomer as $stok) {
            $jumlahKeluar = Transaksi::where('customer_id', $id)
                ->where('data_barang_id', $stok->data_barang_id)
                ->where('status', 'keluar')
                ->sum('jumlah');
            $biayaDipakai += $jumlahKeluar * $stok->dataBarang->harga_barang;
        }

        $dana = $customer->dana;
        $grossProfit = $dana - $biayaDipakai;

        return view('admin.detailcustomer', compact('customer', 'stokCustomer', 'biayaDipakai', 'grossProfit'));
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.editcustomer', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'dana' => 'required|numeric|min:0',
            'project' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'status' => 'required|in:diproses,selesai',
        ], [
            'nama.required' => 'Nama customer harus diisi.',
            'nama.string' => 'Nama customer harus berupa teks.',
            'nama.max' => 'Nama customer tidak boleh lebih dari 255 karakter.',
            
            'dana.required' => 'Dana harus diisi.',
            'dana.numeric' => 'Dana harus berupa angka.',
            'dana.min' => 'Dana tidak boleh kurang dari 0.',
            
            'project.required' => 'Nama proyek harus diisi.',
            'project.string' => 'Nama proyek harus berupa teks.',
            'project.max' => 'Nama proyek tidak boleh lebih dari 255 karakter.',
            
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'alamat.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
            
            'telepon.required' => 'Nomor telepon harus diisi.',
            'telepon.string' => 'Nomor telepon harus berupa teks.',
            'telepon.max' => 'Nomor telepon tidak boleh lebih dari 15 karakter.',
            
            'status.required' => 'Status harus dipilih.',
            'status.in' => 'Status harus berupa salah satu dari: diproses, selesai.',
        ]);        

        $customer = Customer::findOrFail($id);
        $customer->nama = $request->input('nama');
        $customer->dana = $request->input('dana');
        $customer->project = $request->input('project');
        $customer->alamat = $request->input('alamat');
        $customer->telepon = $request->input('telepon');
        $customer->status = $request->input('status');
        $customer->user_id = Auth::id();
        $customer->save();

        return redirect()->route('customer')->with('success', 'Customer berhasil diupdate.');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        $customer->delete();

        return redirect()->route('customer')->with('warning', 'Customer berhasil dihapus.');
    }

    public function exportPdf($id)
    {
        $customer = Customer::findOrFail($id);
        $stokCustomer = StokCustomer::with(['dataBarang'])
            ->where('customer_id', $id)
            ->get();

        $biayaDipakai = 0;
        foreach ($stokCustomer as $stok) {
            $jumlahKeluar = Transaksi::where('customer_id', $id)
                ->where('data_barang_id', $stok->data_barang_id)
                ->where('status', 'keluar')
                ->sum('jumlah');
            $biayaDipakai += $jumlahKeluar * $stok->dataBarang->harga_barang;
        }

        $dana = $customer->dana;
        $grossProfit = $dana - $biayaDipakai;

        $pdf = Pdf::loadView('pdf.detailcustomer', compact('customer', 'stokCustomer', 'biayaDipakai', 'grossProfit', 'dana'));
        return $pdf->download('detail_customer_' . $customer->id . '.pdf');
    }
}
