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
        Schema::create('tb_newevent', function (Blueprint $table) {
            $table->id('id_event');
            $table->string('judul_event');
            $table->string('artis');
            $table->string('lokasi');
            $table->string('tanggal');
            $table->string('link_tiket')->nullable();
            $table->string('promotor');
            $table->string('status');
            $table->unsignedBigInteger('kategori_id');
            $table->string('gambar1')->nullable();
            $table->string('gambar2')->nullable();
            $table->timestamps();

             $table->foreign('kategori_id')->references('id_kategori')->on('tb_kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newevent');
    }
};
