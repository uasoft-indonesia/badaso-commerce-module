<?php

namespace Uasoft\Badaso\Module\Commerce\Controllers\PublicController;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Module\Commerce\Abstracts\BadasoPayment as AbstractsBadasoPayment;
use Uasoft\Badaso\Module\Commerce\Interfaces\BadasoPayment;
use Uasoft\Badaso\Module\Commerce\Models\Payment;
use Uasoft\Badaso\Module\Commerce\Models\PaymentOption;

class PaymentController extends Controller
{
    protected $slugs = [];

    public function __construct()
    {
        $payments_module_list = config('badaso-commerce.payments');

        foreach ($payments_module_list as $module) {
            $module_class = new $module();
            if ($module_class instanceof BadasoPayment && $module_class instanceof AbstractsBadasoPayment) {
                foreach ($module_class->getProtectedPaymentSlug() as $key => $slug) {
                    $this->slugs[] = $slug;
                }
            } else {
                throw new Exception("Class in badaso commerce payment config must be instance of BadasoPayment abstract & interface");
            }
        }
    }

    public function browse()
    {
        try {
            $payments = Payment::with(['options' => function ($query) {
                return $query->where('is_active', 1);
            }])->where('is_active', 1)->get();

            $data['payments'] = $payments->toArray();
            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function read(Request $request)
    {
        try {
            $request->validate([
                'slug' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\PaymentOption,slug',
            ]);

            $data['payment_option'] = PaymentOption::where('slug', $request->slug)->first();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }
}
