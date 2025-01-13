<?php

namespace App\Repositories\Shipping;

interface ShippingInterface
{
  public function getCountriesWithStatus($status);
  public function getCitiesWithStatus($status);
  public function updateShippingData($data, $id);
  public function getCitiesByCountryIdWithStatus($countryId, $status);
}
