<?php

namespace Uasoft\Badaso\Module\Commerce\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Module\Commerce\Models\Discount;

class DiscountController extends Controller
{
    public function browse(Request $request)
    {
        try {
            $request->validate([
                'page' => 'sometimes|required|integer',
                'limit' => 'sometimes|required|integer',
            ]);

            if ($request->has(['page', 'limit'])) {
                $discount = Discount::paginate($request->limit);
            } else {
                $discount = Discount::all();
            }

            $data['discounts'] = $discount->toArray();

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
                $discount = Discount::onlyTrashed()->paginate($request->limit);
            } else {
                $discount = Discount::onlyTrashed()->get();
            }

            $data['discounts'] = $discount->toArray();

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
                'name' => 'required|string|max:255',
                'desc' => 'nullable|string',
                'discount_type' => 'required|in:fixed,percent',
                'discount_percent' => ['nullable', 'integer', 'max:100', 'min:0', Rule::requiredIf($request->discount_type === 'percent')],
                'discount_fixed' => ['nullable', 'integer', 'min:0',  Rule::requiredIf($request->discount_type === 'fixed')],
                'active' => 'required|boolean',
            ]);

            $discount = Discount::create($request->all());
            DB::commit();

            return ApiResponse::success($discount);
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
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Discount,id',
            ]);

            $discount = Discount::withTrashed()->find($request->id);
            $discount->restore();
            DB::commit();

            return ApiResponse::success($discount);
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
                $discount = Discount::withTrashed()->findOrFail($id);
                $discount->restore();
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
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Discount,id',
            ]);

            $discount = Discount::where('id', $request->id)->first();
            $data['discount'] = $discount->toArray();

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
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Discount,id',
                'name' => 'required|string|max:255',
                'desc' => 'nullable|string',
                'discount_type' => 'required|in:fixed,percent',
                'discount_percent' => ['nullable', 'integer', 'max:100', 'min:0', Rule::requiredIf($request->discount_type === 'percent')],
                'discount_fixed' => ['nullable', 'integer', 'min:0', Rule::requiredIf($request->discount_type === 'fixed')],
                'active' => 'required|boolean',
            ]);

            $discount = Discount::find($request->id);

            $discount->name = $request->name;
            $discount->desc = $request->desc;
            $discount->discount_type = $request->discount_type;
            $discount->discount_percent = $request->discount_percent;
            $discount->discount_fixed = $request->discount_fixed;
            $discount->active = $request->active;
            $discount->update();

            DB::commit();

            return ApiResponse::success($discount);
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
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Discount,id',
            ]);

            $discount = Discount::findOrFail($request->id);
            $discount->delete();

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
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Discount,id',
            ]);

            $discount = Discount::withTrashed()->find($request->id);
            $discount->forceDelete();
            DB::commit();

            return ApiResponse::success($discount);
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
                $discount = Discount::findOrFail($id);
                $discount->delete();
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

            $discounts = Discount::withTrashed()->whereIn('id', $id_list)->get();

            foreach ($discounts as $discount) {
                $discount->forceDelete();
            }

            DB::commit();

            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }
}
