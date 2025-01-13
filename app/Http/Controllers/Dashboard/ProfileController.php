<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Repositories\Profile\ProfileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
  use Helper;

  protected $profileRepository;

  public function __construct(ProfileRepository $repo)
  {
    $this->profileRepository = $repo;
  }

  public function index()
  {
    $admin = Auth::guard('admin')->user();
    return view('dashboard.profile.index', compact('admin'));
  }

  public function update(Request $request, $id)
  {
    $id = Auth::guard('admin')->user()->id;

    $data = $request->validate([
      'name' => 'required|string|max:100',
      'email' => 'required|email|unique:admins,email,' . $id,
      'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $admin = $this->profileRepository->updateProfile($data, $id);

    if ($admin) {
      return back()->with('success', __('messages.PROFILE_UPDATED'));
    }

    return back()->with('dark', 'لم يتم تحديث البيانات لعدم وجود أي تغيير');
  }
}
