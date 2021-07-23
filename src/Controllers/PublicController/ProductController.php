<?php

namespace Uasoft\Badaso\Module\Commerce\Controllers\PublicController;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Module\Commerce\Models\Product;

class ProductController extends Controller
{
    public function browse(Request $request)
    {
        try {
            $request->validate([
                'page' => 'sometimes|required|integer',
            ]);

            $products = Product::with('productCategory', 'productDetails.discount')->paginate(config('badaso-commerce.products_limit_on_query'));
                
            $data['products'] = $products->toArray();
            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function read(Request $request)
    {
        try {
            $request->validate([
                'slug' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Product',
            ]);

            $product = Product::with(['productCategory', 'productDetails.discount'])->where('slug', $request->slug)->first();
            $data['product'] = $product->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }
}
