<?php

namespace Uasoft\Badaso\Module\Commerce;

use Uasoft\Badaso\Module\Commerce\Abstracts\BadasoPayment as AbstractsBadasoPayment;
use Uasoft\Badaso\Module\Commerce\Interfaces\BadasoPayment;

class BadasoCommerceModule extends AbstractsBadasoPayment implements BadasoPayment
{
    protected $protected_tables = [
        'products',
        'product_details',
        'product_categories',
        'discounts',
        'orders',
        'order_details',
        'order_payments',
        'carts',
        'user_addresses',
    ];

    protected $protected_payments = [
        'manual-transfer'
    ];

    public function getPaymentSlug()
    {
        return $this->protected_payments;
    }

    public function getProtectedTables()
    {
        return $this->protected_tables;
    }

    public function getProtectedPaymentSlug()
    {
        return $this->protected_payments;
    }
}
