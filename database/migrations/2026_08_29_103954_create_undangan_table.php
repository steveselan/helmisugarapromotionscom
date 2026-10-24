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
        Schema::create('tb_undangan', function (Blueprint $table) {
            $table->id('id_undangan');
            $table->string('jenis');
            $table->string('tanggal');
            $table->string('lokasi_undangan');
            $table->string('jam');
            $table->unsignedBigInteger('event_id');
            $table->string('judul');
            $table->integer('kapasitas');
            $table->timestamps();

            $table->foreign('event_id')->references('id_event')->on('tb_newevent')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('undangan');
    }
};
