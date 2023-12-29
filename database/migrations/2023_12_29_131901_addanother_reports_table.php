<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddanotherReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->enum('type_of_incidents', ['Fire Incident', 'Rescue Operation', 'Medical Emergencies', 'Motor Vehicle Accidents', 'Criminal Activity', 'Public Safety Issues'])->nullable()->after('latitude');
            $table->tinyInteger('Firetruck')->default('0')->after('type_of_incidents');
            $table->tinyInteger('Ambulance')->default('0')->after('type_of_incidents');
            $table->tinyInteger('BPSO')->default('0')->after('type_of_incidents');
        });
 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
