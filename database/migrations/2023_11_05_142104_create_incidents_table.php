<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('residents_id')->unsigned();
            $table->foreign('residents_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('type', ['Requesting for Ambulance', 'Requesting for a Barangay Public Safety Officer', 'Requesting for a Fire Truck']);
            $table->string('status')->default('Respond');
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
        Schema::dropIfExists('incidents');
    }
}
