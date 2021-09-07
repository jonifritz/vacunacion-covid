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
            $table->string('complete_name');
            $table->integer('province_id');
            $table->integer('received_vaccines');
            $table->integer('assigned_vaccines');
            $table->integer('discarded_vaccines');
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
