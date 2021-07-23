<?php

namespace Uasoft\Badaso\Module\Commerce\Controllers\PublicController;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Helpers\Config;
use Uasoft\Badaso\Module\Commerce\Models\Cart;
use Uasoft\Badaso\Module\Commerce\Models\Discount;
use Uasoft\Badaso\Module\Commerce\Models\Order;
use Uasoft\Badaso\Module\Commerce\Models\OrderDetail;
use Uasoft\Badaso\Module\Commerce\Models\ProductDetail;
use Uasoft\Badaso\Module\Commerce\Models\UserAddress;
use UniSharp\LaravelFilemanager\Controllers\ItemsController;
use UniSharp\LaravelFilemanager\Controllers\UploadController;

class OrderController extends Controller
{
    public function browse(Request $request)
    {
        try {
            $orders = Order::where('user_id', auth()->user()->id)->get();
            
            $data['orders'] = $orders->toArray();
            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function finish(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'items' => 'required|array|exists:Uasoft\Badaso\Module\Commerce\Models\Cart,id',
                'provider_id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\PaymentProvider,id',
                'user_address_id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\UserAddress,id',
            ]);

            $user_address = UserAddress::find($request->user_address_id);
            $total_discounted = 0;
            $total = 0;
            $payed = 0;
            $status = 0;
            $shipping_cost = 0;

            if (Config::get('commerceUseFixRateShippingCost') == 1) {
                $shipping_cost = Config::get('commerceFixRateShippingCost');
            }

            foreach ($request->items as $key => $item) {
                $cart = Cart::find($item);
                $product_detail = ProductDetail::findOrFail($cart->product_detail_id);
                $discount = null;
                $discounted = 0;
                if (!empty($product_detail->discount_id)) {
                    $discount = Discount::findOrFail($product_detail->discount_id);
                    if ($discount->discount_type === 'fixed') {
                        $discounted = $discount->discount_fixed * $cart->quantity;
                    }

                    if ($discount->discount_type === 'percent') {
                        $discounted = $product_detail->price * $discount->discount_percent / 100 * $cart->quantity;
                    }
                }

                $total_discounted += $discounted;
                $total += $product_detail->price * $cart->quantity;
            }

            $order_replicated = $user_address->replicate([
                'id'
            ])->toArray();

            $order = Order::create(array_merge([
                'user_id' => auth()->user()->id,
                'provider_id' => $request->provider_id,
                'discounted' => $total_discounted,
                'total' => $total,
                'shipping_cost' => $shipping_cost,
                'payed' => $total - $total_discounted + $shipping_cost,
                'status' => $status,
                'expired_at' => Config::get('commerceHasExpiredOrder') === 1 || Config::get('commerceHasExpiredOrder') === '1' ? Carbon::now()->addDays(Config::get('commerceExpiredOrderDay')) : null
            ], $order_replicated));

            foreach ($request->items as $key => $item) {
                $cart = Cart::find($item);
                $product_detail = ProductDetail::findOrFail($cart->product_detail_id);
                $discount = null;
                $discounted = 0;
                if (!empty($product_detail->discount_id)) {
                    $discount = Discount::findOrFail($product_detail->discount_id);
                    if ($discount->active === 1 || $discount->active === '1') {
                        if ($discount->discount_type === 'fixed') {
                            $discounted = $discount->discount_fixed;
                        }
    
                        if ($discount->discount_type === 'percent') {
                            $discounted = $product_detail->price * $discount->discount_percent / 100;
                        }
                    }
                }

                $order_detail = OrderDetail::create([
                    'order_id' => $order->id,
                    'product_detail_id' => $product_detail->id,
                    'discount_id' => $discount ? $discount->id : null,
                    'price' => $product_detail->price,
                    'discounted' => $discounted,
                    'quantity' => $cart->quantity,
                ]);

                $product_detail->quantity -= $cart->quantity;
                $product_detail->save();

                Cart::where('id', $item)->delete();
            }

            DB::commit();
            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollback();
            return ApiResponse::failed($e);
        }
    }

    public function pay(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
                'upload' => 'required|image',
            ]);

            DB::beginTransaction();

            $order = Order::where('user_id', auth()->user()->id)->where('id', $request->id)->firstOrFail();

            if ($order->status !== -1) {
                $upload = new UploadController();
                $file = $upload->upload();

                if (isset($file->original['url'])) {
                    $file_base_url = Storage::url('/');
                    $url = str_replace($file_base_url, '', $file->original['url']);
                    $order->image = $url;
                    $order->status = 1;
                    $order->save();
                } else {
                    return ApiResponse::failed($file->original['error']['message']);
                }

                DB::commit();
            } else {
                DB::rollback();
                return ApiResponse::failed(__('badaso_commerce::validation.order_is_failed'));
            }

            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollback();
            return ApiResponse::failed($e);
        }
    }

    public function editOrderAddress(Request $request)
    {
        try {
            $request->validate([
                'id'                => 'required',
                'recipient_name'    => 'required|string|max:255',
                'address_line1'     => 'required|string|max:255',
                'address_line2'     => 'nullable|string|max:255',
                'city'              => 'required|string|max:255',
                'postal_code'       => 'required|string|max:10',
                'country'           => 'required|string|max:255',
                'telephone'         => 'nullable|string|max:15',
                'mobile'            => 'nullable|string|max:15',
            ]);

            DB::beginTransaction();

            $order = Order::where('user_id', auth()->user()->id)->where('id', $request->id)->firstOrFail();
            
            if ($order->status === 0 && $order->status === 1) {
                $order->recipient_name = $request->recipient_name;
                $order->address_line1 = $request->address_line1;
                $order->address_line2 = $request->address_line2 ?? null;
                $order->city = $request->city;
                $order->postal_code = $request->postal_code;
                $order->country = $request->country;
                $order->telephone = $request->telephone ?? null;
                $order->mobile = $request->mobile ?? null;
                $order->save();

                DB::commit();
            } else {
                DB::rollback();
                return ApiResponse::failed(__('badaso_commerce::validation.cannot_change_address'));
            }
            
            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollback();
            return ApiResponse::failed($e);
        }
    }
}
