<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Repositories\ContactUs\ContactRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactUsController extends Controller
{

  protected $contactRepository;

  public function __construct(ContactRepository $repo)
  {
    $this->contactRepository = $repo;
  }
  public function index()
  {
    $messages = $this->contactRepository->getAll();
    $user = Auth::guard('admin')->user();
    $notifications = $user->notifications()->where('type', "App\Notifications\ContactFormSubmitted")->get();
    return view('dashboard.contact_us.index', compact('messages', 'notifications'));
  }

  public function show($id)
  {
    $message = $this->contactRepository->show($id);
    return view('dashboard.contact_us.show', compact('message'));
  }
}
