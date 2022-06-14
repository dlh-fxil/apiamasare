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
        Schema::create('program_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->boolean('selesai')->default(0);
            $table->integer('id_kegiatan')->nullable();
            $table->integer('id_program')->nullable();
            $table->decimal('realisasi_biaya', 20, 2)->nullable();
            $table->integer('realisasi_jumlah_hasil')->nullable();
            $table->decimal('target_biaya', 20, 2)->nullable();
            $table->integer('target_jumlah_hasil')->nullable();
            $table->integer('target_waktu_pelaksanaan')->nullable();
            $table->string('indikator', 500)->nullable();
            $table->string('kinerja', 500)->nullable();
            $table->string('kode_bidang_urusan', 4);
            $table->string('kode_kegiatan', 4)->nullable();
            $table->string('kode_program', 4);
            $table->string('kode_sub_kegiatan', 4)->nullable();
            $table->string('kode_urusan', 4);
            $table->string('nomenklatur', 500);
            $table->string('satuan', 100)->nullable();
            $table->string('type', 20);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedSmallInteger('unit_id')->nullable();
            $table->year('tahun_anggaran');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('unit_id')->references('id')->on('unit')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_kegiatan');
    }
};
