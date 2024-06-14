<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Traits\GenerateCode;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{

    use GenerateCode;
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$tableName = (new User())->getTable();
        /*User::create([
            //'s_codigo' =>  $this->generateCode($tableName, 's_codigo', 8, 'PE'),
            's_nombres' => fake()->name(),
            's_paterno' => fake()->lastName(),
            's_user' => 'superadmin',
            's_mail' => fake()->unique()->safeEmail(),
            'd_fecha_reg' => now(),
            's_pass' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'i_estado' => 1,
        ])->assignRole('superadmin');*/
      $user =   User::find("PE000035")->assignRole('superadmin');
      $user->s_pass = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
      $user->save();
    }
}
