<?php

namespace Uasoft\Badaso\Module\Commerce\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Uasoft\Badaso\Module\Commerce\Events\GoogleAnalytics;
use Uasoft\Badaso\Module\Commerce\Events\OrderStateWasChanged;
use Uasoft\Badaso\Module\Commerce\Listeners\SendHit;
use Uasoft\Badaso\Module\Commerce\Listeners\SendNotificationToUser;

class BadasoCommerceModuleEventServiceProvider extends EventServiceProvider
{
    protected $listen = [
        OrderStateWasChanged::class => [
            SendNotificationToUser::class,
        ],
        GoogleAnalytics::class => [
            SendHit::class,
        ],
    ];
}
