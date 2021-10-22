<?php

namespace Uasoft\Badaso\Module\Commerce\Interfaces;

use Illuminate\Http\Request;
use Uasoft\Badaso\Helpers\ApiResponse;

interface BadasoPayment
{
    /**
     * Get all payment slugs
     *
     * @return Array List of all payment options
     */
    public function getPaymentSlug();

    /**
     * Get all protected payment slugs
     *
     * @return Array List of all protected payment options
     */
    public function getProtectedPaymentSlug();
}
