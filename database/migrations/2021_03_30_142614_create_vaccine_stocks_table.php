<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccineStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccine_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_vaccine_id')->nullable();
            $table->string('description');
            $table->date('admission_date');
            $table->integer('quantity');
            $table->integer('balance');
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
        Schema::dropIfExists('vaccine_stocks');
    }
}
