<?php

namespace Uasoft\Badaso\Module\Commerce\Controllers\PublicController;

use Exception;
use Illuminate\Http\Request;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Helpers\Config;
use Uasoft\Badaso\Models\Notification;

class NotificationController extends Controller
{
    public function browse(Request $request)
    {
        try {
            $request->validate([
                'page' => 'sometimes|required|integer',
            ]);

            $notifications = Notification::with('receiver_users')
                ->where('receiver_user_id', auth()->user()->id)
                ->latest()
                ->paginate(Config::get('notificationBrowseLimit'));
                
            $data['notifications'] = $notifications->toArray();
            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function read(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Models\Notification,id',
            ]);

            $notification = Notification::where('receiver_user_id', auth()->user()->id)
                ->where('id', $request->id)
                ->where('is_read', 0)
                ->firstOrFail();

            $notification->update([
                'is_read' => 1
            ]);
                
            return ApiResponse::success();
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function readAll(Request $request)
    {
        try {
            $notifications = Notification::where('receiver_user_id', auth()->user()->id)
                ->where('is_read', 0)
                ->get();

            foreach ($notifications as $key => $notification) {
                $notification->update([
                    'is_read' => 1
                ]);
            }
                
            return ApiResponse::success();
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }
}
