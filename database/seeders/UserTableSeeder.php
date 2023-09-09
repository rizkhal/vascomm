<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'username' => 'user',
            'name' => 'Rizkal Lamaau',
            'email' => 'user@mail.com',
        ])->assignRole(Role::firstWhere('name', 'user'));

        User::factory()->create([
            'username' => 'admin',
            'name' => 'John Doe',
            'email' => 'admin@mail.com',
        ])->assignRole(Role::firstWhere('name', 'admin'));
    }
}
