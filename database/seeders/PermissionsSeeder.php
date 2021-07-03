<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert(array(
            ['id' => 1,'name' => 'panel.listar', 'guard_name' => 'web'],
            ['id' => 2, 'name' => 'doctores.listar', 'guard_name' => 'web'],
            ['id' => 3, 'name' => 'doctores.crear', 'guard_name' => 'web'],
            ['id' => 4, 'name' => 'doctores.acciones', 'guard_name' => 'web'],
            ['id' => 5, 'name' => 'autenticacion.listar', 'guard_name' => 'web'],
            ['id' => 6, 'name' => 'horas.listar', 'guard_name' => 'web'],
            ['id' => 7, 'name' => 'horas.crear', 'guard_name' => 'web'],
            ['id' => 8, 'name' => 'horas.acciones', 'guard_name' => 'web'],
            ['id' => 9, 'name' => 'agendas.listar', 'guard_name' => 'web'],
            ['id' => 10, 'name' => 'agendas.crear', 'guard_name' => 'web'],
            ['id' => 11, 'name' => 'agendas.acciones', 'guard_name' => 'web'],
            ['id' => 12, 'name' => 'agendar', 'guard_name' => 'web'],
            ['id' => 13, 'name' => 'especialidades.listar', 'guard_name' => 'web'],
            ['id' => 14, 'name' => 'especialidades.crear', 'guard_name' => 'web'],
            ['id' => 15, 'name' => 'especialidades.acciones', 'guard_name' => 'web'],
        ));
    }
}
