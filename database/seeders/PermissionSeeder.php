<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permission::truncate();

        $permissionNames = [
            'users.index',
            'users.show',
            'users.update',
            'users.action',

            'admins.index',
            'admins.store',
            'admins.update',
            'admins.export',

            'roles.index',
            'roles.store',
            'roles.update',
        ];


        foreach ($permissionNames as $permissionName) {
            $permissions[] = [
                'name' => $permissionName,
                'guard_name' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Permission::insert($permissions);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
