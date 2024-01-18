<?php

namespace Uasoft\Badaso\Module\Commerce\Controllers\PublicController;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Module\Commerce\Helper\UploadImage;

class UserController extends Controller
{
    public function edit(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'name' => 'required',
                'avatar' => 'nullable',
            ]);

            $user = auth()->user();
            $user->name = $request->name;
            if ($request->filled('avatar')) {
                if ($user->avatar != 'files/shares/default-user.png') {
                    UploadImage::deleteImage($user->avatar);
                }
                $filename = UploadImage::createImage($request->avatar);
                $user->avatar = $filename;
            }
            $user->save();

            DB::commit();

            return ApiResponse::success(['user' => auth()->user()]);
        } catch (Exception $e) {
            DB::rollBack();

            return ApiResponse::failed($e);
        }
    }

    public function changePassword(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'old_password' => 'required|string',
                'password' => 'required|confirmed|string',
            ]);

            $user = auth()->user();
            $user->password = Hash::make($request->password);
            $user->save();

            DB::commit();

            return ApiResponse::success(['user' => auth()->user()]);
        } catch (Exception $e) {
            DB::rollBack();

            return ApiResponse::failed($e);
        }
    }
}
