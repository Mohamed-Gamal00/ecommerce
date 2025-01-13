<?php

namespace App\Repositories\Shipping;

use App\Helper\Helper;
use App\Models\City;
use App\Models\Country;
use App\Models\ShippingTypesAndPrice;

class ShippingRepository implements ShippingInterface
{
  use Helper;
  protected $city;
  protected $country;
  protected $shippingTypesAndPrice;

  public function __construct(City $city, Country $country, ShippingTypesAndPrice $shippingTypesAndPrice)
  {
    $this->city = $city;
    $this->country = $country;
    $this->shippingTypesAndPrice = $shippingTypesAndPrice;
  }


  public function getCountriesWithStatus($status)
  {
    return $this->country->where('status', $status)->get();
  }

  public function getCitiesWithStatus($status)
  {
    return $this->city->with('country')->where('status', $status)->where('shipping_price', '>', 0)->get();
  }

  public function getShippingData($id)
  {
    return $this->shippingTypesAndPrice->where('id', $id)->first();
  }

  public function updateShippingData($data, $id)
  {
    $record = $this->shippingTypesAndPrice->findOrFail($id);
    $record->update($data);

    if (isset($data['price'])) {
      foreach ($data['price'] as $city_id => $city_price) {
        $this->city->where('id', $city_id)->update(['shipping_price' => $city_price]);
      }
    }

    return $record;
  }

  public function getCitiesByCountryIdWithStatus($countryId, $status)
  {
    return $this->city->where('country_id', $countryId)->where('status', $status)->get();
  }
}
