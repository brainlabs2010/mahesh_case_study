<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
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
        $file = UploadedFile::fake()->image('product.jpg');
        Storage::fake('products');
        $productImage = Storage::putFileAs('products', $file, $file->getClientOriginalName());
        return [
            'name'          => $this->faker->name(),
            'description'   => 'some random string',
            'category_id'   => Category::factory()->create()->id,
            'product_image' => $productImage,
            'price'         => 2000,
            'deleted_at'    => null,
        ];
    }
}
