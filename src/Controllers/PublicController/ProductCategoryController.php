<?php

namespace Uasoft\Badaso\Module\Commerce\Controllers\PublicController;

use Exception;
use Illuminate\Http\Request;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Module\Commerce\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    public function browse(Request $request)
    {
        try {
            $categories = ProductCategory::with('children')->get();
            $data['product_categories'] = $categories->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function read(Request $request)
    {
        try {
            $request->validate([
                'slug' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\ProductCategory',
            ]);

            $categories = ProductCategory::with(['children'])->where('slug', $request->slug)->first();
            $data['product_categories'] = $categories->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }
}
