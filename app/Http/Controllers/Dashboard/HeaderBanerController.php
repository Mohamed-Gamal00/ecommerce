<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HeaderBanner;
use Illuminate\Http\Request;
use App\Helper\ImageCustomization;
use Illuminate\Support\Facades\Storage;

class HeaderBanerController extends Controller
{
  use ImageCustomization;

  public function index()
  {
    $headerImages = HeaderBanner::select('id', 'header_image', 'image_link')->get();
    // dd($headerImages);
    return view('dashboard.banners.header_in_front', compact('headerImages'));
  }

  public function frontHeaderStoreAndUpdate(Request $request)
  {
    $data = $request->validate([
      'header' => ['nullable', 'array'],
      'header.*.image' => ['nullable', 'image'],
      'header.*.image_link' => ['nullable', 'string', 'max:1000'],
      'change_image_link' => ['nullable', 'array']
    ]);
    // dd($data);

    if ($request->has('header')) {
      foreach ($request->header as $key => $value) {
        if (isset($value['image']) || isset($value['image_link'])) {
          $path = $value['image']->store('header_images', 'public');
          $path = ImageCustomization::reduceImageQualityWithStore($value['image'], 80, 'header_images', false, 2.5, true);
          HeaderBanner::create([
            'header_image' => $path,
            'image_link' => $value['image_link']
          ]);
        }
      }
    }

    if ($request->has('change_image_link')) {
      foreach ($request->change_image_link as $imageId => $value) {
        HeaderBanner::where('id', $imageId)->update([
          'image_link' => $value
        ]);
      }
    }

    $titles = HeaderBanner::first();
    $titles->update($request->except(['header_image']));

    return redirect()->route('header_banner.index')->with(['success' => __('messages.BANNER_UPDATED')]);
  }


  public function frontHeaderRemoveImage(Request $request)
  {
    $request->validate([
      'image_id' => 'required|exists:header_banners,id'
    ]);

    $image = HeaderBanner::find($request->image_id);

    if ($image) {
      $deletedImage = $image->delete();
      if ($deletedImage) {
        Storage::disk('public')->delete($image->header_image);
      }
    }

    return response()->json([
      'message' => $deletedImage ? 'Image Deleted Successfully' : 'Failed to delete image'
    ], $deletedImage ? 200 : 400);
  }


}
