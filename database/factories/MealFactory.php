<?php

namespace Database\Factories;

use App\Models\Meal;
use Illuminate\Database\Eloquent\Factories\Factory;

class MealFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Meal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $meals = ['排骨', '雞腿', '蝦捲', '控肉'];
        $staple = ['麵', '飯'];
        $price = [70 ,80 ,90 ,100];
        return [
            'meal_name' => $meals[array_rand($meals)] . $staple[array_rand($staple)] . (string)$this->faker->numberBetween(100, 999),
            'price' => $price[array_rand($price)],
            'description' => '香噴噴',
            'meal_img' => '',
            'status' => 1,
        ];
    }
}
