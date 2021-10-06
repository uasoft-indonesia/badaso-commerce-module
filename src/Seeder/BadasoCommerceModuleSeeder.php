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
        $this->call(CommerceMenusSeeder::class);
        $this->call(CommerceFixedMenuItemSeeder::class);
        $this->call(CommercePermissionsSeeder::class);
        $this->call(CommerceRolePermissionsSeeder::class);
        $this->call(CommerceSiteManagementSeeder::class);
    }
}
