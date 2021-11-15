<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_name');
            $table->string('vehicle_model');
            $table->string('vehicle_accessories');
            $table->integer('number_of_sits');
            $table->string('plate_number');
            $table->string('origin');
            $table->string('destination');
            $table->date('departure_date');
            $table->Time('departure_time');
            $table->bigInteger('company_id')->unsigned()->index();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->bigInteger('reserve_id', )->unsigned()->index()->nullable()->nullable();
            $table->foreign('reserve_id')->references('id')->on('reserves');
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
        Schema::dropIfExists('vehicles');
    }
}
