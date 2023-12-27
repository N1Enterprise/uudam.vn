<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitSystemSettingGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('system_setting_groups')->truncate();

        $now = now();

        $groups = [
            [
                'name' => 'System',
                'order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Securities',
                'order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Maintenance',
                'order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Email Setting',
                'order' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Shop Setting',
                'order' => 6,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Image',
                'order' => 7,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('system_setting_groups')->insert($groups);
    }
}
