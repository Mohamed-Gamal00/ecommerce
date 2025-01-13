<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Notifications\SendNewsToUserRequest;
use App\Notifications\NewsNotification;

use App\Models\SendNewsToUser;
use App\Models\User;
use App\Repositories\SendNewsToUser\SendNewsToUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SendNewsToUsersController extends Controller
{
  public $SendNewsToUser;
  public function __construct(SendNewsToUserRepository $repo)
  {
    $this->SendNewsToUser = $repo;
  }

  public function create()
  {
    //Gate::authorize('news.view');
    $users = $this->SendNewsToUser->create();
    return view('dashboard.send_news_to_users.create', compact('users'));
  }

  public function sendNewsMail(SendNewsToUserRequest $request)
  {
    //Gate::authorize('news.view');
    $data = $request->validated();
    $users =  $this->SendNewsToUser->sendNewsMail($data);
    foreach ($users as $user) {
      $user->notify(new NewsNotification(request()->input('title'), request()->input('body'), $user));
    }
    return \redirect()->back()->with('success', __('messages.NEWSLETTER_CREATED'));
  }
}
