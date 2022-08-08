<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Admin',
                'display_name' => 'Admin',
                'description' => 'Can access all features!'
            ],
            [
                'name' => 'AdminFinance',
                'display_name' => 'AdminFinance',
                'description' => 'Can access limited features!'
            ],
            [
                'name' => 'AdminIt',
                'display_name' => 'Admin',
                'description' => 'Can access all features!'
            ],
            [
                'name' => 'AdminMarketing',
                'display_name' => 'AdminFinance',
                'description' => 'Can access limited features!'
            ],
            [
                'name' => 'UserFinance',
                'display_name' => 'AdminFinance',
                'description' => 'Can access limited features!'
            ],
            [
                'name' => 'UserIt',
                'display_name' => 'Admin',
                'description' => 'Can access all features!'
            ],
            [
                'name' => 'UserMarketing',
                'display_name' => 'AdminFinance',
                'description' => 'Can access limited features!'
            ],
        ];

        foreach ($roles as $key => $value) {
            $role = Role::create([
                'name' => $value['name'],
                'display_name' => $value['display_name'],
                'description' => $value['description']
            ]);

            // User::first()->attachRole($role);
        }
    }
}
