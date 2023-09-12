<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $admin = Admin::firstOrCreate([
            'name' => 'admin',
            'email' => 'admin@admin.com'
        ], [
            'password' => 'admin'
        ]);

        $role = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'admin',
        ]);

        $role->syncPermissions(Permission::where('guard_name', 'admin')->get());

        $admin->assignRole($role);
    }
}
