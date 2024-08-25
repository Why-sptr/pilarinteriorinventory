<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKlasifikasi extends Model
{
    use HasFactory;

    protected $table = 'kategori_klasifikasi';

    protected $fillable = [
        'kategori',
    ];

    public function klasifikasi()
    {
        return $this->hasMany(Klasifikasi::class);
    }
}

