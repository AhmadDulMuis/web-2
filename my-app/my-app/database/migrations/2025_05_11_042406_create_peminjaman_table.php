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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ruang_id');
            $table->unsignedBigInteger('pegawai_id');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_akhir');
            $table->text('keterangan');
            $table->timestamps();

            $table->foreign('ruang_id')->references('id')->on('ruang')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**ww
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
