<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('data_barang_id')->constrained('data_barang')->onDelete('cascade');
            $table->bigInteger('biaya');
            $table->bigInteger('jumlah');
            $table->string('bukti_tf')->nullable();
            $table->enum('status', ['diajukan', 'disetujui', 'ditolak']);
            $table->date('tanggal_pengajuan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};

