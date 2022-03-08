<?php

namespace Uasoft\Badaso\Module\Commerce\Factories;

use Bezhanov\Faker\ProviderCollectionHelper;
use Illuminate\Database\Eloquent\Factories\Factory;
use Uasoft\Badaso\Module\Commerce\Models\Discount;

class DiscountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Discount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        ProviderCollectionHelper::addAllProvidersTo($this->faker);

        if ($this->faker->boolean()) {
            $discount_type = 'fixed';
            $fixed = $this->faker->numberBetween(1000, 30000);
            $percent = null;
        } else {
            $discount_type = 'percent';
            $fixed = null;
            $percent = $this->faker->numberBetween(1, 100);
        }

        return [
            'name' => $this->faker->productName,
            'desc' => $this->faker->paragraphs(3, true),
            'discount_type' => $discount_type,
            'discount_percent' => $percent,
            'discount_fixed' => $fixed,
            'active' => $this->faker->boolean(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
