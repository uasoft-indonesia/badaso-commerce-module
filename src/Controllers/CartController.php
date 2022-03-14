<?php

namespace Uasoft\Badaso\Module\Commerce\Controllers;

use Exception;
use Illuminate\Http\Request;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Module\Commerce\Models\Cart;

class CartController extends Controller
{
    public function browse(Request $request)
    {
        try {
            $request->validate([
                'page' => 'sometimes|required|integer',
                'limit' => 'sometimes|required|integer',
                'relation' => 'nullable',
            ]);

            if ($request->has('page') || $request->has('limit')) {
                $carts = Cart::when($request->relation, function ($query) use ($request) {
                    return $query->with(explode(',', $request->relation));
                })->paginate($request->limit);
            } else {
                $carts = Cart::when($request->relation, function ($query) use ($request) {
                    return $query->with(explode(',', $request->relation));
                })->get();
            }

            $data['carts'] = $carts->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function read(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Cart,id',
                'relation' => 'nullable',
            ]);

            $cart = Cart::when($request->relation, function ($query) use ($request) {
                return $query->with(explode(',', $request->relation));
            })->where('id', $request->id)->first();
            $data['cart'] = $cart->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }
}
