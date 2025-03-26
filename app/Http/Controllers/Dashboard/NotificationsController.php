<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Notification\NotificationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    protected $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function index()
    {
        $user = Auth::guard('admin')->user();
        $notifications = $this->notificationRepository->getAll($user);

        $counter = 0;

        return view('dashboard.notifications.index', \compact('notifications', 'counter'));
    }


    public function markAsRead(Request $request)
    {
        $user = Auth::guard('admin')->user();

        if ($request->has('notification_id')) {
            $notification = $user->notifications()->find($request->notification_id);
            if ($notification) {
                $notification->markAsRead();
            }
        }

        return redirect()->to($request->url);
    }
}
