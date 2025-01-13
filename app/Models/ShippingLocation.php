<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingLocation extends Model
{
  use HasFactory;
  protected $fillable = [
    'shipping_company_id',
    'city_id',
    'countery_id',
    'shipping_price',
  ];

  public function shippingCompany()
  {
    return $this->belongsTo(ShippingCompany::class);
  }

  public function city()
  {
    return $this->belongsTo(City::class);
  }
}
