<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $permissions = [
            'get rooms',
            'create rooms',
            'update rooms',
            'delete rooms',
            'edit rooms status only',
            'get users',
            'create users',
            'update users',
            'delete users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
            $adminRole->givePermissionTo($permission);
        }

        $user = \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('AdminPassword1*'),
        ]);

        $user->assignRole('admin');
    }
}
