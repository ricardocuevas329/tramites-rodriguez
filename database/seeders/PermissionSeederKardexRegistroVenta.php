<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionSeederKardexRegistroVenta extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // EXTRAPROTOCOLAR

        // Kardex
        Permission::create(['name' => 'Modulo Kardex', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar Kardex', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar Kardex', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear Kardex', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar Kardex', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar Kardex', 'guard_name' => 'sanctum']);

        // Registro Venta
        Permission::create(['name' => 'Modulo RegistroVenta', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar RegistroVenta', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar RegistroVenta', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear RegistroVenta', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar RegistroVenta', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar RegistroVenta', 'guard_name' => 'sanctum']);
    }
}
