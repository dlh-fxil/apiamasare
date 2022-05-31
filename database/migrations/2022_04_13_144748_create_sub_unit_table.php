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
        Schema::create('sub_unit', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('jenis', 20);
            $table->string('nama', 100);
            $table->string('singkatan', 100)->nullable();
            $table->unsignedSmallInteger('unit_id')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('unit_id')->references('id')->on('unit')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_unit');
    }
};
