<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_vehicles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('equipment_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->foreign('equipment_id')->references('id')->on('vehicle_equipment');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_vehicles');
    }
}
