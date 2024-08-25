<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiayaOperasionalController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataBarangController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\KategoriKlasifikasiController;
use App\Http\Controllers\KlasifikasiController;
use App\Http\Controllers\LaporanBarangController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\StokCustomerController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\VendorController;
use App\Models\KategoriKlasifikasi;
use App\Models\StokCustomer;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/login', function () {
    return view('login');
})->name('login');


Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kategori
    Route::get('/kategori', [KategoriKlasifikasiController::class, 'index'])->name('kategori');
    Route::get('/tambah-kategori', [KategoriKlasifikasiController::class, 'create']);
    Route::post('/simpan-kategori', [KategoriKlasifikasiController::class, 'store']);
    Route::get('edit-kategori/{id}', [KategoriKlasifikasiController::class, 'edit'])->name('edit-kategori');
    Route::put('update-kategori/{id}', [KategoriKlasifikasiController::class, 'update'])->name('update-kategori');

    // Klasifikasi
    Route::get('/klasifikasi', function () {
        return view('klasifikasi');
    });
    Route::get('/generate-klasifikasi', [KlasifikasiController::class, 'generateKlasifikasiAjax'])->name('generate_klasifikasi');
    Route::post('/simpan-klasifikasi', [KlasifikasiController::class, 'store']);
    Route::get('/export-klasifikasi-pdf', [KlasifikasiController::class, 'exportToPDF'])->name('export-klasifikasi-pdf');

    // Laporan
    Route::get('/stok-barang', [LaporanBarangController::class, 'stokBarang'])->name('stok-barang');
    Route::get('/barang-masuk', [LaporanBarangController::class, 'barangMasuk'])->name('barang-masuk');
    Route::get('/barang-keluar', [LaporanBarangController::class, 'barangKeluar'])->name('barang-keluar');
    Route::get('/stok-barang-pdf', [LaporanBarangController::class, 'stokBarangPDF'])->name('stok-barang-pdf');
    Route::get('/barang-masuk-pdf', [LaporanBarangController::class, 'barangMasukPDF'])->name('barang-masuk-pdf');
    Route::get('/barang-keluar-pdf', [LaporanBarangController::class, 'barangKeluarPDF'])->name('barang-keluar-pdf');
});

Route::group(['middleware' => ['auth', 'role:sales|superadmin|operasional|finance']], function () {
    // Jenis Barang
    Route::get('/jenis-barang', [JenisBarangController::class, 'index'])->name('jenis-barang');
    Route::get('/tambah-jenis-barang', [JenisBarangController::class, 'create']);
    Route::post('/simpan-jenis-barang', [JenisBarangController::class, 'store']);
    Route::get('edit-jenis-barang/{id}', [JenisBarangController::class, 'edit'])->name('edit-jenis-barang');
    Route::put('update-jenis-barang/{id}', [JenisBarangController::class, 'update'])->name('update-jenis-barang');


    // Data Barang
    Route::get('/data-barang', [DataBarangController::class, 'index'])->name('data-barang');
    Route::get('/tambah-data-barang', [DataBarangController::class, 'create']);
    Route::post('/simpan-data-barang', [DataBarangController::class, 'store']);
    Route::get('edit-data-barang/{id}', [DataBarangController::class, 'edit'])->name('edit-data-barang');
    Route::put('update-data-barang/{id}', [DataBarangController::class, 'update'])->name('update-data-barang');
    Route::get('/search-jenis-barang', [DataBarangController::class, 'searchJenisBarang'])->name('search.jenis.barang');

});

Route::group(['middleware' => ['auth', 'role:superadmin|operasional']], function () {
    // Vendor
    Route::get('/vendor', [VendorController::class, 'index'])->name('vendor');
    Route::get('/tambah-vendor', [VendorController::class, 'create']);
    Route::post('/simpan-vendor', [VendorController::class, 'store']);
    Route::get('edit-vendor/{id}', [VendorController::class, 'edit'])->name('edit-vendor');
    Route::put('update-vendor/{id}', [VendorController::class, 'update'])->name('update-vendor');
});

Route::group(['middleware' => ['auth', 'role:sales|superadmin']], function () {
    // Transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi');
    Route::get('/tambah-transaksi', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/simpan-transaksi', [TransaksiController::class, 'store']);
    Route::get('edit-transaksi/{id}', [TransaksiController::class, 'edit'])->name('edit-transaksi');
    Route::put('update-transaksi/{id}', [TransaksiController::class, 'update'])->name('update-transaksi');

    // Customer
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer');
    Route::get('/tambah-customer', [CustomerController::class, 'create']);
    Route::post('/simpan-customer', [CustomerController::class, 'store']);
    Route::get('detail-customer/{id}', [CustomerController::class, 'show'])->name('detail-customer');
    Route::get('edit-customer/{id}', [CustomerController::class, 'edit'])->name('edit-customer');
    Route::put('update-customer/{id}', [CustomerController::class, 'update'])->name('update-customer');
    Route::get('customer/{id}/export-pdf', [CustomerController::class, 'exportPdf'])->name('customer.exportPdf');

    // Stok Customer
    Route::get('/stok-customer', [StokCustomerController::class, 'index'])->name('stok-customer');
});

Route::group(['middleware' => ['auth', 'role:sales|superadmin|operasional|finance']], function () {
    // Pengajuan
    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan');
    Route::get('/tambah-pengajuan', [PengajuanController::class, 'create']);
    Route::post('/simpan-pengajuan', [PengajuanController::class, 'store']);
    Route::get('/edit-pengajuan/{id}', [PengajuanController::class, 'edit'])->name('edit-pengajuan');
    Route::put('update-pengajuan/{id}', [PengajuanController::class, 'update'])->name('update-pengajuan');
    Route::get('/edit-pengajuanfinance/{id}', [PengajuanController::class, 'editfinance'])->name('edit-pengajuanfinance');
    Route::put('update-pengajuanfinance/{id}', [PengajuanController::class, 'updatefinance'])->name('update-pengajuanfinance');

    // Biaya Oprasional
    Route::get('/biaya-operasional', [BiayaOperasionalController::class, 'index'])->name('biaya-operasional');
    Route::get('/tambah-biaya-operasional', [BiayaOperasionalController::class, 'create']);
    Route::post('/simpan-biaya-operasional', [BiayaOperasionalController::class, 'store']);
    Route::get('edit-biaya-operasional/{id}', [BiayaOperasionalController::class, 'edit'])->name('edit-biaya-operasional');
    Route::put('update-biaya-operasional/{id}', [BiayaOperasionalController::class, 'update'])->name('update-biaya-operasional');
});

Route::group(['middleware' => ['auth', 'role:sales|superadmin|operasional|finance']], function () {
    // User
    Route::get('/edit-profile', [AuthController::class, 'edit'])->name('edit-profile');
    Route::post('/update-profile', [AuthController::class, 'update'])->name('update-profile');
});

Route::group(['middleware' => ['auth', 'role:superadmin']], function () {
    // User Super
    Route::get('/user', [AuthController::class, 'index'])->name('user');
    Route::get('/register', function () {
        return view('register');
    })->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('edit-userid/{id}', [AuthController::class, 'editid'])->name('edit-userid');
    Route::put('update-userid/{id}', [AuthController::class, 'updateid'])->name('update-userid');
    Route::delete('hapus-user/{id}', [AuthController::class, 'destroyid'])->name('hapus-userid');

    // Delete
    Route::delete('hapus-kategori/{id}', [KategoriKlasifikasiController::class, 'destroy'])->name('hapus-kategori');
    Route::delete('hapus-jenis-barang/{id}', [JenisBarangController::class, 'destroy'])->name('hapus-jenis-barang');
    Route::delete('hapus-data-barang/{id}', [DataBarangController::class, 'destroy'])->name('hapus-data-barang');
    Route::delete('hapus-vendor/{id}', [VendorController::class, 'destroy'])->name('hapus-vendor');
    Route::delete('hapus-transaksi/{id}', [TransaksiController::class, 'destroy'])->name('hapus-transaksi');
    Route::delete('hapus-customer/{id}', [CustomerController::class, 'destroy'])->name('hapus-customer');
    Route::delete('hapus-pengajuan/{id}', [PengajuanController::class, 'destroy'])->name('hapus-pengajuan');
    Route::delete('hapus-biaya-operasional/{id}', [BiayaOperasionalController::class, 'destroy'])->name('hapus-biaya-operasional');

});
