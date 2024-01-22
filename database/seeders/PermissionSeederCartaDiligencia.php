<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionSeederCartaDiligencia extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // EXTRAPROTOCOLAR

        // Carta
        Permission::create(['name' => 'Modulo Carta', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar Carta', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar Carta', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear Carta', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar Carta', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar Carta', 'guard_name' => 'sanctum']);

        // Diligencia
        Permission::create(['name' => 'Modulo Diligencia', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar Diligencia', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar Diligencia', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear Diligencia', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar Diligencia', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar Diligencia', 'guard_name' => 'sanctum']);
    }
}
