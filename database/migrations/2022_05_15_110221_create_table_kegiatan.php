<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('tahun', 5);
            $table->date('tanggal');
            $table->string('judul', 255);
            $table->longText('uraian');
            $table->timestamp('mulai', $precision = 0);
            $table->timestamp('selesai', $precision = 0)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('program_kegiatan_id')->nullable();
            $table->unsignedSmallInteger('unit_id')->nullable();
            $table->foreign('unit_id')->references('id')->on('unit')->onDelete('set null');
            $table->foreign('program_kegiatan_id')->references('id')->on('program_kegiatan')->onDelete('restrict');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kegiatan');
    }
};
