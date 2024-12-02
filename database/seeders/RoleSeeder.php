<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $ownerRole = Role::create([
            'name' => 'owner'
        ]);

        $fundraiserRole = Role::create([
            'name' => 'fundraiser'
        ]);

        $userOwner = User::create([
            'name' => 'angga risky',
            'avatar' => 'images/default-avatar.png',
            'email' => 'angga@owner.com',
            'password' => bcrypt(123456789)
        ]);

        $userOwner->assignRole($ownerRole);
    }
}