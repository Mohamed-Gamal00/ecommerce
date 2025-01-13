<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
  use HasFactory;

  public $timestamps = false;
  protected $fillable = ['name', 'name_en', 'default_status', 'arrangement'];

  public function getCurrentNameLangAttribute()
  {
    $locale = app()->getLocale();
    if ($locale === 'ar' || empty($this->name_en)) {
      return $this->name;
    }
    return $this->name_en;
  }
}
