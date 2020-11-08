<?php

namespace Database\Seeders;

use App\Models\Meal;
use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
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
                'meal_name' => '排骨飯',
                'price' => 70,
                'description' => '香噴噴',
                'meal_img' => '',
                'status' => 1,
            ],
            [
                'meal_name' => '雞腿飯',
                'price' => 90,
                'description' => '香噴噴',
                'meal_img' => '',
                'status' => 1,
            ],
            [
                'meal_name' => '蝦捲飯',
                'price' => 80,
                'description' => '香噴噴',
                'meal_img' => '',
                'status' => 1,
            ],
            [
                'meal_name' => '控肉飯',
                'price' => 70,
                'description' => '香噴噴',
                'meal_img' => '',
                'status' => 1,
            ]
        ];
        foreach ($data as $item) {
            Meal::create($item);
        }
    }
}
