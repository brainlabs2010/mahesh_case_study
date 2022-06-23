<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'    => User::factory()->create()->id,
            'product_id' => Product::factory()->create()->id,
            'session_id' => now()->timestamp,
            'qty'        => random_int(1, 10),
        ];
    }
}
