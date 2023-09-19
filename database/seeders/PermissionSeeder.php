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
            // User
            'users.index',
            'users.show',
            'users.update',
            'users.action',

            // Admin
            'admins.index',
            'admins.store',
            'admins.update',
            'admins.export',

            // Role
            'roles.index',
            'roles.store',
            'roles.update',

            // System setting
            'system-settings.index',
            'system-settings.store',
            'system-settings.update',
            'system-settings.create-group',
            'system-settings.create-key',
            'system-settings.delete',
            'system-settings.clear-cache',
            'system-settings.import',
            'system-settings.export',

            'category-groups.index',
            'category-groups.store',
            'category-groups.update',
            'category-groups.delete',

            'categories.index',
            'categories.store',
            'categories.update',
            'categories.delete',

            'products.index',
            'products.store',
            'products.update',
            'products.delete',

            'attributes.index',
            'attributes.store',
            'attributes.update',
            'attributes.delete',
            'attribute-values.index',
            'attribute-values.store',
            'attribute-values.update',
            'attribute-values.delete',
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
