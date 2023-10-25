<?php

namespace Database\Seeders;

use App\Enum\InventoryConditionEnum;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DemoInventorySeeder extends Seeder
{
    private $faker;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $this->faker = Faker::create();

            DB::table('inventories')->truncate();

            $inventories = [];

            $products = DB::table('products')->pluck('primary_image', 'id')->toArray();

            $admin = Admin::find(1);

            for ($i = 0; $i < 100; $i++) {
                $num = $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 100, $max = 400);
                $productId = $this->faker->randomElement(array_keys($products));

                $inventories[] = [
                    'id' => $i + 1,
                    'title' => $this->faker->sentence,
                    'slug' => $this->faker->slug,
                    'product_id' => $productId,
                    'condition' => $this->faker->randomElement(InventoryConditionEnum::all()),
                    'condition_note' => $this->faker->realText,
                    'sku' => $this->faker->word.$i,
                    'status' => 1,
                    'key_features' => json_encode([
                        [ 'title' => $this->faker->sentence ],
                        [ 'title' => $this->faker->sentence ],
                        [ 'title' => $this->faker->sentence ],
                        [ 'title' => $this->faker->sentence ],
                        [ 'title' => $this->faker->sentence ],
                        [ 'title' => $this->faker->sentence ],
                        [ 'title' => $this->faker->sentence ]
                    ]),
                    'purchase_price' => $num,
                    'sale_price' => $num+rand(50, 200),
                    'offer_price' => rand(1, 0) ? $num+rand(1, 49) : Null,
                    'offer_start' => Carbon::Now()->format('Y-m-d h:i'),
                    'offer_end' => date('Y-m-d h:i', strtotime(rand(3, 22) . ' days')),
                    'stock_quantity' => rand(9,99),
                    'min_order_quantity' => 1,
                    'available_from' => now(),
                    'meta_title' => $this->faker->sentence,
                    'meta_description' => $this->faker->realText,
                    'image' => $products[$productId],
                    'created_by_type' => get_class($admin),
                    'created_by_id' => $admin->id,
                    'updated_by_type' => get_class($admin),
                    'updated_by_id' => $admin->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            DB::table('inventories')->insert($inventories);
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }
    }
}
