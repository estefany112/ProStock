<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'admin@proserve.com')->first();
        $role = Role::where('name', 'admin')->first();

        if ($user && $role) {
            $user->roles()->syncWithoutDetaching([$role->id]);
        }
    }
}
