<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vacunatory_center_vaccinations', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('locality_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vacunatory_center_vaccinations', function (Blueprint $table) {
            $table->string('name');
            $table->unsignedBigInteger('locality_id');
        });
    }
}
