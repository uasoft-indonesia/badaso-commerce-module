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
}
