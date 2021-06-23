<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HorasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('horas')->insert(array(
            ['hora' => '08:00'],
            ['hora' => '09:00'],
            ['hora' => '10:00'],
            ['hora' => '11:00'],
            ['hora' => '12:00'],
            ['hora' => '13:00'],
            ['hora' => '14:00'],
            ['hora' => '15:00'],
            ['hora' => '16:00'],
            ['hora' => '17:00'],
            ['hora' => '18:00'],
            ['hora' => '19:00'],
            ['hora' => '20:00'],
            ['hora' => '21:00'],
        ));
    }
}
