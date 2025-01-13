<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Countries\CountryRequest;
use App\Models\City;
use App\Models\Country;
use App\Repositories\Country\CountryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CountriesController extends Controller
{
  public $countryRepo;
  public function __construct(CountryRepository $repo)
  {
    $this->countryRepo = $repo;
  }
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //Gate::authorize('country.view');
    $countries = $this->countryRepo->getMainCountry();
    return view('dashboard.countries.index', compact('countries'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //Gate::authorize('country.create');

    $countries = Country::where('status', 'not_used')->get();
    $cities = City::where('status', 'not_used')->get();

    return view('dashboard.countries.create', compact('countries', 'cities'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(CountryRequest $request)
  {
    //Gate::authorize('country.create');
    $data = $request->validated();
    // dd($data);
    $this->countryRepo->store($data);
    return to_route('countries.index')->with('success', __('messages.COUNTRY_CREATED'));
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id) {}

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //Gate::authorize('country.edit');

    $selectedCountry = Country::where('id', $id)->first();
    $countries = Country::get();
    $cities = City::get();

    return view('dashboard.countries.edit', compact('selectedCountry', 'cities', 'countries'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(CountryRequest $request, string $id)
  {
    //Gate::authorize('country.edit');

    $data = $request->validated();

    $this->countryRepo->update($data, $id);

    return to_route('countries.index')->with('success', __('messages.COUNTRY_UPDATED'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //Gate::authorize('country.delete');

    $this->countryRepo->delete($id);
    return to_route('countries.index')->with('dark', __('messages.COUNTRY_DELETED'));
  }

  public function getCitiesByCountry($countryId)
  {
    $cities = DB::table('cities')->where('country_id', $countryId)->get();
    // dd($cities);
    return response()->json($cities);
  }
}
