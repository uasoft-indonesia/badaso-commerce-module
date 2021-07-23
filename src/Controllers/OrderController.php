<?php

namespace Uasoft\Badaso\Module\Commerce\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
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

            $order = Order::when($request->relation, function ($query) use ($request) {
                return $query->with(explode(',', $request->relation));
            })->where('id', $request->id)->first();
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
            $order->status = 2;
            $order->expired_at = null;
            $order->save();

            return ApiResponse::success();
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function reject(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Order,id',
            ]);

            $order = Order::find($request->id);
            $order->status = -1;
            $order->expired_at = null;
            $order->save();

            return ApiResponse::success();
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function ship(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Order,id',
            ]);

            $order = Order::find($request->id);
            $order->status = 3;
            $order->save();

            return ApiResponse::success();
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function trackingNumber(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Order,id',
                'tracking_number' => 'required'
            ]);

            $order = Order::find($request->id);
            $order->tracking_number = $request->tracking_number;
            $order->save();

            return ApiResponse::success();
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
            $order->status = 4;
            $order->save();

            return ApiResponse::success();
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }
}
