<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitCatalogSeeder extends Seeder
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
        CategoryGroup::truncate();
        Category::truncate();
        Product::truncate();

        $now = now();


    }
}
