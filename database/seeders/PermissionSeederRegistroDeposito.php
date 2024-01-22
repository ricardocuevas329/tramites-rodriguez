<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionSeederRegistroDeposito extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // ENTIDAD

        // RetistroDeposito
        Permission::create(['name' => 'Modulo RegistroDeposito', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar RegistroDeposito', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar RegistroDeposito', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear RegistroDeposito', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar RegistroDeposito', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar RegistroDeposito', 'guard_name' => 'sanctum']);

    }
}
