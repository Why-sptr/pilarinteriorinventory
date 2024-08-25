<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan';

    protected $fillable = [
        'customer_id',
        'data_barang_id',
        'jumlah',
        'status',
        'biaya',
        'bukti_tf',
        'tanggal_pengajuan',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function dataBarang()
    {
        return $this->belongsTo(DataBarang::class);
    }
}
