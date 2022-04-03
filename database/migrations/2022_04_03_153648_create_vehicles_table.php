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
            $table->bigInteger('externalId')->unique();
            $table->bigInteger('uin')->unique()->nullable()->default(null);

            $table->unsignedBigInteger('dealer_id')->nullable()->default(null);
            $table->foreign('dealer_id')
                ->references('id')
                ->on('vehicle_dealers')
                ->onDelete('cascade');
            $table->unsignedBigInteger('category_id')->nullable()->default(null);
            $table->foreign('category_id')
                ->references('id')
                ->on('vehicle_categories')
                ->onDelete('cascade');
            $table->unsignedBigInteger('subcategory_id')->nullable()->default(null);
            $table->foreign('subcategory_id')
                ->references('id')
                ->on('vehicle_subcategories')
                ->onDelete('cascade');
            $table->unsignedBigInteger('brand_id')->nullable()->default(null);
            $table->foreign('brand_id')
                ->references('id')
                ->on('vehicle_brands')
                ->onDelete('cascade');
            $table->unsignedBigInteger('model_id')->nullable()->default(null);
            $table->foreign('model_id')
                ->references('id')
                ->on('vehicle_models')
                ->onDelete('cascade');
            $table->unsignedBigInteger('generation_id')->nullable()->default(null);
            $table->foreign('generation_id')
                ->references('id')
                ->on('vehicle_generations')
                ->onDelete('cascade');
            $table->unsignedBigInteger('bodyConfiguration_id')->nullable()->default(null);
            $table->foreign('bodyConfiguration_id')
                ->references('id')
                ->on('vehicle_body_configurations')
                ->onDelete('cascade');
            $table->unsignedBigInteger('modification_id')->nullable()->default(null);
            $table->foreign('modification_id')
                ->references('id')
                ->on('vehicle_modifications')
                ->onDelete('cascade');
            $table->unsignedBigInteger('complectation_id')->nullable()->default(null);
            $table->foreign('complectation_id')
                ->references('id')
                ->on('vehicle_complectations')
                ->onDelete('cascade');
            $table->unsignedBigInteger('country_id')->nullable()->default(null);
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('cascade');

            $table->integer('engineVolume')->nullable()->default(null);
            $table->integer('enginePower')->nullable()->default(null);
            $table->integer('bodyDoorCount')->nullable()->default(null);
            $table->integer('gearboxGearCount')->nullable()->default(null);
            $table->integer('mileage')->nullable()->default(null);
            $table->integer('price')->nullable()->default(null);
            $table->integer('photoCount')->nullable()->default(null);
            $table->integer('ownersCount')->nullable()->default(null);
            $table->string('year', 4)->nullable()->default(null);
            $table->string('type')->nullable()->default(null);
            $table->string('engineType')->nullable()->default(null);
            $table->string('bodyType')->nullable()->default(null);
            $table->string('bodyColor')->nullable()->default(null);
            $table->string('driveType')->nullable()->default(null);
            $table->string('gearboxType')->nullable()->default(null);
            $table->string('steeringWheel')->nullable()->default(null);
            $table->string('mileageUnit')->nullable()->default(null);
            $table->string('availability')->nullable()->default(null);
            $table->string('ptsType')->nullable()->default(null);

            $table->string('vehicleCondition')->nullable()->default(null);
            $table->string('acquisitionSource')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->boolean('specialOffer')->default(false);
            $table->boolean('bodyColorMetallic')->default(false);
            $table->date('acquisitionDate')->nullable()->default(null);
            $table->date('manufactureDate')->nullable()->default(null);
            $table->integer('specialOfferPreviousPrice')->nullable()->default(null);
            $table->integer('tradeinDiscount')->nullable()->default(null);
            $table->integer('creditDiscount')->nullable()->default(null);
            $table->integer('insuranceDiscount')->nullable()->default(null);
            $table->integer('maxDiscount')->nullable()->default(null);
            $table->integer('length')->nullable()->default(null);
            $table->integer('width')->nullable()->default(null);
            $table->integer('bodyVolume')->nullable()->default(null);
            $table->integer('bucketVolume')->nullable()->default(null);
            $table->integer('saddleHeight')->nullable()->default(null);
            $table->integer('craneArrowRadius')->nullable()->default(null);
            $table->integer('craneArrowLength')->nullable()->default(null);
            $table->integer('craneArrowPayload')->nullable()->default(null);
            $table->integer('loadHeight')->nullable()->default(null);
            $table->string('brandComplectationCode')->nullable()->default(null);
            $table->string('operatingTime')->nullable()->default(null);
            $table->string('ecoClass')->nullable()->default(null);
            $table->string('driveWheel')->nullable()->default(null);
            $table->string('axisCount')->nullable()->default(null);
            $table->string('brakeType')->nullable()->default(null);
            $table->string('cabinType')->nullable()->default(null);
            $table->string('maximumPermittedMass')->nullable()->default(null);
            $table->string('cabinSuspension')->nullable()->default(null);
            $table->string('chassisSuspension')->nullable()->default(null);
            $table->string('tractionClass')->nullable()->default(null);
            $table->string('refrigeratorClass')->nullable()->default(null);
            $table->string('brandColorCode')->nullable()->default(null);
            $table->string('brandInteriorCode')->nullable()->default(null);
            $table->string('certificationProgram')->nullable()->default(null);
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
