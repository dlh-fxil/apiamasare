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
        Schema::create('unit', function (Blueprint $table) {
            $table->smallIncrements('id');
            // $table->smallIncrements('id')->from(2);
            $table->string('jenis', 20);
            $table->string('nama', 100);
            $table->string('singkatan', 100)->nullable();
            $table->string('uraian_tugas_fungsi', 500)->nullable();
            $table->string('file_path', 2048)->nullable();
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
        Schema::dropIfExists('unit');
    }
};
