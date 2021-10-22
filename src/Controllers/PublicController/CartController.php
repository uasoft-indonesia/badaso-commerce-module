<?php

namespace Uasoft\Badaso\Module\Commerce\Controllers\PublicController;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Module\Commerce\Models\Cart;
use Uasoft\Badaso\Module\Commerce\Models\ProductDetail;

class CartController extends Controller
{
    public function browse(Request $request)
    {
        try {
            $user_id = auth()->id();

            $data['carts'] = Cart::with(['productDetail.product.productCategory', 'productDetail.discount'])->where('user_id', $user_id)->get()->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function add(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\ProductDetail',
                'quantity' => "required|min:0|integer"
            ], [
                'id.required' => 'You have to select one of the variant!'
            ]);

            $product_detail = ProductDetail::where('id', $request->id)->first();

            if ($product_detail->quantity <= 0) {
                return ApiResponse::failed(__('badaso_commerce::validation.stock_not_available'));
            }

            $cart = Cart::where('user_id', auth()->id())->where('product_detail_id', $request->id)->first();

            if (empty($cart)) {
                Cart::create([
                    'product_detail_id' => $request->id,
                    'user_id' => auth()->id(),
                    'quantity' => $request->quantity,
                ]);
            } else {
                if ($cart->quantity + $request->quantity > $product_detail->quantity) {
                    return ApiResponse::failed(__('badaso_commerce::validation.stock_not_available'));
                }

                Cart::where('user_id', auth()->id())->where('product_detail_id', $request->id)->update([
                    'product_detail_id' => $request->id,
                    'user_id' => auth()->id(),
                    'quantity' => $cart->quantity + $request->quantity,
                ]);
            }

            DB::commit();
            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollback();
            return ApiResponse::failed($e);
        }
    }

    public function edit(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Cart',
                'quantity' => "required|min:0|integer"
            ]);

            $cart = Cart::where('id', $request->id)->where('user_id', auth()->user()->id)->first();

            $product_detail = ProductDetail::where('id', $cart->product_detail_id)->first();

            if ($request->quantity > $product_detail->quantity) {
                return ApiResponse::failed(__('badaso_commerce::validation.stock_not_available'));
            }

            $cart = Cart::where('id', $request->id)->update([
                'quantity' => $request->quantity
            ]);

            DB::commit();
            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollback();
            return ApiResponse::failed($e);
        }
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Cart',
            ]);

            $cart = Cart::where('id', $request->id)->delete();

            DB::commit();
            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollback();
            return ApiResponse::failed($e);
        }
    }

    public function validate(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required',
            ]);

            $id_list = explode(',', $request->ids);

            foreach ($id_list as $key => $id) {
                $cart = Cart::find($id);
                if (is_null($cart)) {
                    return ApiResponse::success(['cart' => false]);
                }
            }
            return ApiResponse::success(['cart' => true]);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }
}
