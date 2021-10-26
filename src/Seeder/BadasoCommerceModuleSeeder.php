<?php

namespace Database\Seeders\Badaso\Commerce;

use Illuminate\Database\Seeder;

class BadasoCommerceModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CommerceMenusSeeder::class,
            CommerceFixedMenuItemSeeder::class,
            CommercePermissionsSeeder::class,
            CommerceRolePermissionsSeeder::class,
            CommerceSiteManagementSeeder::class,
            CommercePaymentsSeeder::class,
            CommercePaymentOptionsSeeder::class,
        ]);
    }
}
