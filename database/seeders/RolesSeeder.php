<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Los roles que vamos a crear
        $roles = [
            'administrativo',
            'inspector',
            'cliente',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
