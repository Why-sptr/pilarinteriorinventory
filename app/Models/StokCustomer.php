<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokCustomer extends Model
{
    use HasFactory;
    
    protected $table = 'stok_customer';

    protected $fillable = ['data_barang_id', 'customer_id', 'jumlah'];

    public function dataBarang()
    {
        return $this->belongsTo(DataBarang::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
