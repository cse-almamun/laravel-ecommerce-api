<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(5),
            'description' => $this->faker->paragraph(4),
            'price' => $this->faker->randomNumber(2),
            'image' => $this->faker->imageUrl(400, 400)
        ];
    }
}
