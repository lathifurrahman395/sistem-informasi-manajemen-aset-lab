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
    Schema::create('locations', function (Blueprint $table) {
        $table->id();
        $table->string('nama_lab'); // Contoh: Lab Jaringan, Lab Pemrograman
        $table->string('kode_ruangan')->nullable(); // Contoh: Ruang 3.1
        $table->string('kepala_lab')->nullable(); // Nama dosen kepala lab
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
