<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'admin_name' => 'Jolito Cruz',
                'barangay' => 'Santa Rita',
                'city' => 'Olongapo',
                'province' => 'Zambales',
                'email' => 'starita@gmail.com',
                'password' => Hash::make('bastapasswordto'),
                'role' => 'Sta Rita Admin'
            ],
            [
                'admin_name' => 'Arnel Gonzales',
                'barangay' => 'East Tapinac',
                'city' => 'Olongapo',
                'province' => 'Zambales',
                'email' => 'tapinac@gmail.com',
                'password' => Hash::make('passlang'),
                'role' => 'East Tapinac Admin'
            ]
        ]);
    }
}
