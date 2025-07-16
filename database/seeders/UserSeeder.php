<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear 1 usuario admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        $admin->assignRole('admin');

        // Crear 10 usuarios de prueba con roles aleatorios (excepto admin)
        User::factory(10)->create()->each(function ($user) {
            $roles = ['invitado', 'contable', 'gestor', 'cajero', 'gerente'];
            $user->assignRole(fake()->randomElement($roles));
        });
    }
}
