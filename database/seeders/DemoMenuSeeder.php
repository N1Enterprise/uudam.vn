<?php

namespace Database\Seeders;

use App\Enum\MenuTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::table('menu_groups')->truncate();
            DB::table('menu_sub_groups')->truncate();
            DB::table('menus')->truncate();
            DB::table('menu_sub_group_menus')->truncate();

            $now = now();

            $menuGroups = [
                [
                    'id' => 1,
                    'name' => 'Meditation Cushions',
                    'redirect_url' => 'https://dharmacrafts.com/collections/cushions-and-benches',
                    'order' => 1,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 2,
                    'name' => 'Statues',
                    'redirect_url' => 'https://dharmacrafts.com/collections/statues',
                    'order' => 2,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 3,
                    'name' => 'Meditation Supplies',
                    'redirect_url' => 'https://dharmacrafts.com/collections/meditation-supplies-cushions-incense-gongs-and-more',
                    'order' => 3,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ];

            $menuSubGroups = [
                // Meditation Cushions
                [
                    'id' => 1,
                    'name' => 'Zafu Pillows',
                    'redirect_url' => '',
                    'menu_group_id' => 1,
                    'params' => json_encode([
                        'submenu_columns' => 1,
                        'item_type' => 'link-list-image'
                    ]),
                    'order' => 1,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 2,
                    'name' => 'Zabuton Pillows',
                    'redirect_url' => '',
                    'menu_group_id' => 1,
                    'params' => json_encode([
                        'submenu_columns' => 1,
                        'item_type' => 'link-list-image'
                    ]),
                    'order' => 2,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 3,
                    'name' => 'Support',
                    'redirect_url' => '',
                    'menu_group_id' => 1,
                    'params' => json_encode([
                        'submenu_columns' => 1,
                        'item_type' => 'link-list-image'
                    ]),
                    'order' => 3,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 4,
                    'name' => 'Bolsters',
                    'redirect_url' => '',
                    'menu_group_id' => 1,
                    'params' => json_encode([
                        'submenu_columns' => 1,
                        'item_type' => 'link-list-image'
                    ]),
                    'order' => 4,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 5,
                    'name' => 'Dharma Kids',
                    'redirect_url' => '',
                    'menu_group_id' => 1,
                    'params' => json_encode([
                        'submenu_columns' => 1,
                        'item_type' => 'link-list-image'
                    ]),
                    'order' => 5,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                // Statues
                [
                    'id' => 6,
                    'name' => 'Statues',
                    'redirect_url' => '',
                    'menu_group_id' => 2,
                    'params' => json_encode([
                        'submenu_columns' => 1,
                        'item_type' => 'link-list-image'
                    ]),
                    'order' => 6,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],

                [
                    'id' => 7,
                    'name' => 'Statues 2',
                    'redirect_url' => '',
                    'menu_group_id' => 2,
                    'params' => json_encode([
                        'submenu_columns' => 1,
                        'hide_name' => false,
                        'item_type' => 'link-list-image'
                    ]),
                    'order' => 7,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],

                [
                    'id' => 8,
                    'name' => 'Statues Has Blog',
                    'redirect_url' => '',
                    'menu_group_id' => 2,
                    'params' => json_encode([
                        'submenu_columns' => 2,
                        'hide_name' => true,
                        'image_type' => 'fit-wide',
                        'item_type' => 'featured-article',
                    ]),
                    'order' => 8,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],

                // Meditation Supplies
                [
                    'id' => 9,
                    'name' => 'General Supplies',
                    'redirect_url' => '',
                    'menu_group_id' => 3,
                    'params' => json_encode([
                        'submenu_columns' => 1
                    ]),
                    'order' => 9,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 10,
                    'name' => 'Incense and Burners',
                    'redirect_url' => '',
                    'menu_group_id' => 3,
                    'params' => json_encode([
                        'submenu_columns' => 1
                    ]),
                    'order' => 10,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 11,
                    'name' => 'Your Meditation Space',
                    'redirect_url' => '',
                    'menu_group_id' => 3,
                    'params' => json_encode([
                        'submenu_columns' => 1
                    ]),
                    'order' => 11,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 12,
                    'name' => 'Healing',
                    'redirect_url' => '',
                    'menu_group_id' => 3,
                    'params' => json_encode([
                        'submenu_columns' => 1
                    ]),
                    'order' => 12,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 13,
                    'name' => 'Meditation Benches',
                    'redirect_url' => '',
                    'menu_group_id' => 3,
                    'params' => json_encode([
                        'submenu_columns' => 1
                    ]),
                    'order' => 13,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ];

            $collections = DB::table('collections')->pluck('name', 'id')->toArray();
            $collectionsIds = array_keys($collections);
            $collectionsNames = array_values($collections);

            $inventories = DB::table('inventories')->pluck('title', 'id')->toArray();
            $inventoriesIds = array_keys($inventories);
            $inventoriesNames = array_values($inventories);

            $posts = DB::table('posts')->pluck('name', 'id')->toArray();
            $postsIds = array_keys($posts);
            $postsNames = array_values($posts);

            $menusSubGroup1 = [
                [
                    'id' => 1,
                    'name' => $collectionsNames[array_rand($collectionsNames)],
                    'is_new' => 0,
                    'type' => MenuTypeEnum::COLLECTION,
                    'collection_id' => $collectionsIds[array_rand($collectionsIds)],
                    'inventory_id' => null,
                    'post_id' => null,
                    'order' => 1,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 2,
                    'name' => $collectionsNames[array_rand($collectionsNames)],
                    'is_new' => 0,
                    'type' => MenuTypeEnum::COLLECTION,
                    'collection_id' => $collectionsIds[array_rand($collectionsIds)],
                    'inventory_id' => null,
                    'post_id' => null,
                    'order' => 2,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 3,
                    'name' => $collectionsNames[array_rand($collectionsNames)],
                    'is_new' => 0,
                    'type' => MenuTypeEnum::COLLECTION,
                    'collection_id' => $collectionsIds[array_rand($collectionsIds)],
                    'inventory_id' => null,
                    'post_id' => null,
                    'order' => 3,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 4,
                    'name' => $collectionsNames[array_rand($collectionsNames)],
                    'is_new' => 1,
                    'type' => MenuTypeEnum::COLLECTION,
                    'collection_id' => $collectionsIds[array_rand($collectionsIds)],
                    'inventory_id' => null,
                    'post_id' => null,
                    'order' => 4,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ];

            $menusSubGroup2 = [
                [
                    'id' => 5,
                    'name' => $collectionsNames[array_rand($collectionsNames)],
                    'is_new' => 0,
                    'type' => MenuTypeEnum::COLLECTION,
                    'collection_id' => $collectionsIds[array_rand($collectionsIds)],
                    'inventory_id' => null,
                    'post_id' => null,
                    'order' => 5,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 6,
                    'name' => $collectionsNames[array_rand($collectionsNames)],
                    'is_new' => 0,
                    'type' => MenuTypeEnum::COLLECTION,
                    'collection_id' => $collectionsIds[array_rand($collectionsIds)],
                    'inventory_id' => null,
                    'post_id' => null,
                    'order' => 6,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 7,
                    'name' => $collectionsNames[array_rand($collectionsNames)],
                    'is_new' => 1,
                    'type' => MenuTypeEnum::COLLECTION,
                    'collection_id' => $collectionsIds[array_rand($collectionsIds)],
                    'inventory_id' => null,
                    'post_id' => null,
                    'order' => 7,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ];

            $menusSubGroup3 = [
                [
                    'id' => 8,
                    'name' => $collectionsNames[array_rand($collectionsNames)],
                    'is_new' => 0,
                    'type' => MenuTypeEnum::COLLECTION,
                    'collection_id' => $collectionsIds[array_rand($collectionsIds)],
                    'inventory_id' => null,
                    'post_id' => null,
                    'order' => 8,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 9,
                    'name' => $collectionsNames[array_rand($collectionsNames)],
                    'is_new' => 0,
                    'type' => MenuTypeEnum::COLLECTION,
                    'collection_id' => $collectionsIds[array_rand($collectionsIds)],
                    'inventory_id' => null,
                    'post_id' => null,
                    'order' => 9,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 10,
                    'name' => $collectionsNames[array_rand($collectionsNames)],
                    'is_new' => 0,
                    'type' => MenuTypeEnum::COLLECTION,
                    'collection_id' => $collectionsIds[array_rand($collectionsIds)],
                    'inventory_id' => null,
                    'post_id' => null,
                    'order' => 10,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 11,
                    'name' => $collectionsNames[array_rand($collectionsNames)],
                    'is_new' => 1,
                    'type' => MenuTypeEnum::COLLECTION,
                    'collection_id' => $collectionsIds[array_rand($collectionsIds)],
                    'inventory_id' => null,
                    'post_id' => null,
                    'order' => 11,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            ];

            $menusSubGroup4 = [
                [
                    'id' => 12,
                    'name' => $collectionsNames[array_rand($collectionsNames)],
                    'is_new' => 0,
                    'type' => MenuTypeEnum::COLLECTION,
                    'collection_id' => $collectionsIds[array_rand($collectionsIds)],
                    'inventory_id' => null,
                    'post_id' => null,
                    'order' => 12,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 13,
                    'name' => $collectionsNames[array_rand($collectionsNames)],
                    'is_new' => 0,
                    'type' => MenuTypeEnum::COLLECTION,
                    'collection_id' => $collectionsIds[array_rand($collectionsIds)],
                    'inventory_id' => null,
                    'post_id' => null,
                    'order' => 13,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 14,
                    'name' => $collectionsNames[array_rand($collectionsNames)],
                    'is_new' => 0,
                    'type' => MenuTypeEnum::COLLECTION,
                    'collection_id' => $collectionsIds[array_rand($collectionsIds)],
                    'inventory_id' => null,
                    'post_id' => null,
                    'order' => 14,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 15,
                    'name' => $collectionsNames[array_rand($collectionsNames)],
                    'is_new' => 1,
                    'type' => MenuTypeEnum::COLLECTION,
                    'collection_id' => $collectionsIds[array_rand($collectionsIds)],
                    'inventory_id' => null,
                    'post_id' => null,
                    'order' => 15,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ];

            $menusSubGroup5 = [
                [
                    'id' => 16,
                    'name' => $inventoriesNames[array_rand($inventoriesNames)],
                    'is_new' => 0,
                    'type' => MenuTypeEnum::INVENTORY,
                    'collection_id' => null,
                    'inventory_id' => $inventoriesIds[array_rand($inventoriesIds)],
                    'post_id' => null,
                    'order' => 16,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 17,
                    'name' => $inventoriesNames[array_rand($inventoriesNames)],
                    'is_new' => 0,
                    'type' => MenuTypeEnum::INVENTORY,
                    'collection_id' => null,
                    'inventory_id' => $inventoriesIds[array_rand($inventoriesIds)],
                    'post_id' => null,
                    'order' => 17,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 18,
                    'name' => $inventoriesNames[array_rand($inventoriesNames)],
                    'is_new' => 0,
                    'type' => MenuTypeEnum::INVENTORY,
                    'collection_id' => null,
                    'inventory_id' => $inventoriesIds[array_rand($inventoriesIds)],
                    'post_id' => null,
                    'order' => 18,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ];

            $menusSubGroup6 = [
                [
                    'id' => 19,
                    'name' => $collectionsNames[array_rand($collectionsNames)],
                    'is_new' => 0,
                    'type' => MenuTypeEnum::COLLECTION,
                    'collection_id' => $collectionsIds[array_rand($collectionsIds)],
                    'inventory_id' => null,
                    'post_id' => null,
                    'order' => 19,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 20,
                    'name' => $collectionsNames[array_rand($collectionsNames)],
                    'is_new' => 0,
                    'type' => MenuTypeEnum::COLLECTION,
                    'collection_id' => $collectionsIds[array_rand($collectionsIds)],
                    'inventory_id' => null,
                    'post_id' => null,
                    'order' => 20,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 21,
                    'name' => $collectionsNames[array_rand($collectionsNames)],
                    'is_new' => 0,
                    'type' => MenuTypeEnum::COLLECTION,
                    'collection_id' => $collectionsIds[array_rand($collectionsIds)],
                    'inventory_id' => null,
                    'post_id' => null,
                    'order' => 21,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 22,
                    'name' => $collectionsNames[array_rand($collectionsNames)],
                    'is_new' => 1,
                    'type' => MenuTypeEnum::COLLECTION,
                    'collection_id' => $collectionsIds[array_rand($collectionsIds)],
                    'inventory_id' => null,
                    'post_id' => null,
                    'order' => 22,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 23,
                    'name' => $collectionsNames[array_rand($collectionsNames)],
                    'is_new' => 1,
                    'type' => MenuTypeEnum::COLLECTION,
                    'collection_id' => $collectionsIds[array_rand($collectionsIds)],
                    'inventory_id' => null,
                    'post_id' => null,
                    'order' => 23,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 24,
                    'name' => $collectionsNames[array_rand($collectionsNames)],
                    'is_new' => 1,
                    'type' => MenuTypeEnum::COLLECTION,
                    'collection_id' => $collectionsIds[array_rand($collectionsIds)],
                    'inventory_id' => null,
                    'post_id' => null,
                    'order' => 24,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 25,
                    'name' => $collectionsNames[array_rand($collectionsNames)],
                    'is_new' => 1,
                    'type' => MenuTypeEnum::COLLECTION,
                    'collection_id' => $collectionsIds[array_rand($collectionsIds)],
                    'inventory_id' => null,
                    'post_id' => null,
                    'order' => 25,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 26,
                    'name' => $postsNames[array_rand($postsNames)],
                    'is_new' => 1,
                    'type' => MenuTypeEnum::POST,
                    'collection_id' => null,
                    'inventory_id' => null,
                    'post_id' => $postsIds[array_rand($postsIds)],
                    'order' => 26,
                    'meta' => null,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ];

            $menuCatalogs = [
                1 => [1, 2, 3, 4],
                2 => [5, 6, 7],
                3 => [8, 9, 10, 11],
                4 => [12, 13, 14, 15],
                5 => [16, 17, 18],
                6 => [19, 20, 21, 22],
                7 => [23, 24, 25],
                8 => [26]
            ];

            DB::table('menu_groups')->insert($menuGroups);
            DB::table('menu_sub_groups')->insert($menuSubGroups);

            DB::table('menus')->insert(array_merge(
                $menusSubGroup1,
                $menusSubGroup2,
                $menusSubGroup3,
                $menusSubGroup4,
                $menusSubGroup5,
                $menusSubGroup6,
            ));

            foreach ($menuCatalogs as $key => $menus) {
                foreach ($menus as $id) {
                    DB::table('menu_sub_group_menus')->insert([
                        'menu_sub_group_id' => $key,
                        'menu_id' => $id,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }
        } catch (\Exception $ex) {
            dd($ex);
            logger('Fail to run seeder demo menus with message', [
                'message' => $ex->getMessage(),
                'trace' => $ex->getTraceAsString()
            ]);
        }
    }
}
