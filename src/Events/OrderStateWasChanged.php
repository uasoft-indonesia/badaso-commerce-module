<?php

namespace Uasoft\Badaso\Module\Commerce\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Uasoft\Badaso\Models\User;
use Uasoft\Badaso\Module\Commerce\Models\Order;

class OrderStateWasChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $order;
    public $status;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Order $order, string $status)
    {
        $this->user = $user;
        $this->order = $order;
        $this->status = $status;
    }
}
