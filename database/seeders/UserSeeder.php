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
                'first_name' => 'Thea',
                'last_name' => 'Isip',
                'contact_no' => '09276981790',
                'barangay'=>'Kalaklan',
                'email' => 'jmasd@gmail.com',
                'password' => Hash::make('antuking palaka')
            ]
        ]);
    }
}
