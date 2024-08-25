<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanBarangController extends Controller
{
    public function stokBarang(Request $request)
    {
        $query = $request->input('query');

        $dataBarangsQuery = DataBarang::query();

        if ($query) {
            $dataBarangsQuery->where('nama_barang', 'LIKE', "%{$query}%");
        }

        $dataBarangs = $dataBarangsQuery->orderBy('created_at', 'DESC')->paginate(5);

        $stokBarangs = $dataBarangs->map(function ($barang) {
            $jumlahPengadaan = Transaksi::where('data_barang_id', $barang->id)
                ->where('status', 'masuk')
                ->count();

            $jumlahPemesanan = Transaksi::where('data_barang_id', $barang->id)
                ->where('status', 'keluar')
                ->count();

            $stock = $barang->stok_barang;

            return [
                'nama_produk' => $barang->nama_barang,
                'harga_satuan' => $barang->harga_barang,
                'jumlah_pengadaan' => $jumlahPengadaan,
                'jumlah_pemesanan' => $jumlahPemesanan,
                'stock' => $stock,
            ];
        });

        return view('stokbarang', compact('dataBarangs', 'stokBarangs', 'query'));
    }

    public function barangMasuk(Request $request)
    {
        $query = $request->input('query');

        $transaksiMasukQuery = Transaksi::where('status', 'masuk')
            ->with('dataBarang');

        if ($query) {
            $transaksiMasukQuery->whereHas('dataBarang', function ($q) use ($query) {
                $q->where('nama_barang', 'LIKE', "%{$query}%");
            });
        }

        $transaksiMasuk = $transaksiMasukQuery->orderBy('tanggal_transaksi', 'DESC')->paginate(5);

        $transaksiData = $transaksiMasuk->map(function ($transaksi) {
            return [
                'tanggal' => $transaksi->tanggal_transaksi,
                'nama_produk' => $transaksi->dataBarang->nama_barang,
                'harga_barang' => $transaksi->dataBarang->harga_barang,
                'jumlah' => $transaksi->jumlah,
            ];
        });

        return view('barangmasuk', compact('transaksiData', 'transaksiMasuk', 'query'));
    }

    public function barangKeluar(Request $request)
    {
        $query = $request->input('query');

        $transaksiKeluarQuery = Transaksi::where('status', 'keluar')
            ->with('dataBarang');

        if ($query) {
            $transaksiKeluarQuery->whereHas('dataBarang', function ($q) use ($query) {
                $q->where('nama_barang', 'LIKE', "%{$query}%");
            });
        }

        $transaksiKeluar = $transaksiKeluarQuery->orderBy('tanggal_transaksi', 'DESC')->paginate(5);

        $transaksiData = $transaksiKeluar->map(function ($transaksi) {
            return [
                'tanggal' => $transaksi->tanggal_transaksi,
                'nama_produk' => $transaksi->dataBarang->nama_barang,
                'harga_barang' => $transaksi->dataBarang->harga_barang,
                'jumlah' => $transaksi->jumlah,
            ];
        });

        return view('barangkeluar', compact('transaksiData', 'transaksiKeluar', 'query'));
    }

    public function stokBarangPDF()
    {
        $dataBarangs = DataBarang::all();
        $stokBarangs = $dataBarangs->map(function ($barang) {
            $jumlahPengadaan = Transaksi::where('data_barang_id', $barang->id)
                ->where('status', 'masuk')
                ->count();

            $jumlahPemesanan = Transaksi::where('data_barang_id', $barang->id)
                ->where('status', 'keluar')
                ->count();

            $stock = $barang->stok_barang;

            return [
                'nama_produk' => $barang->nama_barang,
                'harga_satuan' => $barang->harga_barang,
                'jumlah_pengadaan' => $jumlahPengadaan,
                'jumlah_pemesanan' => $jumlahPemesanan,
                'stock' => $stock,
            ];
        });

        $pdf = Pdf::loadView('pdf.stok_barang', ['stokBarangs' => $stokBarangs]);
        return $pdf->download('stok_barang.pdf');
    }

    public function barangMasukPDF()
    {
        $transaksiMasuk = Transaksi::where('status', 'masuk')
            ->with('dataBarang')
            ->get();

        $transaksiData = $transaksiMasuk->map(function ($transaksi) {
            return [
                'tanggal' => $transaksi->tanggal_transaksi,
                'nama_produk' => $transaksi->dataBarang->nama_barang,
                'harga_barang' => $transaksi->dataBarang->harga_barang,
                'jumlah' => $transaksi->jumlah,
            ];
        });

        $pdf = Pdf::loadView('pdf.barang_masuk', ['transaksiData' => $transaksiData]);
        return $pdf->download('barang_masuk.pdf');
    }

    public function barangKeluarPDF()
    {
        $transaksiKeluar = Transaksi::where('status', 'keluar')
            ->with('dataBarang')
            ->get();

        $transaksiData = $transaksiKeluar->map(function ($transaksi) {
            return [
                'tanggal' => $transaksi->tanggal_transaksi,
                'nama_produk' => $transaksi->dataBarang->nama_barang,
                'harga_barang' => $transaksi->dataBarang->harga_barang,
                'jumlah' => $transaksi->jumlah,
            ];
        });

        $pdf = Pdf::loadView('pdf.barang_keluar', ['transaksiData' => $transaksiData]);
        return $pdf->download('barang_keluar.pdf');
    }
}
