<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $table = 'vendors';

    protected $fillable = ['nama', 'telepon', 'alamat'];

    public function dataBarang()
    {
        return $this->hasMany(DataBarang::class);
    }
}
