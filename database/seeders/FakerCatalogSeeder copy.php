<?php

namespace Database\Seeders;

use App\Enum\ProductAttributeTypeEnum;
use App\Enum\ProductTypeEnum;
use App\Models\Admin;
use App\Models\BaseModel;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class FakerCatalogSeeder extends Seeder
{
    private $faker;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('category_groups')->truncate();
        DB::table('categories')->truncate();
        DB::table('products')->truncate();
        DB::table('attributes')->truncate();
        DB::table('attribute_values')->truncate();

        DB::beginTransaction();

        try {
            $this->faker = Faker::create();

            $catGroupsIds = $this->fakerCategoryGroups();
            $catsIds = $this->fakerCategories($catGroupsIds);
            $products = $this->fakerProducts($catsIds);
            $this->fakerAttribute();

            DB::commit();
        } catch (\Throwable $th) {
            dd($th->getMessage());
            DB::rollBack();
        }
    }

    protected function fakerProducts($catsIds)
    {
        $admin = Admin::find(1);

        $products = [];

        $createdAdminMorph = BaseModel::getMorphProperty('created_by', $admin);
        $updatedAdminMorph = BaseModel::getMorphProperty('updated_by', $admin);

        for ($i = 0; $i < 50; $i++) {
            $name = $this->faker->company;

            $minAmount = $this->faker->randomFloat(4, 20, 30);

            $products[] = array_merge([
                'name' => $name,
                'slug' => Str::slug($name).'-'.($i + 1),
                'code' => $this->faker->ean13(),
                'branch' => $this->faker->title(),
                'min_amount' => $minAmount,
                'max_amount' => $minAmount + 100,
                'type' => ProductTypeEnum::all()[array_rand([ProductTypeEnum::SIMPLE, ProductTypeEnum::VARIABLE])],
                'status' => 1,
                'primary_image' => 'https://uudam.vn/wp-content/uploads/2022/12/uat-kim-huong-de-thap-6-510x510.jpg',
                'media' => json_encode([
                    ['path' => 'https://uudam.vn/wp-content/uploads/2022/12/uat-kim-huong-de-thap-6-510x510.jpg'],
                    ['path' => 'https://uudam.vn/wp-content/uploads/2022/12/uat-kim-huong-de-thap-6-510x510.jpg'],
                    ['path' => 'https://uudam.vn/wp-content/uploads/2022/12/uat-kim-huong-de-thap-6-510x510.jpg'],
                    ['path' => 'https://uudam.vn/wp-content/uploads/2022/12/uat-kim-huong-de-thap-6-510x510.jpg'],
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ], $createdAdminMorph, $updatedAdminMorph);
        }

        DB::table('products')->insert($products);

        foreach (Product::all() as $product) {
            $catRelatedIds =  collect($catsIds)->random(3)->toArray();
            $product->categories()->sync($catRelatedIds);
        }
    }

    protected function fakerCategories($catGroupsIds)
    {
        $categories = [];

        for ($i = 0; $i < 50; $i++) {
            $name = $this->faker->company;

            $categories[] = [
                'name' => $name,
                'slug' => Str::slug($name).'-'.($i + 1),
                'category_group_id' => $catGroupsIds[array_rand($catGroupsIds)],
                'primary_image' => 'https://uudam.vn/wp-content/uploads/2022/12/uat-kim-huong-de-thap-6-510x510.jpg',
                'status' => 1,
                'order' => $i + 1,
                'featured' => 0,
                'meta_title' => $this->faker->sentence(20),
                'meta_description' => $this->faker->sentence(20),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('categories')->insert($categories);

        return DB::table('categories')->pluck('id')->toArray();
    }

    protected function fakerCategoryGroups()
    {
        $categoryGroups = [];

        for ($i = 0; $i < 50; $i++) {
            $name = $this->faker->company;

            $categoryGroups[] = [
                'name' => $name,
                'slug' => Str::slug($name).'-'.($i + 1),
                'primary_image' => 'https://uudam.vn/wp-content/uploads/2022/12/uat-kim-huong-de-thap-6-510x510.jpg',
                'order' => $i + 1,
                'status' => 1,
                'meta_title' => $this->faker->sentence(20),
                'meta_description' => $this->faker->sentence(20),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('category_groups')->insert($categoryGroups);

        return DB::table('category_groups')->pluck('id')->toArray();
    }

    protected function fakerAttribute()
    {
        DB::table('attributes')->insert([
            [
                'id' => 1,
                'name' => 'Color',
                'attribute_type' => ProductAttributeTypeEnum::COLOR_PATTERN,
                'status' => 1,
                'order' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Size',
                'attribute_type' => ProductAttributeTypeEnum::SELECT,
                'status' => 1,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('attribute_values')->insert([
            [
                'id' => 1,
                'value' => '#FFFFFF',
                'attribute_id' => 1,
                'order' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'value' => '#000000',
                'attribute_id' => 1,
                'order' => 2,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'value' => 'S',
                'attribute_id' => 2,
                'order' => 3,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'value' => 'XL',
                'attribute_id' => 2,
                'order' => 4,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'value' => 'XXL',
                'attribute_id' => 2,
                'order' => 5,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
