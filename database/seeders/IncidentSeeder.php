<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('incidents')->insert([
            [
                'residents_id' => '1',
                'type' => 'Requesting for Ambulance'
            ]
        ]);
    }
}
