<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Repositories\Profile\ProfileSettingsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class ProfileSettingsController extends Controller
{
  protected $profileSettingsRepository;

  public function __construct(ProfileSettingsRepository $repo)
  {
    $this->profileSettingsRepository = $repo;
  }
  public function index()
  {
    $admin = auth()->guard('admin')->user();
    return view('dashboard.profile.settings', compact('admin'));
  }

  public function changePassword(Request $request)
  {
    $request->validate([
      'old_password' => 'required',
      'new_password' => 'required|confirmed|min:6'
    ]);

    $data = $request->only(['old_password', 'new_password']);
    $id = Auth::guard('admin')->user()->id;

    $changed = $this->profileSettingsRepository->changePassword($data, $id);


    if (!$changed) {
      return back()->with('danger', 'الرقم السري الحالي غير صحيح');
    }

    return back()->with('success', 'تم تغيير الرقم السري بنجاح');
  }
}
