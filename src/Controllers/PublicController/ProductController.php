<?php

namespace Uasoft\Badaso\Module\Commerce\Controllers\PublicController;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Helpers\Config;
use Uasoft\Badaso\Module\Commerce\Models\Product;

class ProductController extends Controller
{
    public function browse(Request $request)
    {
        try {
            $request->validate([
                'page' => 'sometimes|required|integer',
            ]);

            $products = Product::with('productCategory', 'productDetails.discount')
                ->latest()
                ->paginate(Config::get('homeProductLimit'));
                
            $data['products'] = $products->toArray();
            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function browseSimilar(Request $request)
    {
        try {
            $request->validate([
                'slug' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\ProductCategory,slug',
            ]);

            $products = Product::with(['productCategory', 'productDetails'])
                ->whereHas('productCategory', function ($query) use ($request) {
                    $query->where('slug', $request->slug);
                })
                ->inRandomOrder()
                ->limit(Config::get('similarProductLimit'))
                ->get();
                
            $data['products'] = $products->toArray();
            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function browseByCategorySlug(Request $request)
    {
        try {
            $request->validate([
                'slug' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\ProductCategory,slug',
                'page' => 'sometimes|required|integer',
            ]);

            $products = Product::with(['productCategory', 'productDetails.discount'])
                ->whereHas('productCategory', function ($query) use ($request) {
                    $query->where('slug', $request->slug);
                })
                ->latest()
                ->paginate(Config::get('homeProductLimit'));
                
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
