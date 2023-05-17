<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'title_ar' => 'title_ar',
                'title_en' => 'title_en',
                'image' => 'image',
                'status' => 'ACTIVE',
                'parent_id' => null,
            ],
            [
                'title_ar' => 'title_ar',
                'title_en' => 'title_en',
                'image' => 'image',
                'status' => 'ACTIVE',
                'parent_id' => null,
            ],
            [
                'title_ar' => 'title_ar',
                'title_en' => 'title_en',
                'image' => 'image',
                'status' => 'ACTIVE',
                'parent_id' => null,
            ],
            [
                'title_ar' => 'title_ar',
                'title_en' => 'title_en',
                'image' => 'image',
                'status' => 'ACTIVE',
                'parent_id' => null,
            ],
            [
                'title_ar' => 'title_ar',
                'title_en' => 'title_en',
                'image' => 'image',
                'status' => 'ACTIVE',
                'parent_id' => null,
            ],
            [
                'title_ar' => 'title_ar',
                'title_en' => 'title_en',
                'image' => 'image',
                'status' => 'ACTIVE',
                'parent_id' => null,
            ],
            [
                'title_ar' => 'title_ar',
                'title_en' => 'title_en',
                'image' => 'image',
                'status' => 'ACTIVE',
                'parent_id' => null,
            ],
            [
                'title_ar' => 'title_ar',
                'title_en' => 'title_en',
                'image' => 'image',
                'status' => 'ACTIVE',
                'parent_id' => '1',
            ],
            [
                'title_ar' => 'title_ar',
                'title_en' => 'title_en',
                'image' => 'image',
                'status' => 'ACTIVE',
                'parent_id' => '2',
            ],
            [
                'title_ar' => 'title_ar',
                'title_en' => 'title_en',
                'image' => 'image',
                'status' => 'ACTIVE',
                'parent_id' => '3',
            ],
        ];

        foreach ($data as $key => $value) {
            Category::create([
                'title_ar' => $value['title_ar'],
                'title_en' => $value['title_en'],
                'image' => $value['image'],
                'status' => $value['status'],
                'parent_id' => $value['parent_id'],
            ]);
        }
    }
}
