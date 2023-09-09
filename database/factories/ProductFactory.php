<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Enums\ProductStatus;
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
        $user = User::inRandomOrder()->first();
        $file = fake()->image(storage_path('app/public/products'), 640, 480, null, false);

        return [
            'name' => fake()->name(),
            'price' => fake()->numberBetween(1000, 100000),
            'created_by' => $user->id,
            'picture' => "products/$file",
            'status' => Arr::random([ProductStatus::ACTIVE(), ProductStatus::INACTIVE()]),
        ];
    }
}
