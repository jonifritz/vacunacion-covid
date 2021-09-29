<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVacunatoryCenterId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vacunatory_center_vaccinations', function (Blueprint $table) {
            $table->unsignedBigInteger('vacunatory_center_id')->nullable();
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
            $table->dropColumn('vacunatory_center_id');
        });
    }
}
