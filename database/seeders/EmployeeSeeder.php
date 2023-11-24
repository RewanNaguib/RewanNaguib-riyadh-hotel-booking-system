<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);

        $permissions = [
            'get rooms',
            'edit rooms status only',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
            $employeeRole->givePermissionTo($permission);
        }

        $user = \App\Models\User::create([
            'name' => 'Employee User',
            'email' => 'employee@example.com',
            'password' => Hash::make('EmployeePassword1*'),
        ]);

        $user->assignRole('employee');
    }
}
