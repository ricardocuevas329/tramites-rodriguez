<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            's_codigo' => fake()->uuid(),
            's_nombres' => fake()->name(),
            's_paterno' => fake()->lastName(),
            's_user' => fake()->userName(),
            's_mail' => fake()->unique()->safeEmail(),
            'd_fecha_reg' => now(),
            's_pass' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'i_estado' => 1,
        ];
    }
    

      // 123456    $2y$10$TY.ZjUhy4KhyB5q9SIzpqOWJLzSNFmGGCnWWawmYvbxoNXiGfZ5sW
 
   /* public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }*/
}
