<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
  use HasFactory;

  protected $fillable = [
    'name_ar', 'name_en', 'code', 'status', 'phone_code'
  ];
  public function cities()
  {
    return $this->hasMany(City::class);
  }
  public $timestamps = false;
}
