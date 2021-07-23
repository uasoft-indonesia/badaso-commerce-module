<?php

namespace Database\Seeders\Badaso\Commerce;

use Illuminate\Database\Seeder;
use Uasoft\Badaso\Models\Menu;
use Uasoft\Badaso\Models\MenuItem;

class CommerceFixedMenuItemSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @throws Exception
     *
     * @return void
     */
    public function run()
    {
        \DB::beginTransaction();

        try {
            $menu_id = Menu::where('key', 'commerce-module')->first()->id;

            $menu_items = [
                0 => [
                    'menu_id' => $menu_id,
                    'title' => 'Products',
                    'url' => '/product',
                    'target' => '_self',
                    'icon_class' => 'inventory',
                    'color' => '',
                    'parent_id' => null,
                    'order' => 1,
                    'permissions' => 'browse_products',
                ],
                1 => [
                    'menu_id' => $menu_id,
                    'title' => 'Product Categories',
                    'url' => '/product-category',
                    'target' => '_self',
                    'icon_class' => 'category',
                    'color' => '',
                    'parent_id' => null,
                    'order' => 2,
                    'permissions' => 'browse_product_categories',
                ],
                2 => [
                    'menu_id' => $menu_id,
                    'title' => 'Discounts',
                    'url' => '/discount',
                    'target' => '_self',
                    'icon_class' => 'local_offer',
                    'color' => '',
                    'parent_id' => null,
                    'order' => 3,
                    'permissions' => 'browse_discounts',
                ],
                3 => [
                    'menu_id' => $menu_id,
                    'title' => 'Orders',
                    'url' => '/order',
                    'target' => '_self',
                    'icon_class' => 'shopping_basket',
                    'color' => '',
                    'parent_id' => null,
                    'order' => 4,
                    'permissions' => 'browse_orders',
                ],
                4 => [
                    'menu_id' => $menu_id,
                    'title' => 'Payment Provider',
                    'url' => '/payment-provider',
                    'target' => '_self',
                    'icon_class' => 'credit_card',
                    'color' => '',
                    'parent_id' => null,
                    'order' => 5,
                    'permissions' => 'browse_payment_providers',
                ],
                5 => [
                    'menu_id' => $menu_id,
                    'title' => 'User Cart',
                    'url' => '/cart',
                    'target' => '_self',
                    'icon_class' => 'shopping_cart',
                    'color' => '',
                    'parent_id' => null,
                    'order' => 6,
                    'permissions' => 'browse_carts',
                ],
                6 => [
                    'menu_id' => $menu_id,
                    'title' => 'User Addresses',
                    'url' => '/user-address',
                    'target' => '_self',
                    'icon_class' => 'contact_mail',
                    'color' => '',
                    'parent_id' => null,
                    'order' => 7,
                    'permissions' => 'browse_user_addresses',
                ],
                7 => [
                    'menu_id' => $menu_id,
                    'title' => 'Commerce Configuration',
                    'url' => '/commerce-config',
                    'target' => '_self',
                    'icon_class' => 'desktop_mac',
                    'color' => '',
                    'parent_id' => null,
                    'order' => 8,
                    'permissions' => 'browse_commerce_configurations',
                ]
            ];

            $new_menu_items = [];
            foreach ($menu_items as $key => $value) {
                $menu_item = MenuItem::where('menu_id', $value['menu_id'])
                        ->where('url', $value['url'])
                        ->first();

                if (isset($menu_item)) {
                    continue;
                }

                MenuItem::create($value);
            }
        } catch (Exception $e) {
            throw new Exception('Exception occur '.$e);
            \DB::rollBack();
        }

        \DB::commit();
    }
}
