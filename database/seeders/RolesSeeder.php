<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(array(
            ['name' => 'Admin', 'guard_name' => 'web'],
            ['name' => 'Administrador', 'guard_name' => 'web'],
            ['name' => 'User', 'guard_name' => 'web'],
        ));
    }
}
