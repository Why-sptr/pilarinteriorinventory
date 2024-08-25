<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klasifikasi extends Model
{
    use HasFactory;

    protected $table = 'klasifikasi';

    protected $fillable = [
        'data_barang_id',
        'jumlah_barang',
        'harga_barang',
        'total_harga_per_barang',
        'presentase_barang',
        'presentase_kumulatif',
        'golongan_barang_abc',
    ];

    public function dataBarang()
    {
        return $this->belongsTo(DataBarang::class);
    }
}
