<?php

namespace Uasoft\Badaso\Module\Commerce\Commands;

use Illuminate\Console\Command;
use Uasoft\Badaso\Module\Commerce\Events\OrderStateWasChanged;
use Uasoft\Badaso\Module\Commerce\Models\Order;

class BadasoDeleteExpiredOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'badaso-commerce:delete-expired-order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired order';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders = Order::select(['id', 'status', 'cancel_message', 'expired_at'])
            ->with('orderDetails.productDetail')
            ->whereDate('expired_at', '<=', now())
            ->get();

        foreach ($orders as $order) {
            foreach ($order->orderDetails as $key => $orderDetail) {
                $orderDetail->productDetail->quantity += $orderDetail->quantity;
                $orderDetail->productDetail->save();
            }

            $order->status = 'cancel';
            $order->cancel_message = 'Expired';
            $order->expired_at = null;
            $order->save();

            event(new OrderStateWasChanged(auth()->user(), $order, 'cancel'));
        }
        return 0;
    }
}
