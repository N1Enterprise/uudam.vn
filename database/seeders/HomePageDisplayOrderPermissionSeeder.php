<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class HomePageDisplayOrderPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $guardName = 'admin';
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $permissionNames = [
            'home-page-display-orders.index',
            'home-page-display-orders.store',
            'home-page-display-orders.update',
            'home-page-display-orders.delete',
        ];

        $permissions = [];

        foreach ($permissionNames as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();

            if (empty($permission)) {
                $permissions[] = [
                    'name' => $permissionName,
                    'guard_name' => $guardName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        Permission::insert($permissions);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
