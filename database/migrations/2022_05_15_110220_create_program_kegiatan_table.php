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
            $table->string('kode_urusan', 4);
            $table->string('kode_bidang_urusan', 4);
            $table->string('kode_program', 4);
            $table->string('kode_kegiatan', 4)->nullable();
            $table->string('kode_sub_kegiatan', 4)->nullable();
            $table->string('nomenklatur', 255);
            $table->string('kinerja', 255)->nullable();
            $table->string('indikator', 255)->nullable();
            $table->year('tahun_anggaran');
            $table->integer('biaya')->nullable();
            $table->integer('target_waktu_pelaksanaan')->nullable();
            $table->integer('target_jumlah_hasil')->nullable();
            $table->string('satuan', 100)->nullable();
            $table->float('progress')->nullable();
            $table->unsignedSmallInteger('unit_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->boolean('selesai')->default(0);
            $table->string('type', 20);
            $table->integer('id_program')->nullable();
            $table->integer('id_kegiatan')->nullable();
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
