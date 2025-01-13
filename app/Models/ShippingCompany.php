<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCompany extends Model
{
  use HasFactory;
  protected $fillable = [
    'name',
    'picture',
    'status',
  ];
  
  public function shippingLocations()
  {
    return $this->hasMany(ShippingLocation::class);
  }
}
