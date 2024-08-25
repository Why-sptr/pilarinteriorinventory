<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('klasifikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_barang_id')->constrained('data_barang')->onDelete('cascade');
            $table->integer('jumlah_barang');
            $table->bigInteger('harga_barang');
            $table->bigInteger('total_harga_per_barang');
            $table->bigInteger('presentase_barang');
            $table->bigInteger('presentase_kumulatif');
            $table->string('golongan_barang_abc');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klasifikasi');
    }
};

