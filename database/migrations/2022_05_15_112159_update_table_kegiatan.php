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
     Schema::table('item_kegiatan', function (Blueprint $table) {
      $table->after('program_kegiatan_id', function ($table) {
          $table->unsignedSmallInteger('unit_id')->nullable();      });
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
     Schema::table('item_kegiatan', function (Blueprint $table) {
      $table->dropForeign('unit_id');
      $table->dropColumn('unit_id');
  });
    }
};
