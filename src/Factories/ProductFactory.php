<?php

namespace Uasoft\Badaso\Module\Commerce\Factories;

use Bezhanov\Faker\ProviderCollectionHelper;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Uasoft\Badaso\Module\Commerce\Models\Product;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        ProviderCollectionHelper::addAllProvidersTo($this->faker);
        $product_name = $this->faker->paragraph(2);
        $slug = Str::slug($product_name);
        $image = 'https://loremflickr.com/300/300';

        $image_content = file_get_contents($image);
        Storage::put('files/product-image/'.$slug.'.jpg', $image_content);

        return [
            'name' => $product_name,
            'product_category_id' => rand(1, 25),
            'slug' => $slug,
            'product_image' => 'files/product-image/'.$slug.'.jpg',
            'desc' => $this->faker->paragraphs(rand(5, 10), true),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
