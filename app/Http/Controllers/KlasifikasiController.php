<?php

namespace App\Http\Controllers;

use App\Models\Klasifikasi;
use App\Models\DataBarang;
use App\Models\KategoriKlasifikasi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KlasifikasiController extends Controller
{
    public function generateKlasifikasiAjax()
    {
        $barangKlasifikasi = $this->generateKlasifikasi();
        return response()->json($barangKlasifikasi); 
    }


    private function generateKlasifikasi()
    {
        $dataBarangs = DataBarang::all();

        $kategoriKlasifikasis = KategoriKlasifikasi::all()->pluck('kategori')->toArray();
        $jumlahKategori = count($kategoriKlasifikasis);

        $totalNilaiBarang = $dataBarangs->sum(function ($item) {
            return (float) $item->harga_barang * (int) $item->stok_barang;
        });

        $barangKlasifikasi = $dataBarangs->map(function ($barang) use ($totalNilaiBarang) {
            $totalHargaBarang = (float) $barang->harga_barang * (int) $barang->stok_barang;
            $presentaseBarang = $totalHargaBarang / $totalNilaiBarang * 100;

            return [
                'nama_barang' => $barang->nama_barang,
                'jumlah_barang' => (int) $barang->stok_barang,
                'harga_barang' => (float) $barang->harga_barang,
                'total_harga_per_barang' => $totalHargaBarang,
                'presentase_barang' => $presentaseBarang,
            ];
        });

        $barangKlasifikasi = $barangKlasifikasi->sortByDesc('total_harga_per_barang');

        $cumulativePercentage = 0;
        $barangKlasifikasi = $barangKlasifikasi->map(function ($barang) use (&$cumulativePercentage) {
            $cumulativePercentage += $barang['presentase_barang'];
            $barang['presentase_kumulatif'] = $cumulativePercentage;
            return $barang;
        });

        $barangKlasifikasi = $barangKlasifikasi->map(function ($barang) use ($kategoriKlasifikasis, $jumlahKategori) {
            $thresholds = array_map(function ($index) use ($jumlahKategori) {
                return ($index + 1) / $jumlahKategori * 100;
            }, array_keys($kategoriKlasifikasis));

            $index = 0;
            foreach ($thresholds as $threshold) {
                if ($barang['presentase_kumulatif'] <= $threshold) {
                    $barang['golongan_barang'] = $kategoriKlasifikasis[$index];
                    return $barang;
                }
                $index++;
            }

            $barang['golongan_barang'] = end($kategoriKlasifikasis); 
            return $barang;
        });

        return $barangKlasifikasi->values()->all(); 
    }


    public function exportToPDF()
    {
        $klasifikasi = $this->generateKlasifikasi();

        $pdf = Pdf::loadView('pdf.klasifikasi', ['klasifikasi' => $klasifikasi]);
        return $pdf->download('klasifikasi.pdf');
    }
}
