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
        'order_payments',
        'carts',
        'user_addresses',
    ];

    protected $protected_payments = [
        'card',
        'bank-transfer',
        'e-money',
        'direct-debit',
        'convenience-store',
        'cardless-credit'
    ];

    public function getProtectedTables()
    {
        return $this->protected_tables;
    }

    public function getProtectedPayments()
    {
        return $this->protected_payments;
    }
}
