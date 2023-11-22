<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForwardedincidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forwardedincidents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('incident_id')->unsigned();
            $table->foreign('incident_id')->references('id')->on('incidents')->onDelete('cascade');
            $table->enum('barangay', ['Asinan', 'Banicain', 'Barretto', 'East Tapinac', 'Gordon Heights', 'Kalaklan', 'Mabayuan', 'New Cabalan', 'New Ilalim', 'New Kababae', 'New Kalalake', 'Old Cabalan', 'Pag-asa', 'Santa Rita', 'West Bajac-Bajac', 'West Tapinac'])->default('Santa Rita');
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
        Schema::dropIfExists('forwardedincidents');
    }
}
