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
}
