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
        Schema::create('tb_mediaitem', function (Blueprint $table) {
            $table->id('id_mediaitem');
            $table->unsignedBigInteger('ratecard_id');
            $table->string('nama_item');
            $table->bigInteger('harga');
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('ratecard_id')->references('id_ratecard')->on('tb_ratecard')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mediaitems');
    }
};
