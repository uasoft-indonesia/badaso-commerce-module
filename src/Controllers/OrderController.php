<?php

namespace Uasoft\Badaso\Module\Commerce\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Module\Commerce\Events\OrderStateWasChanged;
use Uasoft\Badaso\Module\Commerce\Models\Order;

class OrderController extends Controller
{
    public function browse(Request $request)
    {
        try {
            $request->validate([
                'page' => 'sometimes|required|integer',
                'limit' => 'sometimes|required|integer',
                'relation' => 'nullable'
            ]);

            $orders = Order::when($request->relation, function ($query) use ($request) {
                return $query->with(explode(',', $request->relation));
            })->orderBy('id', 'desc')->paginate($request->limit ?? 10);
            
            $data['orders'] = $orders->toArray();
            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function read(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Order,id',
                'relation' => 'nullable'
            ]);

            $order = Order::with('user', 'orderDetails.productDetail.product', 'orderPayment')
                ->where('id', $request->id)
                ->first();
            $data['order'] = $order->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function confirm(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Order,id',
            ]);

            $order = Order::find($request->id);
            if (!is_null($order->expired_at) && now()->greaterThanOrEqualTo(Carbon::create($order->expired_at))) {
                foreach ($order->orderDetails as $key => $orderDetail) {
                    $orderDetail->productDetail->quantity += $orderDetail->quantity;
                    $orderDetail->productDetail->save();
                }

                $order->status = 'cancel';
                $order->expired_at = null;
                $order->save();

                return ApiResponse::failed('Order is already expired.');
            }

            if ($order->status == 'waitingSellerConfirmation') {
                $order->status = 'process';
                $order->expired_at = null;
                $order->save();

                event(new OrderStateWasChanged(auth()->user(), $order));

                return ApiResponse::success();
            }

            return ApiResponse::failed();
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function reject(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Order,id',
                'cancel_message' => 'required|string|max:255',
            ]);

            $order = Order::find($request->id);

            if (in_array($order->status, ['waitingSellerConfirmation', 'waitingBuyerPayment'])) {
                foreach ($order->orderDetails as $key => $orderDetail) {
                    $orderDetail->productDetail->quantity += $orderDetail->quantity;
                    $orderDetail->productDetail->save();
                }

                $order->status = 'cancel';
                $order->cancel_message = $request->cancel_message;
                $order->expired_at = null;
                $order->save();

                event(new OrderStateWasChanged(auth()->user(), $order));

                return ApiResponse::success();
            }

            return ApiResponse::failed('Invalid request');
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function ship(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Order,id',
                'tracking_number' => 'required|alpha_num'
            ]);

            $order = Order::find($request->id);
            if ($order->status = 'process') {
                $order->status = 'delivering';
                $order->tracking_number = $request->tracking_number;
                $order->save();

                event(new OrderStateWasChanged(auth()->user(), $order));

                return ApiResponse::success();
            }

            return ApiResponse::failed();
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function done(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Order,id'
            ]);

            $order = Order::find($request->id);
            if ($order->status = 'delivering') {
                $order->status = 'done';
                $order->save();

                event(new OrderStateWasChanged(auth()->user(), $order));

                return ApiResponse::success();
            }

            return ApiResponse::failed();
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }
}
