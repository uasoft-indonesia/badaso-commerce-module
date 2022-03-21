<?php

namespace Uasoft\Badaso\Module\Commerce\Controllers\PublicController;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Helpers\Config;
use Uasoft\Badaso\Module\Commerce\Events\OrderStateWasChanged;
use Uasoft\Badaso\Module\Commerce\Helper\UploadImage;
use Uasoft\Badaso\Module\Commerce\Models\Cart;
use Uasoft\Badaso\Module\Commerce\Models\Discount;
use Uasoft\Badaso\Module\Commerce\Models\Order;
use Uasoft\Badaso\Module\Commerce\Models\OrderAddress;
use Uasoft\Badaso\Module\Commerce\Models\OrderDetail;
use Uasoft\Badaso\Module\Commerce\Models\OrderPayment;
use Uasoft\Badaso\Module\Commerce\Models\PaymentOption;
use Uasoft\Badaso\Module\Commerce\Models\ProductDetail;
use Uasoft\Badaso\Module\Commerce\Models\UserAddress;

class OrderController extends Controller
{
    public function browse()
    {
        try {
            if (in_array(env('DB_CONNECTION'), ['pgsql'])) {
                $orders = Order::select(['id', 'status', 'payed', 'expired_at', 'cancel_message']);

                $orders = $orders->where('user_id', auth()->user()->id)
                    ->latest()
                    ->get();

                $orders = $orders->map(function ($order) {
                    if (isset($order->orderDetails)) {
                        $order_details = $order->orderDetails;
                        $order_details = $order_details->map(function ($order_detail) {
                            $product_detail = $order_detail->productDetail;
                            if (isset($product_detail)) {
                                $product_detail->product = $product_detail->product;
                            }
                            $product_detail->review;

                            return $order_detail;
                        });
                        $order->order_details = $order_details;
                    }
                    $order->order_payment = $order->orderPayment;

                    return $order;
                });

                $data['orders'] = $orders->toArray();

                return ApiResponse::success($data);
            } else {
                $orders = Order::select(['id', 'status', 'payed', 'expired_at', 'cancel_message'])
                    ->with(['orderDetails' => function ($query) {
                        return $query
                            ->select(['id', 'order_id', 'product_detail_id', 'price', 'discounted', 'quantity'])
                            ->with(['productDetail' => function ($query) {
                                return $query
                                    ->select(['id', 'product_id', 'name', 'product_image'])
                                    ->with(['product' => function ($query) {
                                        return $query->select(['id', 'name', 'slug']);
                                    }]);
                            }]);
                    }, 'orderDetails.review', 'orderPayment'])
                    ->where('user_id', auth()->user()->id)
                    ->latest()
                    ->get();
            }
            $orders = Order::select(['id', 'status', 'payed', 'expired_at', 'cancel_message'])
                ->with(['orderDetails' => function ($query) {
                    return $query
                        ->select(['id', 'order_id', 'product_detail_id', 'price', 'discounted', 'quantity'])
                        ->with(['productDetail' => function ($query) {
                            return $query
                                ->select(['id', 'product_id', 'name', 'product_image'])
                                ->with(['product' => function ($query) {
                                    return $query->select(['id', 'name', 'slug']);
                                }]);
                        }]);
                }, 'orderDetails.review', 'orderPayment'])
                ->where('user_id', auth()->user()->id)
                ->latest()
                ->get();

            $data['orders'] = $orders->toArray();

            return ApiResponse::success($data);
        } catch (\Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function read(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Order,id',
            ]);

            $order = Order::with(['orderDetails.productDetail.product', 'orderPayment', 'orderAddress'])
                ->where('id', $request->id)
                ->where('user_id', auth()->user()->id)
                ->firstOrFail();

            $payment_option = PaymentOption::where('slug', $order->orderPayment->payment_type)->first();

            $data['order'] = $order->toArray();
            $data['payment_option'] = $payment_option;

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
                'user_address_id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\UserAddress,id',
                'payment_type' => 'required|string|max:255|exists:Uasoft\Badaso\Module\Commerce\Models\PaymentOption,slug',
                'message' => 'nullable|string',
            ]);

            $user_address = UserAddress::select('recipient_name', 'address_line1', 'address_line2', 'city', 'postal_code', 'country', 'phone_number')->where('id', $request->user_address_id)->where('user_id', auth()->user()->id)->firstOrFail();
            // dd($user_address);
            $total_discounted = 0;
            $total = 0;
            $status = 'waitingBuyerPayment';
            $shipping_cost = 0;

            if (Config::get('commerceUseFixRateShippingCost') == 1) {
                $shipping_cost = Config::get('commerceFixRateShippingCost');
            }

            foreach ($request->items as $key => $item) {
                $cart = Cart::find($item['id']);

                $product_detail = ProductDetail::with('discount')->findOrFail($cart->product_detail_id);

                if ($cart->quantity > $product_detail->quantity) {
                    throw new Exception('Out of stock');
                }

                // dd($cart->product_detail_id);

                $discount = null;
                $discounted = 0;
                if ($product_detail->discount_id) {
                    $discount = Discount::findOrFail($product_detail->discount_id);
                    if ($discount->active == 1) {
                        if ($discount->discount_type === 'fixed') {
                            $discounted = $discount->discount_fixed * $cart->quantity;
                        }

                        if ($discount->discount_type === 'percent') {
                            $discounted = round($product_detail->price * $discount->discount_percent / 100) * $cart->quantity;
                        }
                    }
                }

                $total_discounted += $discounted;
                $total += $product_detail->price * $cart->quantity;
            }

            $order_replicated = $user_address->replicate(['id'])->toArray();

            $order = Order::create([
                'user_id' => auth()->user()->id,
                'discounted' => $total_discounted,
                'total' => $total,
                'shipping_cost' => $shipping_cost,
                'payed' => $total - $total_discounted + $shipping_cost,
                'status' => $status,
                'expired_at' => Config::get('commerceHasExpiredOrder') == 1
                    ? Carbon::now()->addDays(Config::get('commerceExpiredOrderDay'))
                    : null,
                'message' => $request->message,
            ]);

            OrderAddress::create(array_merge([
                'order_id' => $order->id,
            ], $order_replicated));

            OrderPayment::create([
                'order_id' => $order->id,
                'payment_type' => $request->payment_type,
            ]);

            foreach ($request->items as $key => $item) {
                $cart = Cart::find($item);
                $product_detail = ProductDetail::findOrFail($cart->product_detail_id);
                $discount = null;
                $discounted = 0;
                if (! empty($product_detail->discount_id)) {
                    $discount = Discount::findOrFail($product_detail->discount_id);
                    if ($discount->active === 1 || $discount->active === '1') {
                        if ($discount->discount_type === 'fixed') {
                            $discounted = $discount->discount_fixed;
                        }
                        if ($discount->discount_type === 'percent') {
                            $discounted = round($product_detail->price * $discount->discount_percent / 100);
                        }
                    }
                }

                OrderDetail::create([
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

            event(new OrderStateWasChanged(auth()->user(), $order, 'waitingBuyerPayment'));

            DB::commit();

            return ApiResponse::success(['order' => $order->id]);
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }

    public function pay(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Order,id',
                'name' => 'required|string|max:255|min:3',
                'proof_of_transaction' => 'required',
                'source_bank' => 'required|string',
                'destination_bank' => 'required|string',
                'account_number' => 'required|alpha_num',
                'total_transfered' => 'required|numeric',
            ]);

            DB::beginTransaction();

            $order = Order::where('user_id', auth()->user()->id)
                ->where('id', $request->id)
                ->firstOrFail();

            $url = null;

            if ($order->status == 'waitingBuyerPayment' && now()->lessThan(Carbon::create($order->expired_at))) {
                $url = UploadImage::createImage($request->proof_of_transaction, 'proof/');
                OrderPayment::create([
                    'order_id' => $order->id,
                    'proof_of_transaction' => $url,
                    'source_bank' => $request->source_bank,
                    'destination_bank' => $request->destination_bank,
                    'account_number' => $request->account_number,
                    'total_transfered' => $request->total_transfered,
                    'payment_type' => 'manual-transfer',
                ]);

                $order->status = 'waitingSellerConfirmation';
                $order->expired_at = null;
                $order->save();

                event(new OrderStateWasChanged(auth()->user(), $order, 'waitingSellerConfirmation'));

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
}
