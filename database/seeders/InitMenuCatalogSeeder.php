<?php

namespace Database\Seeders;

use App\Models\MenuGroup;
use App\Models\MenuSubGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitMenuCatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MenuGroup::truncate();
        MenuSubGroup::truncate();

        $now = now();

        $groups = [
            [
                'name' => 'Menu Group 1',
                'redirect_url' => 'https://domain.com',
                'order' => 1,
                'status' => 1,
            ],
            [
                'name' => 'Menu Group 2',
                'redirect_url' => 'https://domain.com',
                'order' => 2,
                'status' => 1,
            ],
            [
                'name' => 'Menu Group 3',
                'redirect_url' => 'https://domain.com',
                'order' => 3,
                'status' => 1,
            ],
            [
                'name' => 'Menu Group 4',
                'redirect_url' => 'https://domain.com',
                'order' => 4,
                'status' => 1,
            ],
        ];

        $subGroups = [
            [
                'name' => 'Menu Sub Group 1 - A',
                'redirect_url' => 'https://domain.com',
                'menu_group_id' => 1,
                'order' => 1,
                'status' => 1,
            ],
            [
                'name' => 'Menu Sub Group 1 - B',
                'redirect_url' => 'https://domain.com',
                'menu_group_id' => 1,
                'order' => 2,
                'status' => 1,
            ],
            [
                'name' => 'Menu Sub Group 1 - C',
                'redirect_url' => 'https://domain.com',
                'menu_group_id' => 1,
                'order' => 3,
                'status' => 1,
            ],

            [
                'name' => 'Menu Sub Group 2 - A',
                'redirect_url' => 'https://domain.com',
                'menu_group_id' => 2,
                'order' => 1,
                'status' => 1,
            ],
            [
                'name' => 'Menu Sub Group 2 - B',
                'redirect_url' => 'https://domain.com',
                'menu_group_id' => 2,
                'order' => 2,
                'status' => 1,
            ],
            [
                'name' => 'Menu Sub Group 2 - C',
                'redirect_url' => 'https://domain.com',
                'menu_group_id' => 2,
                'order' => 3,
                'status' => 1,
            ],

            [
                'name' => 'Menu Sub Group 3 - A',
                'redirect_url' => 'https://domain.com',
                'menu_group_id' => 3,
                'order' => 1,
                'status' => 1,
            ],
            [
                'name' => 'Menu Sub Group 3 - B',
                'redirect_url' => 'https://domain.com',
                'menu_group_id' => 3,
                'order' => 2,
                'status' => 1,
            ],
            [
                'name' => 'Menu Sub Group 3 - C',
                'redirect_url' => 'https://domain.com',
                'menu_group_id' => 3,
                'order' => 3,
                'status' => 1,
            ],

            [
                'name' => 'Menu Sub Group 4 - A',
                'redirect_url' => 'https://domain.com',
                'menu_group_id' => 4,
                'order' => 1,
                'status' => 1,
            ],
            [
                'name' => 'Menu Sub Group 4 - B',
                'redirect_url' => 'https://domain.com',
                'menu_group_id' => 4,
                'order' => 2,
                'status' => 1,
            ],
            [
                'name' => 'Menu Sub Group 4 - C',
                'redirect_url' => 'https://domain.com',
                'menu_group_id' => 4,
                'order' => 3,
                'status' => 1,
            ],
        ];

        DB::table('menu_groups')->insert($groups);
        DB::table('menu_sub_groups')->insert($subGroups);
    }
}
