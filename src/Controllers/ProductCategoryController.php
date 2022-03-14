<?php

namespace Uasoft\Badaso\Module\Commerce\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Module\Commerce\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    public function browse(Request $request)
    {
        try {
            $request->validate([
                'page' => 'sometimes|required|integer',
                'limit' => 'sometimes|required|integer',
            ]);

            if ($request->has(['page', 'limit'])) {
                $product_category = ProductCategory::with('children')->paginate($request->limit);
            } else {
                $product_category = ProductCategory::with('children')->get();
            }

            $data['product_categories'] = $product_category->toArray();
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
            ]);

            if ($request->has(['page', 'limit'])) {
                $product_category = ProductCategory::onlyTrashed()->with('children')->paginate($request->limit);
            } else {
                $product_category = ProductCategory::onlyTrashed()->with('children')->get();
            }

            $data['product_categories'] = $product_category->toArray();
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
                'parent_id' => 'nullable|exists:Uasoft\Badaso\Module\Commerce\Models\ProductCategory,id',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:Uasoft\Badaso\Module\Commerce\Models\ProductCategory',
                'desc' => 'nullable|string',
                'SKU' => 'nullable|string|max:255|unique:Uasoft\Badaso\Module\Commerce\Models\ProductCategory',
                'image' => 'nullable|string'
            ]);

            $product = ProductCategory::create($request->all());
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
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\ProductCategory',
            ]);

            $product = ProductCategory::withTrashed()->find($request->id);
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
                $product_categories = ProductCategory::withTrashed()->findOrFail($id);
                $product_categories->restore();
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
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\ProductCategory',
            ]);

            $product_category = ProductCategory::with('children', 'parent')->where('id', $request->id)->first();
            $data['product_category'] = $product_category->toArray();

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
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\ProductCategory,id',
                'parent_id' => 'nullable|exists:Uasoft\Badaso\Module\Commerce\Models\ProductCategory,id',
                'name' => 'required|string|max:255',
                'desc' => 'nullable|string',
                'SKU' => 'nullable|string|max:255',
                'image' => 'nullable|string'
            ]);

            $product_category = ProductCategory::find($request->id);

            $product_category->parent_id = $request->parent_id ?? null;
            $product_category->name = $request->name;
            $product_category->desc = $request->desc;
            $product_category->SKU = $request->SKU;
            $product_category->image = $request->image;
            $product_category->update();

            DB::commit();

            return ApiResponse::success($product_category);
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
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\ProductCategory',
            ]);

            $product_categories = ProductCategory::findOrFail($request->id);
            $product_categories->delete();

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
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\ProductCategory',
            ]);

            $product = ProductCategory::withTrashed()->find($request->id);
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
                $product_categories = ProductCategory::findOrFail($id);
                $product_categories->delete();
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

            $product_categories = ProductCategory::withTrashed()->whereIn('id', $id_list)->get();

            foreach ($product_categories as $product_category) {
                $product_category->forceDelete();
            }

            DB::commit();
            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }
}
