<?php

namespace Uasoft\Badaso\Module\Commerce\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Module\Commerce\Abstracts\BadasoPayment as AbstractsBadasoPayment;
use Uasoft\Badaso\Module\Commerce\Facades\BadasoCommerceModule;
use Uasoft\Badaso\Module\Commerce\Interfaces\BadasoPayment;
use Uasoft\Badaso\Module\Commerce\Models\Payment;
use Uasoft\Badaso\Module\Commerce\Models\PaymentOption;

class PaymentController extends Controller
{
    protected $slugs = [];

    public function __construct()
    {
        $payments_module_list = config('badaso-commerce.payments');
        foreach ($payments_module_list as $module) {
            $module_class = new $module();
            if ($module_class instanceof BadasoPayment && $module_class instanceof AbstractsBadasoPayment) {
                foreach ($module_class->getProtectedPaymentSlug() as $key => $slug) {
                    $this->slugs[] = $slug;
                }
            } else {
                throw new Exception('Class in badaso commerce payment config must be instance of BadasoPayment abstract & interface');
            }
        }
    }

    public function browse(Request $request)
    {
        try {
            $request->validate([
                'page' => 'sometimes|required|integer',
            ]);

            $payments = Payment::paginate(15);

            $data['payments'] = $payments->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function browseOption(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Payment,id',
            ]);

            $options = PaymentOption::where('payment_id', $request->id)
                ->latest()
                ->get();

            $data['options'] = $options;

            return ApiResponse::success(collect($data)->toArray());
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function addOption(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Payment,id',
                'name' => 'required|string|max:255',
                'slug' => "required|string|max:255|unique:Uasoft\Badaso\Module\Commerce\Models\PaymentOption,slug",
                'description' => 'nullable|string|max:255',
                'image' => 'nullable|string',
                'order' => 'required|numeric|min:1',
                'is_active' => 'required|boolean',
            ]);

            $option = PaymentOption::create([
                'payment_id' => $request->id,
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'image' => $request->image,
                'order' => $request->order,
                'is_active' => $request->is_active,
            ]);

            $data['option'] = $option;

            return ApiResponse::success(collect($data)->toArray());
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function add(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:Uasoft\Badaso\Module\Commerce\Models\Payment,slug',
                'is_active' => 'required|boolean',
            ]);

            $payment = Payment::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'is_active' => $request->is_active,
            ]);

            return ApiResponse::success($payment);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function read(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Payment,id',
            ]);

            $payment = Payment::where('id', $request->id)
                ->firstOrFail();

            $data['payment'] = collect($payment)->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function edit(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Payment,id',
                'name' => 'required|string|max:255',
                'is_active' => 'required|boolean',
            ]);

            $payment = Payment::where('id', $request->id)
                ->firstOrFail();

            $payment->name = $request->name;
            $payment->is_active = $request->is_active;
            $payment->save();

            return ApiResponse::success($payment);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function editOption(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\PaymentOption,id',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'image' => 'nullable|string',
                'order' => 'required|numeric|min:1',
                'is_active' => 'required|boolean',
            ]);

            $option = PaymentOption::where('id', $request->id)
                ->whereNotIn('slug', $this->slugs)
                ->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'image' => $request->image,
                    'order' => $request->order,
                    'is_active' => $request->is_active,
                ]);

            $data['option'] = $option;

            return ApiResponse::success(collect($data)->toArray());
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function arrangeOption(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Payment,id',
                'payment_options' => 'required|array',
            ]);

            $option = PaymentOption::where('payment_id', $request->id)
                ->whereNotIn('slug', $this->slugs)
                ->first();

            if (! is_null($option)) {
                foreach ($request->payment_options as $index => $item) {
                    $payment_option = PaymentOption::find($item['id']);
                    $payment_option->order = $item['order'];
                    $payment_option->save();
                }
            }

            DB::commit();

            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollBack();

            return ApiResponse::failed($e);
        }
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Payment,id',
            ]);

            $payment = Payment::whereNotIn('slug', BadasoCommerceModule::getProtectedPayments())->findOrFail($request->id);
            $payment->delete();

            DB::commit();

            return ApiResponse::success();
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
                $payment = Payment::whereNotIn('slug', BadasoCommerceModule::getProtectedPayments())->findOrFail($id);
                $payment->delete();
            }

            DB::commit();

            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }

    public function deleteOption(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\PaymentOption,id',
            ]);

            $option = PaymentOption::where('id', $request->id)
                ->whereNotIn('slug', $this->slugs)
                ->delete();

            DB::commit();

            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }
}
