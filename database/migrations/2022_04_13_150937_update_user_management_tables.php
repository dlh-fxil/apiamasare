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

        Schema::table('permissions', function (Blueprint $table) {
            $table->string('group', 20)->after('id')->nullable();
            $table->string('description', 125)->after('name')->nullable();
            $table->softDeletes();
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->smallInteger('level')->after('id');       // For MySQL 8.0 use string('name', 125);
            $table->string('description', 125)->after('name')->nullable();
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

        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('group');
            $table->dropColumn('description');
            $table->dropSoftDeletes();
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('level');
            $table->dropColumn('description');
            $table->dropSoftDeletes();
        });
    }
};
