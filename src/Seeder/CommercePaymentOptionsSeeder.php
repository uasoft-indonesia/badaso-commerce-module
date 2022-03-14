<?php

namespace Database\Seeders\Badaso\Commerce;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Uasoft\Badaso\Module\Commerce\Models\Payment;
use Uasoft\Badaso\Module\Commerce\Models\PaymentOption;

class CommercePaymentOptionsSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     *
     * @throws Exception
     */
    public function run()
    {
        DB::beginTransaction();

        try {
            $payments = [
                'bank-transfer' => [
                    0 => [
                        'slug' => 'manual-transfer',
                        'name' => 'Transfer Bank (Manual)',
                        'description' => null,
                        'image' => 'files/shares/money.svg',
                        'is_active' => 0,
                        'order' => 99,
                    ],
                ],
            ];

            foreach ($payments as $key => $value) {
                $payment = Payment::where('slug', $key)
                    ->first();

                if (isset($payment)) {
                    foreach ($value as $k => $v) {
                        PaymentOption::firstOrCreate([
                            'payment_id' => $payment->id,
                            'slug' => $v['slug'],
                            'name' => $v['name'],
                            'description' => $v['description'],
                            'image' => $v['image'],
                            'is_active' => $v['is_active'],
                            'order' => $v['order'],
                        ]);
                    }
                }
            }
        } catch (Exception $e) {
            throw new Exception('Exception occur '.$e);
            DB::rollBack();
        }

        DB::commit();
    }
}
