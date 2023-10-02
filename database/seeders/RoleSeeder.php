<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['merchant', 'agency', 'super_admin'];
        foreach($roles as $key => $role)
        {
            Role::create([
                'id' => $key + 1,
                'role_name' => $role,
            ]);
        }
    }
}
