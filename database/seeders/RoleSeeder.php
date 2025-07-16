<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'invitado']);
        Role::firstOrCreate(['name' => 'contable']);
        Role::firstOrCreate(['name' => 'gestor']);
        Role::firstOrCreate(['name' => 'cajero']);
        Role::firstOrCreate(['name' => 'gerente']);
    }
}
