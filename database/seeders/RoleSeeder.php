<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // evitar poner espacios en BLANCO al final del nombre de cada Permiso o Rol
        // ejecutar este para limpiar la caché:   php artisan permission:cache-reset | php artisan cache:forget spatie.permission.cache | php artisan cache:forget spatie.role.cache
        $superadmin = Role::create(['name' => 'superadmin', 'guard_name' => 'sanctum']);
        $administrador = Role::create(['name' => 'administrador', 'guard_name' => 'sanctum']);
        $operador = Role::create(['name' => 'operador', 'guard_name' => 'sanctum']);
        $consultas = Role::create(['name' => 'consultas', 'guard_name' => 'sanctum']);
        //Permission::create(['name' => 'Modulo Personal', 'guard_name' => 'sanctum'])->syncRoles([$administrador, $operador, $consultas]);

    }
}
