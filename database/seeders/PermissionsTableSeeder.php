<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'get rooms']);
        Permission::create(['name' => 'create rooms']);
        Permission::create(['name' => 'edit rooms']);
        Permission::create(['name' => 'delete rooms']);
        Permission::create(['name' => 'edit rooms status only']);
        Permission::create(['name' => 'get users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);

    }
}
