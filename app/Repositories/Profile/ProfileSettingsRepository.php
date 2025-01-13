<?php

namespace App\Repositories\Profile;

use App\Models\Admin;
use App\Helper\Helper;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileSettingsRepository implements ProfileSettingsInterface
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

  public function changePassword($data, $id)
  {
    $admin = $this->admin->findOrFail($id);

    if (!Hash::check($data['old_password'], $admin->password)) {
      return false;
    }

    $admin->update([
      'password' => Hash::make($data['new_password'])
    ]);

    return true;
  }

}
