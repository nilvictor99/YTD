<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'super usuario']);

        $user = User::create([
            'name' => config('owner-system.user.name'),
            'email' => config('owner-system.user.email'),
            'password' => Hash::make(config('owner-system.user.password')),
        ]);
        $user->assignRole($role);
    }
}
