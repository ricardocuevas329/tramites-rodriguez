<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run()
    {
        $seeders = [
            RoleSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,
            PermissionSeederCartaDiligencia::class,
            PermissionSeederRegistroFirmasCopiasCertificadas::class,
            PermissionSeederRegistroDeposito::class,
            PermissionSeederKardexRegistroVenta::class,
        ];

        foreach ($seeders as $seeder) {
            try {
                $this->call($seeder);
            } catch (\Exception $e) {
                echo 'Error al ejecutar ' . $seeder . ': ' . $e->getMessage() . "\n";
            }
        }
    }


}
