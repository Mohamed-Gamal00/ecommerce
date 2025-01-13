<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Advertisement\AdvertisementRequest;
use App\Models\Advertisement;
use App\Repositories\Advertisement\AdvertisementRepository;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{

  protected $advertisementRepository;

  public function __construct(AdvertisementRepository $advertisementRepository)
  {
    $this->advertisementRepository = $advertisementRepository;
  }


  public function index()
  {
    $advertisements = $this->advertisementRepository->getMainAdvertisemnt();
    return view('dashboard.front_settings.advertisement.index', compact('advertisements'));
  }

  public function create(Advertisement $advertisement)
  {
    return view('dashboard.front_settings.advertisement.create', compact('advertisement'));
  }

  public function store(AdvertisementRequest $request)
  {
    $data = $request->validated();

    if (isset($data['is_active']) && $data['is_active'] === 'on') 
    {
      $data['is_active'] = true;
    }
    else {
      $data['is_active'] = false;
    }
    // dd($data);
    $this->advertisementRepository->store($data);

    return redirect()->route('advertisements.index')
      ->with('success', __('messages.ADVERTISEMENT_CREATED') );
  }

  public function edit(Advertisement $advertisement)
  {
    return view('dashboard.front_settings.advertisement.edit', compact('advertisement'));
  }

  public function update(AdvertisementRequest $request, Advertisement $advertisement)
  {
    $data = $request->validated();
    if (isset($data['is_active']) && $data['is_active'] === 'on') {
      $data['is_active'] = true;
    } else {
      $data['is_active'] = false;
    }

    $this->advertisementRepository->update($data, $advertisement->id);

    return redirect()->route('advertisements.index')
      ->with('success', __('messages.ADVERTISEMENT_UPDATED'));
  }

  public function destroy($id)
  {
    $this->advertisementRepository->delete($id);
    return redirect()->route('advertisements.index')
      ->with('success', __('messages.ADVERTISEMENT_DELETED'));
  }
}
