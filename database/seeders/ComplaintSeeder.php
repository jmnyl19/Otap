<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('complaints')->insert([
            [
                'student_id' => '1',
                'recipient_add' => 'ccs.studentcouncil@gordoncollegeccs.edu.ph',
                'subj_of_complt' => 'Cyberbullied by a blockmate',
                'ticket_body' => 'A blockmate of mine harasses me every morning ny sending degratory message in our GC'
            ],
            [
                'student_id' => '2',
                'recipient_add' => 'ccs.studentcouncil@gordoncollegeccs.edu.ph',
                'subj_of_complt' => 'CCS Membership payment',
                'ticket_body' => 'I already paid my contribution but then they said that I did not give my contribution'
            ]
        ]);  
      }
}
