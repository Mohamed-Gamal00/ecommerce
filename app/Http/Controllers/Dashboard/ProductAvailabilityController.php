<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Product\ProductAvailabilityRequest;
use App\Models\ProductAvailability;
use App\Repositories\Product\ProductAvailabilityRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductAvailabilityController extends Controller
{
  protected $productAvailabilityRepository;

  public function __construct(ProductAvailabilityRepository $productAvailabilityRepository)
  {
    $this->productAvailabilityRepository = $productAvailabilityRepository;
  }
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //Gate::authorize('product_availability.view');

    $availabilities = $this->productAvailabilityRepository->getMainProductAvailability();
    return view('dashboard.product_availability.index', [
      'availabilities' => $availabilities,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //Gate::authorize('product_availability.create');

    return view('dashboard.product_availability.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(ProductAvailabilityRequest $request)
  {
    //Gate::authorize('product_availability.create');
    $data = $request->validated();

    $this->productAvailabilityRepository->store($data);

    return to_route('product_availability.index')
      ->with('success', __('messages.STATUS_AVAILABILITY_CREATED'));
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
    //Gate::authorize('product_availability.edit');

    $availability = ProductAvailability::findOrFail($id);
    return view('dashboard.product_availability.edit', \compact('availability'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(ProductAvailabilityRequest $request, string $id)
  {
    //Gate::authorize('product_availability.edit');

    $data = $request->validated();

    $availability = ProductAvailability::FindOrFail($id);

    $wasChanged = $this->productAvailabilityRepository->update($data, $id);

    if ($wasChanged) {
      return to_route('product_availability.index')
        ->with('success', __('messages.STATUS_AVAILABILITY_UPDATED'));
    }

    return to_route('product_availability.index')
      ->with('info', 'لم يتم التعديل لعدم وجوود أي تغيير');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //Gate::authorize('product_availability.delete');
    $this->productAvailabilityRepository->delete($id);
    return to_route('product_availability.index')
      ->with('danger', __('messages.STATUS_AVAILABILITY_DELETED'));
  }
}
