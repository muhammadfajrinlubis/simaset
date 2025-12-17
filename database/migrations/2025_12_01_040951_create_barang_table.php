<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('namaBarang');
            $table->integer('tahun');
            $table->string('jenisBarang');
            $table->string('nomorNUP')->unique();
            $table->string('kondisi');
            $table->string('lokasi')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->foreignId('admin_id')->constrained('admin')->cascadeOnDelete();
            $table->text('fotoBarang');  // Foto boleh kosong
            $table->text('keterangan');
            $table->timestamps();                      // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
