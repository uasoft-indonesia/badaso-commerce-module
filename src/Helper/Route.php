<?php

namespace Uasoft\Badaso\Module\Commerce\Helper;

class Route
{
    public static function getController($key)
    {
        // get config 'controllers' from config/badaso-commerce.php
        $controllers = config('badaso-commerce.controllers');

        // if the key is not found, return $key
        if (! isset($controllers[$key])) {
            return 'Uasoft\\Badaso\\Module\\Commerce\\Controllers\\'.$key;
        }

        // return the value of the key
        return $controllers[$key];
    }
}
