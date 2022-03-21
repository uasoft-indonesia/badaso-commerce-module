<?php

namespace Uasoft\Badaso\Module\Commerce\Controllers\PublicController;

use Illuminate\Http\Request;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Module\Commerce\Interfaces\BadasoPayment;

class CheckoutController extends Controller implements BadasoPayment
{
    public function checkout(Request $request)
    {
    }

    public function pay(Request $request)
    {
    }

    /**
     * Get all payment slugs.
     *
     * @return array List of all payment options
     */
    public function getPaymentSlug()
    {
    }

    /**
     * Get all protected payment slugs.
     *
     * @return array List of all protected payment options
     */
    public function getProtectedPaymentSlug()
    {
    }
}
