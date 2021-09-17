<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvinceVaccinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('province_vaccinations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vaccine_id');
            $table->string('used_lots');
            $table->string('complete_name');
            $table->string('iso_id');
            $table->integer('received_lots');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('province_vaccinations');
    }
}
