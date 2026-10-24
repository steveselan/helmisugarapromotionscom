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
        Schema::create('tb_buktisiar', function (Blueprint $table) {
            $table->id('id_buktisiar');
            $table->unsignedBigInteger('mediaplandetail_id');
            $table->string('file_bukti');
            $table->text('keteranga')->nullable();
            $table->string('link_posting')->nullable();
            $table->timestamps();

            $table->foreign('mediaplandetail_id')->references('id_mediaplandetail')->on('tb_mediaplandetail')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buktisiars');
    }
};
