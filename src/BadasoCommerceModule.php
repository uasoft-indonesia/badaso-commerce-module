<?php

namespace Uasoft\Badaso\Module\Commerce;

class BadasoCommerceModule
{
    protected $protected_tables = [
        'products',
        'product_details',
        'product_categories',
        'discounts',
        'orders',
        'order_details',
        'payment_details',
        'carts',
        'user_addresses',
        'user_payments',
        'payment_providers',
    ];

    public function getProtectedTables()
    {
        return $this->protected_tables;
    }
}
