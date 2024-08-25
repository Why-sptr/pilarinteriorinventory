<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaksi;
use App\Models\DataBarang;
use App\Models\StokCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $transaksiQuery = Transaksi::with('dataBarang')
            ->orderBy('created_at', 'DESC');

        if ($query) {
            $transaksiQuery->whereHas('dataBarang', function ($q) use ($query) {
                $q->where('nama_barang', 'LIKE', "%{$query}%");
            });
        }

        $transaksi = $transaksiQuery->paginate(5);

        return view('transaksi', compact('transaksi', 'query'));
    }

    public function create()
    {
        $dataBarang = DataBarang::with('vendor')->orderBy('created_at', 'DESC')->get();
        $customers = Customer::orderBy('created_at', 'DESC')->get();
        return view('admin.tambahtransaksi', compact('dataBarang', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'data_barang_id' => 'required|exists:data_barang,id',
            'customer_id' => 'required|exists:customers,id',
            'jumlah' => 'required|integer|min:1',
            'status' => 'required|in:masuk,keluar',
            'tanggal_transaksi' => 'required|date',
        ], [
            'data_barang_id.required' => 'Nama barang harus dipilih.',
            'data_barang_id.exists' => 'Nama barang yang dipilih tidak valid.',
            'customer_id.required' => 'Customer harus dipilih.',
            'customer_id.exists' => 'Customer yang dipilih tidak valid.',
            'jumlah.required' => 'Jumlah barang harus diisi.',
            'jumlah.integer' => 'Jumlah barang harus berupa angka bulat.',
            'jumlah.min' => 'Jumlah barang harus minimal 1.',
            'status.required' => 'Status barang harus dipilih.',
            'status.in' => 'Status barang yang dipilih tidak valid.',
            'tanggal_transaksi.required' => 'Tanggal transaksi harus diisi.',
            'tanggal_transaksi.date' => 'Tanggal transaksi tidak valid.',
        ]);

        $dataBarang = DataBarang::findOrFail($request->data_barang_id);

        // Buat transaksi baru
        $transaksi = Transaksi::create([
            'data_barang_id' => $request->data_barang_id,
            'customer_id' => $request->customer_id,
            'jumlah' => $request->jumlah,
            'status' => $request->status,
            'tanggal_transaksi' => $request->tanggal_transaksi,
        ]);

        if ($request->status == 'masuk') {
            // Tambahkan stok jika transaksi masuk
            $dataBarang->stok_barang += $request->jumlah;
        } elseif ($request->status == 'keluar') {
            // Kurangi stok jika transaksi keluar
            if ($dataBarang->stok_barang < $request->jumlah) {
                return redirect()->route('transaksi.create')->with('error', 'Stok tidak mencukupi untuk transaksi keluar.');
            }

            $dataBarang->stok_barang -= $request->jumlah;

            // Update stok customer
            $stokCustomer = StokCustomer::where('data_barang_id', $request->data_barang_id)
                ->where('customer_id', $request->customer_id)
                ->first();

            if ($stokCustomer) {
                $stokCustomer->jumlah -= $request->jumlah;

                // Jika stok customer mencapai 0, hapus data stok
                if ($stokCustomer->jumlah <= 0) {
                    $stokCustomer->delete();
                } else {
                    $stokCustomer->save();
                }
            } else {
                // Jika stok customer belum ada, tambahkan data stok customer dengan jumlah 0
                StokCustomer::create([
                    'data_barang_id' => $request->data_barang_id,
                    'customer_id' => $request->customer_id,
                    'jumlah' => 0,
                ]);
            }
        }

        $dataBarang->save();

        return redirect()->route('transaksi')->with('success', 'Transaksi berhasil disimpan.');
    }


    public function show(Transaksi $transaksi)
    {
        return view('transaksi.show', compact('transaksi'));
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $dataBarang = DataBarang::with('vendor')->orderBy('created_at', 'DESC')->get();
        $customers = Customer::orderBy('created_at', 'DESC')->get();

        return view('admin.edittransaksi', compact('transaksi', 'dataBarang', 'customers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'data_barang_id' => 'required|exists:data_barang,id',
            'customer_id' => 'required|exists:customers,id',
            'jumlah' => 'required|integer|min:1',
            'status' => 'required|in:masuk,keluar',
            'tanggal_transaksi' => 'required|date',
        ], [
            'data_barang_id.required' => 'Nama barang harus dipilih.',
            'data_barang_id.exists' => 'Nama barang yang dipilih tidak valid.',
            'customer_id.required' => 'Customer harus dipilih.',
            'customer_id.exists' => 'Customer yang dipilih tidak valid.',
            'jumlah.required' => 'Jumlah barang harus diisi.',
            'jumlah.integer' => 'Jumlah barang harus berupa angka bulat.',
            'jumlah.min' => 'Jumlah barang harus minimal 1.',
            'status.required' => 'Status barang harus dipilih.',
            'status.in' => 'Status barang yang dipilih tidak valid.',
            'tanggal_transaksi.required' => 'Tanggal transaksi harus diisi.',
            'tanggal_transaksi.date' => 'Tanggal transaksi tidak valid.',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $dataBarang = DataBarang::findOrFail($request->data_barang_id);
        $customerId = $request->customer_id;

        $statusSebelumnya = $transaksi->status;
        $jumlahSebelumnya = $transaksi->jumlah;

        // Update transaksi
        $transaksi->data_barang_id = $request->data_barang_id;
        $transaksi->customer_id = $customerId;
        $transaksi->jumlah = $request->jumlah;
        $transaksi->status = $request->status;
        $transaksi->tanggal_transaksi = $request->tanggal_transaksi;
        $transaksi->save();

        // Update stok
        $this->updateStok($dataBarang, $statusSebelumnya, $jumlahSebelumnya, $request->status, $request->jumlah, $customerId);

        return redirect()->route('transaksi')->with('success', 'Transaksi berhasil diupdate.');
    }

    private function updateStok(DataBarang $dataBarang, $statusSebelumnya, $jumlahSebelumnya, $statusBaru, $jumlahBaru, $customerId)
    {
        // Update stok data barang
        if ($statusSebelumnya === 'masuk') {
            $dataBarang->stok_barang -= $jumlahSebelumnya;
        } elseif ($statusSebelumnya === 'keluar') {
            $dataBarang->stok_barang += $jumlahSebelumnya;
        }

        if ($statusBaru === 'masuk') {
            $dataBarang->stok_barang += $jumlahBaru;
        } elseif ($statusBaru === 'keluar') {
            $dataBarang->stok_barang -= $jumlahBaru;
        }

        $dataBarang->save();

        // Update stok customer
        $stokCustomer = StokCustomer::where('data_barang_id', $dataBarang->id)
            ->where('customer_id', $customerId)
            ->first();

        if ($stokCustomer) {
            // Handle stok customer
            if ($statusSebelumnya === 'keluar') {
                $stokCustomer->jumlah += $jumlahSebelumnya;
            } elseif ($statusSebelumnya === 'masuk') {
                $stokCustomer->jumlah -= $jumlahSebelumnya;
            }

            if ($statusBaru === 'keluar') {
                $stokCustomer->jumlah -= $jumlahBaru;
            } elseif ($statusBaru === 'masuk') {
                $stokCustomer->jumlah += $jumlahBaru;
            }

            if ($stokCustomer->jumlah <= 0) {
                $stokCustomer->delete(); // Remove if no stock left
            } else {
                $stokCustomer->save();
            }
        } else {
            if ($statusBaru === 'keluar') {
                StokCustomer::create([
                    'data_barang_id' => $dataBarang->id,
                    'customer_id' => $customerId,
                    'jumlah' => -$jumlahBaru,
                ]);
            }
        }
    }


    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $dataBarang = DataBarang::findOrFail($transaksi->data_barang_id);

        if ($transaksi->status == 'masuk') {
            // Kurangi stok barang ketika transaksi masuk dihapus
            $dataBarang->stok_barang -= $transaksi->jumlah;
        } else { // Transaksi keluar
            // Tambahkan kembali stok barang ketika transaksi keluar dihapus
            $dataBarang->stok_barang += $transaksi->jumlah;

            // Cari stok customer yang terkait
            $stokCustomer = StokCustomer::where('data_barang_id', $transaksi->data_barang_id)
                ->where('customer_id', $transaksi->customer_id)
                ->first();

            if ($stokCustomer) {
                // Sesuaikan stok customer berdasarkan jumlah yang dihapus
                $stokCustomer->jumlah += $transaksi->jumlah;

                // Hapus stok customer jika kembali ke jumlah awal yang kosong (0)
                if ($stokCustomer->jumlah == 0) {
                    $stokCustomer->delete();
                } else {
                    $stokCustomer->save();
                }
            }
        }

        $dataBarang->save();
        $transaksi->delete();

        return redirect()->route('transaksi')->with('warning', 'Transaksi berhasil dihapus.');
    }
}
