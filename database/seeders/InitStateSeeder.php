<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // DB::table('states')->truncate();

        // $states = json_decode(file_get_contents(__DIR__ . '/data/states.json'), true);

        // $now = now();

        // foreach ($states as $state) {
        //     DB::table('states')->insert([
        //         'name' => data_get($state, 'name'),
        //         'country_id' => data_get($state, 'country_id'),
        //         'country_code' => data_get($state, 'country_code'),
        //         'iso2' => data_get($state, 'iso2'),
        //         'latitude' => data_get($state, 'latitude'),
        //         'longitude' => data_get($state, 'longitude'),
        //         'created_at' => $now,
        //         'updated_at' => $now,
        //     ]);
        // }

        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
