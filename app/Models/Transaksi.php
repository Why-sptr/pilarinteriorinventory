<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'data_barang_id',
        'customer_id',
        'jumlah',
        'status',
        'tanggal_transaksi',
    ];

    public function dataBarang()
    {
        return $this->belongsTo(DataBarang::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
