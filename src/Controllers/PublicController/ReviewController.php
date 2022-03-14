<?php

namespace Uasoft\Badaso\Module\Commerce\Controllers\PublicController;

use Exception;
use Illuminate\Http\Request;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Module\Commerce\Helper\UploadImage;
use Uasoft\Badaso\Module\Commerce\Models\Order;
use Uasoft\Badaso\Module\Commerce\Models\OrderDetail;
use Uasoft\Badaso\Module\Commerce\Models\ProductReview;

class ReviewController extends Controller
{
    public function browse(Request $request)
    {
        try {
            $request->validate([
                'slug' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Product,slug',
            ]);

            $reviews = ProductReview::with(['user' => function ($query) {
                return $query->select(['id', 'name', 'avatar']);
            }, 'orderDetail' => function ($query) {
                return $query->select(['id', 'product_detail_id'])
                ->with(['productDetail' => function ($query) {
                    return $query->select(['id', 'name']);
                }]);
            }])
                ->whereHas('product', function ($query) use ($request) {
                    return $query->where('slug', $request->slug);
                })
                ->paginate(10);

            return ApiResponse::success(['reviews' => $reviews->toArray()]);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function read(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Order,id',
            ]);

            $order = Order::with(['orderDetails.productDetail.product', 'orderDetails' => function ($query) {
                return $query->whereDoesntHave('review');
            }])
                ->where('id', $request->id)
                ->where('user_id', auth()->user()->id)
                ->where('status', 'done')
                ->firstOrFail();

            return ApiResponse::success(['order' => $order->toArray()]);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function submit(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\OrderDetail,id',
                'rating' => 'required|numeric',
                'review' => 'nullable|string',
                'media' => 'nullable|array',
            ]);

            $order_detail = OrderDetail::with('productDetail.product')
                ->where('id', $request->id)
                ->whereHas('order', function ($query) {
                    return $query->where('status', 'done');
                })
                ->whereDoesntHave('review')
                ->firstOrFail();

            $review = ProductReview::create([
                'product_id' => $order_detail->productDetail->product->id,
                'order_detail_id' => $order_detail->id,
                'user_id' => auth()->user()->id,
                'rating' => $request->rating,
                'review' => $request->review ?? null,
            ]);

            if ($request->filled('media')) {
                $filename = [];

                if (count($request->media) > 5) {
                    throw new Exception('Maximum media is reached');
                }

                foreach ($request->media as $key => $media) {
                    $filename[] = UploadImage::createImage($media, 'review/');
                }
                $review->media = array_values($filename);
                $review->save();
            }

            return ApiResponse::success();
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }
}
