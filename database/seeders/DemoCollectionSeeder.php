<?php

namespace Database\Seeders;

use App\Models\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::table('collections')->truncate();

            $collections = [
                [
                    'id' => 1,
                    'name' => 'NEW ARRIVALS',
                    'slug' => 'newest-products',
                    'primary_image' => 'https://dharmacrafts.com/cdn/shop/files/custom_resized_9111204f-f11a-4f92-960e-a7a728d7d55f.jpg?v=1697472696&width=710',
                    'cta_label' => 'SHOP NOW',
                    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, quas quos laborum maxime sequi omnis quidem quo nisi voluptates consectetur est, labore nihil recusandae! Est esse perspiciatis quisquam. Alias a facilis ducimus quibusdam fuga, perspiciatis deleniti cupiditate magni autem sunt quisquam enim nemo labore quae quaerat consectetur amet voluptates neque cum! Et mollitia dolorem atque perspiciatis. Quisquam tenetur rerum suscipit. Impedit quas alias quam rerum libero corrupti odio delectus velit blanditiis nisi a natus eos officiis expedita sapiente laborum optio omnis voluptatem, quidem repellat recusandae? Ad laborum id fuga ipsum, libero sapiente, ea at quod quasi incidunt dicta exercitationem autem?',
                    'featured' => 1,
                    'status' => 1,
                    'display_on_frontend' => 0,
                    'order' => 1,
                    'meta_title' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda, aperiam.',
                    'meta_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui, est?',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 2,
                    'name' => 'BEST SELLERS',
                    'slug' => 'best-selling-products',
                    'primary_image' => 'https://dharmacrafts.com/cdn/shop/files/Dharmagirl1_mobile_3dabb17a-9460-41a7-b09f-99a2d3127df5.jpg?v=1638786103',
                    'cta_label' => 'SHOP NOW',
                    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, quas quos laborum maxime sequi omnis quidem quo nisi voluptates consectetur est, labore nihil recusandae! Est esse perspiciatis quisquam. Alias a facilis ducimus quibusdam fuga, perspiciatis deleniti cupiditate magni autem sunt quisquam enim nemo labore quae quaerat consectetur amet voluptates neque cum! Et mollitia dolorem atque perspiciatis. Quisquam tenetur rerum suscipit. Impedit quas alias quam rerum libero corrupti odio delectus velit blanditiis nisi a natus eos officiis expedita sapiente laborum optio omnis voluptatem, quidem repellat recusandae? Ad laborum id fuga ipsum, libero sapiente, ea at quod quasi incidunt dicta exercitationem autem?',
                    'featured' => 1,
                    'status' => 1,
                    'display_on_frontend' => 0,
                    'order' => 2,
                    'meta_title' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda, aperiam.',
                    'meta_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui, est?',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 3,
                    'name' => 'YOGA COLLECTION',
                    'slug' => 'yoga-supplies',
                    'primary_image' => 'https://dharmacrafts.com/cdn/shop/files/Dharma_ColoradoGRigg_2023_LieslClarkPhoto096_e29558f6-1c0a-4cb3-a70d-2b611f7eed24.jpg?v=1677775393&width=710',
                    'cta_label' => 'SHOP NOW',
                    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, quas quos laborum maxime sequi omnis quidem quo nisi voluptates consectetur est, labore nihil recusandae! Est esse perspiciatis quisquam. Alias a facilis ducimus quibusdam fuga, perspiciatis deleniti cupiditate magni autem sunt quisquam enim nemo labore quae quaerat consectetur amet voluptates neque cum! Et mollitia dolorem atque perspiciatis. Quisquam tenetur rerum suscipit. Impedit quas alias quam rerum libero corrupti odio delectus velit blanditiis nisi a natus eos officiis expedita sapiente laborum optio omnis voluptatem, quidem repellat recusandae? Ad laborum id fuga ipsum, libero sapiente, ea at quod quasi incidunt dicta exercitationem autem?',
                    'featured' => 1,
                    'status' => 1,
                    'display_on_frontend' => 0,
                    'order' => 3,
                    'meta_title' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda, aperiam.',
                    'meta_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui, est?',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // Display on Frontend
                [
                    'id' => 4,
                    'name' => 'Meditation Cushions',
                    'slug' => 'cushions-and-benches',
                    'primary_image' => 'https://dharmacrafts.com/cdn/shop/files/Dharma_1-crop.jpg?v=1697477248&width=710',
                    'cta_label' => '',
                    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, quas quos laborum maxime sequi omnis quidem quo nisi voluptates consectetur est, labore nihil recusandae! Est esse perspiciatis quisquam. Alias a facilis ducimus quibusdam fuga, perspiciatis deleniti cupiditate magni autem sunt quisquam enim nemo labore quae quaerat consectetur amet voluptates neque cum! Et mollitia dolorem atque perspiciatis. Quisquam tenetur rerum suscipit. Impedit quas alias quam rerum libero corrupti odio delectus velit blanditiis nisi a natus eos officiis expedita sapiente laborum optio omnis voluptatem, quidem repellat recusandae? Ad laborum id fuga ipsum, libero sapiente, ea at quod quasi incidunt dicta exercitationem autem?',
                    'featured' => 0,
                    'status' => 1,
                    'display_on_frontend' => 1,
                    'order' => 4,
                    'meta_title' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda, aperiam.',
                    'meta_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui, est?',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 5,
                    'name' => 'Altar Tables and Chests',
                    'slug' => 'altar-tables-and-chests-quality-meditation-supplies',
                    'primary_image' => 'https://dharmacrafts.com/cdn/shop/files/f620_2_300x_db592211-172f-497b-8b15-0d4e62de2f29.png?v=1659366641',
                    'cta_label' => '',
                    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, quas quos laborum maxime sequi omnis quidem quo nisi voluptates consectetur est, labore nihil recusandae! Est esse perspiciatis quisquam. Alias a facilis ducimus quibusdam fuga, perspiciatis deleniti cupiditate magni autem sunt quisquam enim nemo labore quae quaerat consectetur amet voluptates neque cum! Et mollitia dolorem atque perspiciatis. Quisquam tenetur rerum suscipit. Impedit quas alias quam rerum libero corrupti odio delectus velit blanditiis nisi a natus eos officiis expedita sapiente laborum optio omnis voluptatem, quidem repellat recusandae? Ad laborum id fuga ipsum, libero sapiente, ea at quod quasi incidunt dicta exercitationem autem?',
                    'featured' => 0,
                    'status' => 1,
                    'display_on_frontend' => 1,
                    'order' => 5,
                    'meta_title' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda, aperiam.',
                    'meta_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui, est?',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 6,
                    'name' => 'Buddha Statues',
                    'slug' => 'buddha-statues',
                    'primary_image' => 'https://dharmacrafts.com/cdn/shop/files/Resized_1.jpg?v=1697477302',
                    'cta_label' => '',
                    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, quas quos laborum maxime sequi omnis quidem quo nisi voluptates consectetur est, labore nihil recusandae! Est esse perspiciatis quisquam. Alias a facilis ducimus quibusdam fuga, perspiciatis deleniti cupiditate magni autem sunt quisquam enim nemo labore quae quaerat consectetur amet voluptates neque cum! Et mollitia dolorem atque perspiciatis. Quisquam tenetur rerum suscipit. Impedit quas alias quam rerum libero corrupti odio delectus velit blanditiis nisi a natus eos officiis expedita sapiente laborum optio omnis voluptatem, quidem repellat recusandae? Ad laborum id fuga ipsum, libero sapiente, ea at quod quasi incidunt dicta exercitationem autem?',
                    'featured' => 0,
                    'status' => 1,
                    'display_on_frontend' => 1,
                    'order' => 6,
                    'meta_title' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda, aperiam.',
                    'meta_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui, est?',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 7,
                    'name' => 'Incense and Burners',
                    'slug' => 'incense-burners-meditation-supplies-dharmacrafts',
                    'primary_image' => 'https://dharmacrafts.com/cdn/shop/files/LCP2532JLSakura012a.jpg?v=1685720340',
                    'cta_label' => '',
                    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, quas quos laborum maxime sequi omnis quidem quo nisi voluptates consectetur est, labore nihil recusandae! Est esse perspiciatis quisquam. Alias a facilis ducimus quibusdam fuga, perspiciatis deleniti cupiditate magni autem sunt quisquam enim nemo labore quae quaerat consectetur amet voluptates neque cum! Et mollitia dolorem atque perspiciatis. Quisquam tenetur rerum suscipit. Impedit quas alias quam rerum libero corrupti odio delectus velit blanditiis nisi a natus eos officiis expedita sapiente laborum optio omnis voluptatem, quidem repellat recusandae? Ad laborum id fuga ipsum, libero sapiente, ea at quod quasi incidunt dicta exercitationem autem?',
                    'featured' => 0,
                    'status' => 1,
                    'display_on_frontend' => 1,
                    'order' => 7,
                    'meta_title' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda, aperiam.',
                    'meta_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui, est?',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 8,
                    'name' => 'Wellness',
                    'slug' => 'wellness-products',
                    'primary_image' => 'https://dharmacrafts.com/cdn/shop/files/facial-rollers.jpg?v=1659365670&width=710',
                    'cta_label' => '',
                    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, quas quos laborum maxime sequi omnis quidem quo nisi voluptates consectetur est, labore nihil recusandae! Est esse perspiciatis quisquam. Alias a facilis ducimus quibusdam fuga, perspiciatis deleniti cupiditate magni autem sunt quisquam enim nemo labore quae quaerat consectetur amet voluptates neque cum! Et mollitia dolorem atque perspiciatis. Quisquam tenetur rerum suscipit. Impedit quas alias quam rerum libero corrupti odio delectus velit blanditiis nisi a natus eos officiis expedita sapiente laborum optio omnis voluptatem, quidem repellat recusandae? Ad laborum id fuga ipsum, libero sapiente, ea at quod quasi incidunt dicta exercitationem autem?',
                    'featured' => 0,
                    'status' => 1,
                    'display_on_frontend' => 1,
                    'order' => 8,
                    'meta_title' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda, aperiam.',
                    'meta_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui, est?',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 9,
                    'name' => 'Jewelry and Gifts',
                    'slug' => 'jewelry-and-gifts-buddhist-gift-guide-and-gift-cards',
                    'primary_image' => 'https://dharmacrafts.com/cdn/shop/files/2321_e1949bcd-56f7-4fa0-a4c4-11dc2fe0b99a.jpg?v=1685719719',
                    'cta_label' => '',
                    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, quas quos laborum maxime sequi omnis quidem quo nisi voluptates consectetur est, labore nihil recusandae! Est esse perspiciatis quisquam. Alias a facilis ducimus quibusdam fuga, perspiciatis deleniti cupiditate magni autem sunt quisquam enim nemo labore quae quaerat consectetur amet voluptates neque cum! Et mollitia dolorem atque perspiciatis. Quisquam tenetur rerum suscipit. Impedit quas alias quam rerum libero corrupti odio delectus velit blanditiis nisi a natus eos officiis expedita sapiente laborum optio omnis voluptatem, quidem repellat recusandae? Ad laborum id fuga ipsum, libero sapiente, ea at quod quasi incidunt dicta exercitationem autem?',
                    'featured' => 0,
                    'status' => 1,
                    'display_on_frontend' => 1,
                    'order' => 9,
                    'meta_title' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda, aperiam.',
                    'meta_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui, est?',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            DB::table('collections')->insert($collections);

            $inventories = DB::table('inventories')->pluck('id')->toArray();

            foreach (Collection::all() as $item) {
                $item->inventories()->sync($inventories);
            }
        } catch (\Exception $ex) {
            dd($ex);
            logger('Fail to run seeder demo collection with message', [
                'message' => $ex->getMessage(),
                'trace' => $ex->getTraceAsString()
            ]);
        }
    }
}
