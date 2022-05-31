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
        Schema::table('users', function (Blueprint $table) {
            $table->after('name', function ($table) {
                $table->string('jenis_pegawai', 20)->default('PNS');
                $table->string('nip', 20)->nullable();
                $table->string('no_hp', 20)->nullable();
                $table->string('no_wa', 20)->nullable();
                $table->string('eselon', 20)->nullable();
                $table->unsignedSmallInteger('pangkat_id')->nullable();
                $table->unsignedSmallInteger('sub_unit_id')->nullable();
                $table->unsignedSmallInteger('unit_id')->nullable();
                $table->unsignedSmallInteger('jabatan_id')->nullable();
                $table->string('username', 20)->nullable();
            });
            $table->softDeletes();
            $table->foreign('pangkat_id')->references('id')->on('pangkat')->onDelete('set null');
            $table->foreign('jabatan_id')->references('id')->on('jabatan')->onDelete('set null');
            $table->foreign('unit_id')->references('id')->on('unit')->onDelete('set null');
            $table->foreign('sub_unit_id')->references('id')->on('sub_unit')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropForeign('posts_user_id_foreign');
            $table->dropForeign('pangkat_id');
            $table->dropForeign('jabatan_id');
            $table->dropForeign('unit_id');
            $table->dropForeign('sub_unit_id');
            $table->dropColumn('nip', 20);
            $table->dropColumn('no_hp', 20);
            $table->dropColumn('no_wa', 20);
            $table->dropColumn('eselon', 20);
            $table->dropColumn('pangkat_id');
            $table->dropColumn('sub_unit_id');
            $table->dropColumn('unit_id');
            $table->dropColumn('jabatan_id');
        });
    }
};
