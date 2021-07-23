<?php

namespace Database\Seeders\Badaso\Commerce;

use Illuminate\Database\Seeder;
use Uasoft\Badaso\Models\Configuration;

class CommerceSiteManagementSeeder extends Seeder
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
            $settings = [
                0 => [
                    'key' => 'commerceHasExpiredOrder',
                    'display_name' => 'Has Expired Order',
                    'value' => 1,
                    'details' => '{}',
                    'type' => 'switch',
                    'order' => 1,
                    'group' => 'commercePanel',
                    'can_delete' => 0,
                ],
                1 => [
                    'key' => 'commerceExpiredOrderDay',
                    'display_name' => 'Expired Order Day',
                    'value' => '1',
                    'details' => '{}',
                    'type' => 'number',
                    'order' => 2,
                    'group' => 'commercePanel',
                    'can_delete' => 0,
                ],
                2 => [
                    'key' => 'commerceLimitUserAddresses',
                    'display_name' => 'Limit User Addresses',
                    'value' => '3',
                    'details' => '{}',
                    'type' => 'number',
                    'order' => 3,
                    'group' => 'commercePanel',
                    'can_delete' => 0,
                ],
                3 => [
                    'key' => 'commerceUseFixRateShippingCost',
                    'display_name' => 'Use Fix Rate Shipping Cost',
                    'value' => 1,
                    'details' => '{}',
                    'type' => 'switch',
                    'order' => 4,
                    'group' => 'commercePanel',
                    'can_delete' => 0,
                ],
                4 => [
                    'key' => 'commerceFixRateShippingCost',
                    'display_name' => 'Fix Rate Shipping Cost',
                    'value' => '35000',
                    'details' => '{}',
                    'type' => 'number',
                    'order' => 5,
                    'group' => 'commercePanel',
                    'can_delete' => 0,
                ],
            ];

            foreach ($settings as $key => $value) {
                Configuration::where('key', $value['key'])->delete();
                Configuration::create($value);
            }
            \DB::commit();
        } catch (Exception $e) {
            throw new Exception('Exception occur '.$e);
            \DB::rollBack();
        }
    }
}
