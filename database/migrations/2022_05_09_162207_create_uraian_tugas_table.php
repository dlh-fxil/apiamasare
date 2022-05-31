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
        Schema::create('uraian_tugas', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('jabatan_id')->nullable();
            $table->enum('jenis_tugas', ['Tugas Pokok', 'Tugas Tambahan'])->nullable();
            $table->string('uraian_tugas', 125);
            $table->string('indikator', 125)->nullable();
            $table->float('angka_kredit')->nullable();
            $table->string('keterangan', 125)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('jabatan_id')->references('id')->on('jabatan')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uraian_tugas');
    }
};
