<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacunatoryCenterVaccinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacunatory_center_vaccinations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vaccine_id');
            $table->string('used_lots');
            $table->string('name');
            $table->bigInteger('locality_id');
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
        Schema::dropIfExists('vacunatory_center_vaccinations');
    }
}
