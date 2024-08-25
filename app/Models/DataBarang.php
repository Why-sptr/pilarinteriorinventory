<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBarang extends Model
{
    use HasFactory;

    protected $table = 'data_barang';

    protected $fillable = [
        'nama_barang',
        'jenis_barang_id',
        'harga_barang',
        'stok_barang',
        'vendor_id',
    ];

    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class, 'jenis_barang_id');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class);
    }
    
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
