<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('passwordHash');
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });

         // Tambahkan admin default
        DB::table('admin')->insert([
            'nama' => 'Admin Utama',
            'email' => 'admin@example.com',
            'passwordHash' => Hash::make('123456'),
            'status_aktif' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
