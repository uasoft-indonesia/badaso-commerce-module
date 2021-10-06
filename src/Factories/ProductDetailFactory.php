<?php

namespace Uasoft\Badaso\Module\Commerce\Factories;

use Bezhanov\Faker\ProviderCollectionHelper;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Uasoft\Badaso\Module\Commerce\Models\ProductDetail;

class ProductDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        ProviderCollectionHelper::addAllProvidersTo($this->faker);
        $product_name = $this->faker->word();
        $slug = Str::slug($product_name);
        $image = 'https://picsum.photos/seed/'. $slug .'/300/300';
        
        $image_content = file_get_contents($image);
        Storage::put('files/product-image/' . $slug . '.jpg', $image_content);

        return [
            'name' => $product_name,
            'quantity' => $this->faker->randomNumber(5),
            'price' => $this->faker->numberBetween(10000, 10000000),
            'SKU' => $slug,
            'product_image' => 'files/product-image/' . $slug . '.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
