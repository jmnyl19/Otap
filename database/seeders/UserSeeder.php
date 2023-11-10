<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
                'first_name' => 'Jmie',
                'last_name' => 'Boluntate',
                'birthday' => '2002-11-19',
                'contact_no' => '09276981790',
                'lot_no' => '13',
                'street' => 'Donor Street',
                'barangay'=>'East Tapinac',
                'city'=>'Olongapo',
                'province'=>'Zambales',
                'email' => 'jmieboluntate@gmail.com',
                'password' => Hash::make('antuking palaka')
            ]
        ]);
    }
}
