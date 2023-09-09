<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Role::create([
        //     'name' => 'admin',
        //     'guard_name' => 'api',
        // ]);

        // Role::create([
        //     'name' => 'user',
        //     'guard_name' => 'api',
        // ]);

        Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => 'user',
            'guard_name' => 'web',
        ]);
    }
}
