<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\BaseModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoBlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::table('post_categories')->truncate();
            DB::table('posts')->truncate();

            $admin = Admin::find(1);

            $inventories = DB::table('inventories')->pluck('id')->toArray();

            $categories = [
                [
                    'id' => 1,
                    'name' => 'Hướng Dẫn',
                    'slug' => 'uudam-hung-dan',
                    'image' => 'https://dharmacrafts.com/cdn/shop/articles/custom_resized_9da6075c-5f54-47b1-a526-4375a5ad9912.jpg?v=1696541703',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo, tempore culpa exercitationem, harum quidem saepe accusantium minima nihil, enim ad consequuntur autem temporibus et perferendis beatae voluptas. Hic officiis tempora inventore eum eaque eius minus earum itaque aspernatur, obcaecati tempore quasi error eos amet ut commodi eligendi omnis reprehenderit atque, quidem quisquam, aliquam sequi illo. Ipsam rem saepe nostrum itaque quae sit deleniti neque deserunt cupiditate iusto aliquam qui assumenda minus velit natus dolorem facilis laudantium eum voluptates accusantium, libero quasi nulla ratione? Eum quas dolorem minus. Quo, fugit consequuntur. Inventore, suscipit tempora sit ullam dolor aliquid explicabo consequatur ducimus.',
                    'order' => 1,
                    'status' => 1,
                    'display_on_frontend' => 1,
                    'meta_title' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex, eligendi.',
                    'meta_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae, eaque?',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            $posts = [
                [
                    'id' => 1,
                    'name' => 'Caring for “Self” and “Others” - Koun Franz',
                    'slug' => 'caring-for-self-and-others-koun-franz',
                    'image' => 'https://dharmacrafts.com/cdn/shop/articles/custom_resized_9da6075c-5f54-47b1-a526-4375a5ad9912.jpg?v=1696541703',
                    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi ipsam alias ut dolorum modi laboriosam veritatis necessitatibus dolores laborum at.',
                    'content' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deserunt incidunt impedit fugiat enim aliquam, pariatur dolore adipisci ipsum, accusamus rerum commodi quo debitis perspiciatis laboriosam natus magni ex? Architecto animi cupiditate ea distinctio sed vel placeat quisquam? Odio, labore accusantium, dicta error perspiciatis dolorum beatae quo unde inventore odit ipsam recusandae ipsum mollitia? Voluptates ea beatae exercitationem distinctio, ipsum, sapiente esse quisquam quibusdam vel nihil libero nesciunt necessitatibus, consectetur totam. Vitae voluptatem reiciendis neque autem perspiciatis cumque adipisci perferendis consectetur necessitatibus aspernatur atque aperiam blanditiis quasi, minima expedita libero quidem molestiae? Corporis, magni doloremque hic rerum repellendus minima numquam similique.',
                    'post_at' => now(),
                    'post_category_id' => 1,
                    'created_by_type' => get_class($admin),
                    'created_by_id' => BaseModel::getModelKey($admin),
                    'updated_by_type' => get_class($admin),
                    'updated_by_id' => BaseModel::getModelKey($admin),
                    'order' => 1,
                    'status' => 1,
                    'display_on_frontend' => 1,
                    'linked_inventories' => json_encode($inventories),
                    'meta_title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis, minima.',
                    'meta_description' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Expedita, eaque.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 2,
                    'name' => 'What Do You Think About All Day? - Koun Franz',
                    'slug' => 'what-do-you-think-about-all-day-koun-franz',
                    'image' => 'https://dharmacrafts.com/cdn/shop/articles/koun_what_do_you_think_about.jpg?v=1695653795',
                    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi ipsam alias ut dolorum modi laboriosam veritatis necessitatibus dolores laborum at.',
                    'content' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deserunt incidunt impedit fugiat enim aliquam, pariatur dolore adipisci ipsum, accusamus rerum commodi quo debitis perspiciatis laboriosam natus magni ex? Architecto animi cupiditate ea distinctio sed vel placeat quisquam? Odio, labore accusantium, dicta error perspiciatis dolorum beatae quo unde inventore odit ipsam recusandae ipsum mollitia? Voluptates ea beatae exercitationem distinctio, ipsum, sapiente esse quisquam quibusdam vel nihil libero nesciunt necessitatibus, consectetur totam. Vitae voluptatem reiciendis neque autem perspiciatis cumque adipisci perferendis consectetur necessitatibus aspernatur atque aperiam blanditiis quasi, minima expedita libero quidem molestiae? Corporis, magni doloremque hic rerum repellendus minima numquam similique.',
                    'post_at' => now(),
                    'post_category_id' => 1,
                    'created_by_type' => get_class($admin),
                    'created_by_id' => BaseModel::getModelKey($admin),
                    'updated_by_type' => get_class($admin),
                    'updated_by_id' => BaseModel::getModelKey($admin),
                    'order' => 2,
                    'status' => 1,
                    'display_on_frontend' => 1,
                    'linked_inventories' => json_encode($inventories),
                    'meta_title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis, minima.',
                    'meta_description' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Expedita, eaque.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 3,
                    'name' => 'Principles of Form - Koun Franz',
                    'slug' => 'principles-of-form-by-koun-franz',
                    'image' => 'https://dharmacrafts.com/cdn/shop/articles/custom_resized_b7c11c8b-f858-4b6f-9c72-401185661354.jpg?v=1694699258&width=1500',
                    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi ipsam alias ut dolorum modi laboriosam veritatis necessitatibus dolores laborum at.',
                    'content' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deserunt incidunt impedit fugiat enim aliquam, pariatur dolore adipisci ipsum, accusamus rerum commodi quo debitis perspiciatis laboriosam natus magni ex? Architecto animi cupiditate ea distinctio sed vel placeat quisquam? Odio, labore accusantium, dicta error perspiciatis dolorum beatae quo unde inventore odit ipsam recusandae ipsum mollitia? Voluptates ea beatae exercitationem distinctio, ipsum, sapiente esse quisquam quibusdam vel nihil libero nesciunt necessitatibus, consectetur totam. Vitae voluptatem reiciendis neque autem perspiciatis cumque adipisci perferendis consectetur necessitatibus aspernatur atque aperiam blanditiis quasi, minima expedita libero quidem molestiae? Corporis, magni doloremque hic rerum repellendus minima numquam similique.',
                    'post_at' => now(),
                    'post_category_id' => 1,
                    'created_by_type' => get_class($admin),
                    'created_by_id' => BaseModel::getModelKey($admin),
                    'updated_by_type' => get_class($admin),
                    'updated_by_id' => BaseModel::getModelKey($admin),
                    'order' => 3,
                    'status' => 1,
                    'display_on_frontend' => 1,
                    'linked_inventories' => json_encode($inventories),
                    'meta_title' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis, minima.',
                    'meta_description' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Expedita, eaque.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            DB::table('post_categories')->insert($categories);
            DB::table('posts')->insert($posts);
        } catch (\Exception $ex) {
            dd($ex);
            logger('Fail to run seeder demo collection with message', [
                'message' => $ex->getMessage(),
                'trace' => $ex->getTraceAsString()
            ]);
        }
    }
}
