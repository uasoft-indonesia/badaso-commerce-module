<?php

namespace Uasoft\Badaso\Module\Commerce\Facades;

use Illuminate\Support\Facades\Facade;

class BadasoCommerceModule extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'badaso-commerce-module';
    }
}
