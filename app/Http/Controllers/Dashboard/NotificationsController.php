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
}
