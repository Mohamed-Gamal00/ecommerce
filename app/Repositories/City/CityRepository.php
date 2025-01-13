<?php

namespace App\Repositories\City;

use App\Helper\Helper;
use App\Models\City;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

/*
    Separates databases layer from services layer
    contain all databse work
    handel the database operation as create update delete ..
*/

class CityRepository implements CityInterface
{

  use Helper;
  public $country;
  public $city;
  public function __construct(Country $country, City $city)
  {
    $this->country = $country;  // Ready-instance model of country
    $this->city = $city;  // Ready-instance model of country
  }

  public function getMainCity()
  {
    return $this->city->where('status', 'used')->paginate();
  }

  public function store($data)
  {
    return $this->city->create($data);
  }

  public function getById($id)
  {
    return $this->city->findOrFail($id);
  }

  public function update($data, $id)
  {
    $city = $this->city->findOrFail($id);
    $city->update($data);
    return $city;
  }

  public function delete($id)
  {
    $city = $this->city->findOrFail($id);
    $city->delete();
  }

  public function getCountries()
  {
    return $this->country->where('status', 'used')->get();
  }

  public function getNotUsedCities()
  {
    return $this->city->where('status', 'not_used')->get();
  }

}
