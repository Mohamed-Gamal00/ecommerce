<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\City;
use App\Models\Country;
use App\Models\ShippingTypesAndPrice;
use App\Repositories\Shipping\ShippingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class ShippingController extends Controller
{
  protected $shippingRepository;

  public function __construct(ShippingRepository $shippingRepository)
  {
    $this->shippingRepository = $shippingRepository;
  }
  public function index()
  {
    //Gate::authorize('shipping.edit');

    $countries = $this->shippingRepository->getCountriesWithStatus('used');
    $cities = $this->shippingRepository->getCitiesWithStatus('used');
    $shippingData = $this->shippingRepository->getShippingData(1);

    // Retrieve old price values for cities
    $oldPrices = old('price', []);

    return view('dashboard.shipping_types.index', compact('countries', 'cities', 'shippingData', 'oldPrices'));
  }

  public function getCities(Request $request)
  {
    $countryId = $request->input('country_id');
    $cities = $this->shippingRepository->getCitiesByCountryIdWithStatus($countryId, 'used');

    return response()->json($cities);
  }

  public function edit()
  {
    $countries = Country::where('status', 'used')->get();
    $cities = City::with('country')->where('status', 'used')->where('shipping_price', '>', 0)->get();
    $shippingData = ShippingTypesAndPrice::where('id', 1)->first();
    // Retrieve old price values for cities
    $oldPrices = old('price', []);
    return view('dashboard.shipping_types.edit', compact('countries', 'cities', 'shippingData', 'oldPrices'));
  }
  public function update(Request $request, $id)
  {
    //Gate::authorize('shipping.edit');

    $request->validate([
      'add_pickup_from_store' => 'nullable|boolean',
      'add_wight_price' => 'nullable|boolean',
      'add_normal_price' => 'nullable|boolean',
      'add_price_based_on_city' => 'nullable|boolean',
      'weight_price' => 'required|numeric|min:0|max:100000',
      'normal_shipping_price' => 'required|numeric|min:0|max:100000',
    ]);

    // $record = ShippingTypesAndPrice::findOrFail($id);
    $data = $request->only([
      'weight_price',
      'normal_shipping_price',
    ]);

    // Ensure checkbox values are set to false if they are not present in the request
    $data['add_pickup_from_store'] = $request->has('add_pickup_from_store') ? (bool)$request->post('add_pickup_from_store') : false;
    $data['add_wight_price'] = $request->has('add_wight_price') ? (bool)$request->post('add_wight_price') : false;
    $data['add_normal_price'] = $request->has('add_normal_price') ? (bool)$request->post('add_normal_price') : false;
    $data['add_price_based_on_city'] = $request->has('add_price_based_on_city') ? (bool)$request->post('add_price_based_on_city') : false;

    $data['price'] = $request->input('price', []);

    $this->shippingRepository->updateShippingData($data, $id);

    return \redirect()->back()->with('success', __('messages.SHIPPING_TYPE_UPDATED'));
  }
}
