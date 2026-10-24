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
        Schema::create('tb_mediaplandetail', function (Blueprint $table) {
            $table->id('id_mediaplandetail');
            $table->unsignedBigInteger('mediaplan_id');
            $table->unsignedBigInteger('ratecard_id');
            $table->unsignedBigInteger('mediaitem_id');
            $table->integer('jumlah_tiket')->default(0);
            $table->integer('id_media')->default(0);
            $table->integer('qty')->default(0);
            $table->bigInteger('harga_satuan');
            $table->bigInteger('subtotal');
            $table->timestamps();

            $table->foreign('mediaplan_id')->references('id_mediaplan')->on('tb_mediaplan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mediaplandetails');
    }
};
