<?php

namespace App\Http\Controllers\Dashboard\Shipping;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\ShippingCompany;
use Illuminate\Http\Request;

class ShippingCompanyController extends Controller
{
  public function index()
  {
    $shippingCompanies = ShippingCompany::all();
    return view('dashboard.shipping.index', compact('shippingCompanies'));
  }
  public function create()
  {
    $countries = Country::with('cities')->get();
    $cities = City::all(); // Fetch all cities
    return view('dashboard.shipping.create', compact('countries', 'cities'));
  }
  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'status' => 'required|boolean',
      'shipping_locations' => 'required|array',
      'shipping_locations.*.city_id' => 'required|exists:cities,id',
      'shipping_locations.*.countery_id' => 'required|exists:countries,id',
      'shipping_locations.*.shipping_price' => 'required|numeric|min:0',
    ]);

    if ($request->hasFile('picture')) {
      $path = $request->file('picture')->store('pictures');
      $validated['picture'] = $path;
    }
    // dd($validated);

    $shippingCompany = ShippingCompany::create($validated);

    foreach ($validated['shipping_locations'] as $location) {
      $shippingCompany->shippingLocations()->create($location);
    }

    return redirect()->route('shipping_companies.create')->with('success', 'Shipping company created successfully.');
  }
}
