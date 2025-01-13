<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreFatuer extends Model
{
  use HasFactory;
  protected $table = 'store_featuers';

  protected $fillable = ['image', 'title', 'title_en', 'description'];


  public function getImageUrlAttribute()
  {
    if (!$this->image) {
      return asset('assets/images/company.jpg');
    }
    return asset('storage/' . $this->image);
  }

  public function getCurrentTitleLangAttribute()
  {
    $locale = app()->getLocale();
    if ($locale === 'ar' || empty($this->title_en)) {
      return $this->title;
    }
    return $this->title_en;
  }
}
