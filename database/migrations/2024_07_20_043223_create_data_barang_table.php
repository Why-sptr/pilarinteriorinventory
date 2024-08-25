<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->foreignId('jenis_barang_id')->constrained('jenis_barang')->onDelete('cascade');
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');
            $table->decimal('harga_barang');
            $table->bigInteger('stok_barang');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_barang');
    }
};

