<?php

namespace App\Repositories\Notification;
use App\Helper\Helper;

class NotificationRepository implements NotificationInterface
{
  use Helper;
  protected $notification;


  public function getAll($user)
  {
    return $user->notifications()->paginate();
  }

}
