<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMunicipalityVaccinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('municipality_vaccinations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vaccine_id');
            $table->string('used_lots');
            $table->string('complete_name');
            $table->bigInteger('iso_id');
            $table->bigInteger('province_id');
            $table->integer('received_lots');
            $table->bigInteger('used')->default(0);
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
        Schema::dropIfExists('municipality_vaccinations');
    }
}
