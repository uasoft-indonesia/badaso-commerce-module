<?php

namespace Database\Seeders\Badaso\Commerce;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Uasoft\Badaso\Module\Commerce\Models\Payment;

class CommercePaymentsSeeder extends Seeder
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
        DB::beginTransaction();

        try {
            $payments = [
                0 => [
                    'slug' => 'card',
                    'name' => 'Credit Card',
                    'is_active' => 1
                ],
                1 => [
                    'slug' => 'bank-transfer',
                    'name' => 'Bank Transfer',
                    'is_active' => 1
                ],
                2 => [
                    'slug' => 'e-money',
                    'name' => 'E-Money',
                    'is_active' => 1
                ],
                3 => [
                    'slug' => 'direct-debit',
                    'name' => 'Direct Debit',
                    'is_active' => 1
                ],
                4 => [
                    'slug' => 'convenience-store',
                    'name' => 'Convenience Store',
                    'is_active' => 1
                ],
                5 => [
                    'slug' => 'cardless-credit',
                    'name' => 'Cardless Credit',
                    'is_active' => 1
                ],
            ];

            foreach ($payments as $key => $value) {
                Payment::firstOrCreate($value);
            }
        } catch (Exception $e) {
            throw new Exception('Exception occur '.$e);
            DB::rollBack();
        }

        DB::commit();
    }
}
