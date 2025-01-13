<?php

namespace App\Repositories\Country;

use App\Helper\Helper;
use App\Models\City;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

/*
    Separates databases layer from services layer
    contain all databse work
    handel the database operation as create update delete ..
*/

class CountryRepository implements CountryInterface
{

  use Helper;
  public $country;
  public $city;
  public function __construct(Country $country, City $city)
  {
    $this->country = $country;  // Ready-instance model of country
    $this->city = $city;  // Ready-instance model of country
  }

  public function getMainCountry()
  {
    return $this->country->where('status', 'used')->paginate();
  }
  public function getDefaultcountry()
  {
    return $this->country->where('default_country', true)->first();
  }

  public function store($data)
  {
    DB::transaction(function () use ($data) {
      $this->country->where('id', $data['country_id'])->update([
        'status' => 'used'
      ]);

      if (!empty($data['city'])) {
        foreach ($data['city'] as $city_id) {
          $this->city->where('id', $city_id)->update([
            'status' => 'used'
          ]);
        }
      }
    });
  }

  public function getById($id)
  {
    return $this->country->findOrFail($id);
    return $this->city->findOrFail($id);
  }

  public function update($data, $id)
  {
    $oldCities = $this->city->where('country_id', $id)->pluck('id')->toArray();

    DB::transaction(function () use ($oldCities, $id, $data) {
      $this->city->whereIn('id', $oldCities)->update([
        'status' => 'not_used'
      ]);

      $this->country->where('id', $id)->update([
        'status' => 'not_used'
      ]);

      $this->country->where('id', $data['country_id'])
        ->update([
          'status' => 'used'
        ]);


      if (!empty($data['city'])) {
        foreach ($data['city'] as $city_id) {
          $this->city->where('id', $city_id)
            ->where('country_id', $data['country_id']) // Compare with the ID of the old country
            ->update([
              'status' => 'used'
            ]);
        }
      }
    });
  }

  public function delete($id)
  {
    $cities = $this->city->where('country_id', $id)->pluck('id')->toArray();

    DB::transaction(function () use ($cities, $id) {

      $this->city->whereIn('id', $cities)->update([
        'status' => 'not_used'
      ]);

      $this->country->where('id', $id)->update([
        'status' => 'not_used'
      ]);
    });
  }
}
