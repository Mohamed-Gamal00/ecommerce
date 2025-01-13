<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Settings\SettingRequest;
use App\Models\OrderStatus;
use App\Models\Setting;
use App\Repositories\Setting\SettingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    use Helper;

    public $settingRepo;
    public function __construct(SettingRepository $repo)
    {
        $this->settingRepo = $repo;
    }
    public function index()
    {
        //Gate::authorize('settings.edit');

        $setting = Setting::first();
        $orderStatus = OrderStatus::all();
        $currentOrderStatus = OrderStatus::where('default_status', true)->first();
        return view('dashboard.front_settings.edit', compact('setting', 'orderStatus', 'currentOrderStatus'));
    }

    public function update(SettingRequest $request, $id)
    {
        //Gate::authorize('settings.edit');

        $data = $request->validated();
        $settings = $this->settingRepo->getById($id);

        // main Image
        $oldImage = $settings->image;
        $newImage = $this->uploadedImage(request(), 'image', 'website_image');
        if ($newImage) {
            $data['image'] = $newImage;
        }
        if ($oldImage && $newImage) {
            Storage::disk('public')->delete($oldImage);
        }

        /* logo */
        $oldLogo = $settings->logo;
        $newLogo = $this->uploadedLogo(request(), 'logo', 'website_image');

        if ($newLogo) {
            $data['logo'] = $newLogo;
        }

        if ($oldLogo && $newLogo) {
            Storage::disk('public')->delete($oldLogo);
        }

        $wasChanged = $this->settingRepo->update($data, $id);



        // $newOrderStatus = OrderStatus::where('id', $request->order_status)->first();
        // $oldOrderStatus = OrderStatus::where('default_status', true)->first();

        // if ($newOrderStatus->id != $oldOrderStatus->id) {
        //   $oldOrderStatus->update([
        //     'default_status' => false
        //   ]);

        //   $newOrderStatus->update([
        //     'default_status' => true
        //   ]);
        // }


        // if ($wasChanged || $oldOrderStatus->id != $newOrderStatus->id) {
        //   return back()->with('success', __('messages.SETTING_UPDATED'));
        // }
        return back()->with('success', __('messages.SETTING_UPDATED'));
        // return back()->with('dark', __('messages.SETTING_NOT_UPDATED'));
    }
}
