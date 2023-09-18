<?php

namespace Database\Seeders;

use App\Enum\ProductAttributeTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $now = now();

        DB::table('attributes')->insert([
            [
                'id' => 1,
                'name' => 'Color',
                'attribute_type' => ProductAttributeTypeEnum::COLOR_PATTERN,
                'status' => 1,
                'order' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'Size',
                'attribute_type' => ProductAttributeTypeEnum::SELECT,
                'status' => 1,
                'order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
