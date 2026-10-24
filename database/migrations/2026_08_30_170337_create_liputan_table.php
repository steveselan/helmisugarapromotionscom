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
        Schema::create('tb_liputan', function (Blueprint $table) {
            $table->id('id_liputan');
            $table->string('nama');
            $table->string('email');
            $table->string('phone');
            $table->string('media');
            $table->string('jabatan');
            $table->string('jenis_undangan');
            $table->string('jenis_media')->nullable();
            $table->string('link1',200)->nullable();
            $table->string('link2',200)->nullable();
            $table->string('jumlah_id')->nullable();
            $table->unsignedBigInteger('undangan_id');
            $table->timestamps();

            $table->foreign('undangan_id')->references('id_undangan')->on('tb_undangan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liputan');
    }
};
