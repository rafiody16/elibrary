<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = [
            [
                'name_role' => 'Admin',
                'description' => 'Administrator with full access',
            ],
            [
                'name_role' => 'User',
                'description' => 'Regular user with limited access',
            ],
            [
                'name_role' => 'Member',
                'description' => 'Regular user with limited access',
            ],
        ];

        DB::table('roles')->insert($role);
    }
}
