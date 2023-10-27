<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(DemoCatalogSeeder::class);
        // $this->call(DemoInventorySeeder::class);
        // $this->call(DemoCollectionSeeder::class);
        // $this->call(DemoBlogSeeder::class);
        $this->call(DemoMenuSeeder::class);
    }
}
