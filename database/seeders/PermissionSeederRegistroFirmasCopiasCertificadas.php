<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionSeederRegistroFirmasCopiasCertificadas extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // EXTRAPROTOCOLAR

        // RetistroFirmas
        Permission::create(['name' => 'Modulo RegistroFirmas', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar RegistroFirmas', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar RegistroFirmas', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear RegistroFirmas', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar RegistroFirmas', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar RegistroFirmas', 'guard_name' => 'sanctum']);

        // CopiasCerfificadas
        Permission::create(['name' => 'Modulo CopiasCerfificadas', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar CopiasCerfificadas', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar CopiasCerfificadas', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear CopiasCerfificadas', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar CopiasCerfificadas', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar CopiasCerfificadas', 'guard_name' => 'sanctum']);
    }
}
