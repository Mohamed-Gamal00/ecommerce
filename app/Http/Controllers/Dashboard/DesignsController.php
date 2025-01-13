<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Design\DesignRequest;
use App\Models\Design;
use App\Repositories\Design\DesignRepository;
use App\Services\Design\designRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class DesignsController extends Controller
{
  use Helper;

  public $designRepo;

  // create constructor to bind DesignRepo
  public function __construct(DesignRepository $repo)
  {
    $this->designRepo = $repo;
  }
  /**
   * Display a listing of the resource.
   */

  public function index()
  {
    //Gate::authorize('design.view');
    $home_banners = $this->designRepo->getHomeBanners();
    $offer_banners = $this->designRepo->getOfferBageBanners();
    return view('dashboard.designs.index', compact('home_banners', 'offer_banners'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //Gate::authorize('design.create');
    return view('dashboard.designs.create');
  }

  /*
   * Store a newly created resource in storage.
   */


  public function store(DesignRequest $request)
  {
    //Gate::authorize('design.create');
    $data = $request->validated();
    $data['image'] = $this->uploadedImage($request, 'image', 'designs');
    $this->designRepo->store($data);
    return to_route('designs.index')->with('success', __('messages.DESIGN_CREATED'));
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //Gate::authorize('design.edit');
    $design = $this->designRepo->getById($id);
    return view('dashboard.designs.edit', compact('design'));
  }

  public function update(DesignRequest $request, string $id)
  {
    //Gate::authorize('design.edit');

    $design = $this->designRepo->getById($id);

    $data = $request->except('image');

    $oldImage = $design->image;
    $newImage = $this->uploadedImage($request, 'image', 'designs');
    if ($newImage) {
      $data['image'] = $newImage;
    }

    if ($oldImage && $newImage) {
      Storage::disk('public')->delete($oldImage);
    }

    $wasChanged = $this->designRepo->update($data, $id);

    if ($wasChanged) {
      return redirect()->route('designs.index')->with('success', __('messages.DESIGN_UPDATED'));
    }
    return redirect()->back()->with('dark', __('messages.DESIGN_NOT_UPDATED'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //Gate::authorize('design.delete');

    $this->designRepo->delete($id);
    return redirect()->back()->with('dark', 'تم حذف العنصر بنجاح');
  }
}
