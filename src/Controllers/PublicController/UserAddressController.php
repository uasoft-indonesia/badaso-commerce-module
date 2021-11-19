<?php

namespace Uasoft\Badaso\Module\Commerce\Controllers\PublicController;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Helpers\Config;
use Uasoft\Badaso\Module\Commerce\Models\UserAddress;

class UserAddressController extends Controller
{
    public function browse(Request $request)
    {
        try {
            $user_addresses = UserAddress::where('user_id', auth()->user()->id)->get();

            $data['user_addresses'] = $user_addresses->toArray();
            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function read(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\UserAddress',
            ]);

            $data['user_address'] = UserAddress::where('user_id', auth()->user()->id)->where('id', $request->id)->first()->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function add(Request $request)
    {
        try {
            $request->validate([
                'recipient_name' => 'required|string|max:255',
                'address_line1' => 'required|string|max:255',
                'address_line2' => 'nullable|string|max:255',
                'city' => 'required|string|max:255',
                'postal_code' => 'required|string|max:10',
                'country' => 'required|string|size:2',
                'phone_number' => 'required|string|max:15',
            ]);

            DB::beginTransaction();

            $limit = Config::get('commerceLimitUserAddresses');
            $user_addresses_total = UserAddress::where('user_id', auth()->user()->id)->count();

            if ($user_addresses_total < $limit) {
                $user_address = UserAddress::create([
                    'user_id' => auth()->user()->id,
                    'recipient_name' => $request->recipient_name,
                    'address_line1' => $request->address_line1,
                    'address_line2' => $request->address_line2 ?? null,
                    'city' => $request->city,
                    'postal_code' => $request->postal_code,
                    'country' => $request->country,
                    'phone_number' => $request->phone_number ?? null,
                    'is_main' => 0
                ]);
            } else {
                DB::rollback();
                throw new Exception(__('badaso_commerce::validation.limit_user_addresses'));
                
            }

            DB::commit();
            return ApiResponse::success($user_address->only(['id']));
        } catch (Exception $e) {
            DB::rollback();
            return ApiResponse::failed($e);
        }
    }

    public function edit(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\UserAddress',
                'recipient_name' => 'required|string|max:255',
                'address_line1' => 'required|string|max:255',
                'address_line2' => 'nullable|string|max:255',
                'city' => 'required|string|max:255',
                'postal_code' => 'required|string|max:10',
                'country' => 'required|string|size:2',
                'phone_number' => 'required|string|max:15',
            ]);

            DB::beginTransaction();

            $user_address = UserAddress::where('user_id', auth()->user()->id)->where('id', $request->id)->first();

            $user_address->recipient_name = $request->recipient_name;
            $user_address->address_line1 = $request->address_line1;
            $user_address->address_line2 = $request->address_line2 ?? null;
            $user_address->city = $request->city;
            $user_address->postal_code = $request->postal_code;
            $user_address->country = $request->country;
            $user_address->phone_number = $request->phone_number ?? null;
            $user_address->save();

            DB::commit();
            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollback();
            return ApiResponse::failed($e);
        }
    }

    public function delete(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\UserAddress,id',
            ]);

            DB::beginTransaction();

            $user_address = UserAddress::where('user_id', auth()->user()->id)->where('id', $request->id)->firstOrFail();
            $user_address->delete();

            DB::commit();

            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }

    public function setMain(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\UserAddress,id',
            ]);

            DB::beginTransaction();

            $user_address = UserAddress::where('user_id', auth()->user()->id)
                ->where('is_main', 1)
                ->first();

            if (isset($user_address)) {
                $user_address->is_main = 0;
                $user_address->save();
            }

            $user_address = UserAddress::where('user_id', auth()->user()->id)
                ->where('id', $request->id)
                ->firstOrFail();
            $user_address->is_main = 1;
            $user_address->save();

            DB::commit();

            return ApiResponse::success();
        } catch (Exception $e) {
            DB::rollback();

            return ApiResponse::failed($e);
        }
    }
}
