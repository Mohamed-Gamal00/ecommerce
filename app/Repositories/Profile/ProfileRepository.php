<?php

namespace App\Repositories\Profile;

use App\Models\Admin;
use App\Helper\Helper;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileRepository implements ProfileInterface
{
  use Helper;

  protected $admin;

  public function __construct(Admin $admin)
  {
    $this->admin = $admin;
  }

  public function getProfile($id)
  {
    return $this->admin->findOrFail($id);
  }

  public function updateProfile($data, $id)
  {
    $admin = $this->admin->findOrFail($id);

    $oldImage = $admin->image;
    $newImage = $this->uploadedImage(request(), 'image', 'admins');

    if ($newImage) {
      $data['image'] = $newImage;
    }

    if ($newImage && $oldImage) {
      Storage::disk('public')->delete($oldImage);
    }

    $admin->update($data);

    return $admin->wasChanged();
  }


}
