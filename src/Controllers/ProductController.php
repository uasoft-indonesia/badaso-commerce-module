<?php

namespace Uasoft\Badaso\Module\Commerce\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Module\Commerce\Models\Product;
use Uasoft\Badaso\Module\Commerce\Models\ProductDetail;

class ProductController extends Controller
{
    public function browse(Request $request)
    {
        try {
            $request->validate([
                'page' => 'sometimes|required|integer',
                'limit' => 'sometimes|required|integer',
                'relation' => 'nullable'
            ]);

            if ($request->has('page') || $request->has('limit')) {
                $products = Product::when($request->relation, function ($query) use ($request) {
                    return $query->with(explode(',', $request->relation));
                })->paginate($request->limit);
            } else {
                $products = Product::when($request->relation, function ($query) use ($request) {
                    return $query->with(explode(',', $request->relation));
                })->get();
            }
            
            $data['products'] = $products->toArray();
            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function browseBin(Request $request)
    {
        try {
            $request->validate([
                'page' => 'sometimes|required|integer',
                'limit' => 'sometimes|required|integer',
                'relation' => 'nullable'
            ]);

            if ($request->has('page') || $request->has('limit')) {
                $products = Product::onlyTrashed()->when($request->relation, function ($query) use ($request) {
                    return $query->with(explode(',', $request->relation));
                })->paginate($request->limit ?? 10);
            } else {
                $products = Product::onlyTrashed()->when($request->relation, function ($query) use ($request) {
                    return $query->with(explode(',', $request->relation));
                })->get();
            }
            
            $data['products'] = $products->toArray();
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
                'product_category_id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\ProductCategory,id',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:Uasoft\Badaso\Module\Commerce\Models\Product',
                'product_image' => 'required|string',
                'desc' => 'nullable|string',
                'items' => 'required|array',
                'items.*.discount_id' => 'nullable|integer|exists:Uasoft\Badaso\Module\Commerce\Models\Discount,id',
                'items.*.name' => 'required|string|max:255',
                'items.*.quantity' => 'required|integer|min:0',
                'items.*.price' => 'required|integer|min:0',
                'items.*.s_k_u' => 'nullable|string|max:255',
                'items.*.product_image' => 'required|string',
            ]);

            Product::create([
                'product_category_id' => $request->product_category_id,
                'name' => $request->name,
                'slug' => $request->slug,
                'product_image' => $request->product_image,
                'desc' => $request->desc,
            ]);

            $product = Product::select('id')->latest()->first();

            foreach ($request->items as $key => $item) {
                ProductDetail::create([
                    'product_id' => $product->id,
                    'discount_id' => $item['discount_id'] ?? null,
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'SKU' => $item['s_k_u'] ?? null,
                    'product_image' => $item['product_image'],
                ]);
            }
            
            DB::commit();

            return ApiResponse::success($product);
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }

    public function restore(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Product',
            ]);

            $product = Product::withTrashed()->find($request->id);
            $product->productDetails()->restore();
            $product->restore();
            DB::commit();

            return ApiResponse::success($product);
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }

    public function restoreMultiple(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required',
            ]);

            $id_list = explode(',', $request->ids);

            DB::beginTransaction();

            foreach ($id_list as $key => $id) {
                $products = Product::withTrashed()->findOrFail($id);
                $products->productDetails()->restore();
                $products->restore();
            }

            DB::commit();
            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }

    public function read(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Product',
                'relation' => 'nullable'
            ]);

            $product = Product::when($request->relation, function ($query) use ($request) {
                return $query->with(explode(',', $request->relation));
            })->where('id', $request->id)->first();
            $data['product'] = $product->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function edit(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Product,id',
                'product_category_id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\ProductCategory,id',
                'name' => 'required|string|max:255',
                'product_image' => 'required|string',
                'desc' => 'nullable|string',
            ]);

            $product = Product::where('id', $request->id)->first();
            $product->product_category_id = $request->product_category_id;
            $product->name = $request->name;
            $product->product_image = $request->product_image;
            $product->desc = $request->desc;
            $product->save();

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
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Product',
            ]);

            $products = Product::findOrFail($request->id);
            $products->productDetails()->delete();
            $products->delete();

            DB::commit();

            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }

    public function forceDelete(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Product',
            ]);

            $product = Product::withTrashed()->find($request->id);
            $product->productDetails()->forceDelete();
            $product->forceDelete();
            DB::commit();

            return ApiResponse::success($product);
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }

    public function deleteMultiple(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required',
            ]);

            $id_list = explode(',', $request->ids);

            DB::beginTransaction();

            foreach ($id_list as $key => $id) {
                $products = Product::findOrFail($id);
                $products->productDetails()->delete();
                $products->delete();
            }

            DB::commit();

            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }

    public function forceDeleteMultiple(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required',
            ]);

            $id_list = explode(',', $request->ids);

            DB::beginTransaction();
            
            $products = Product::withTrashed()->whereIn('id', $id_list)->get();

            foreach ($products as $product) {
                $product->productDetails()->forceDelete();
                $product->forceDelete();
            }

            DB::commit();
            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }
}
