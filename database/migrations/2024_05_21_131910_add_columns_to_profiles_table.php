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
        Schema::table('profiles', function (Blueprint $table) {
            $table->boolean('is_name_shown');
            $table->string('mobile');
            $table->string('cover_image');
            $table->dropColumn('level');
            $table->dropColumn('interests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('is_name_shown')->nullable();
            $table->dropColumn('mobile');
            $table->dropColumn('cover_image')->nullable();
            $table->string('level')->nullable();
            $table->string('interests')->nullable();
        });
    }
};
