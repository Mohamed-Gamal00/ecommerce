<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MainCategorySetting;

class MainCategory extends Model
{
  use HasFactory;

  protected $fillable = [
    'parent_id',
    'name',
    'name_en',
    'description',
    'image',
    'slug'
  ];

  public function category()
  {
    return $this->belongsTo(MainCategory::class, "parent_id");
  }

  public function children()
  {
    return $this->hasMany(MainCategory::class, 'parent_id');
  }

  public function choices()
  {
    return $this->belongsToMany(Choice::class, 'category_choices', 'main_category_id', 'choice_id');
  }
  
  public function getCurrentNameLangAttribute()
  {
    $locale = app()->getLocale();
    if ($locale === 'ar' || empty($this->name_en)) {
      return $this->name;
    }
    return $this->name_en;
  }


  // public function settings()
  // {
  //   return $this->belongsToMany(
  //     MainCategorySetting::class,
  //     'main_category_main_category_setting',
  //     'main_category_id',
  //     'category_setting_id',
  //   );
  // }

  public function products()
  {
    return $this->hasMany(Product::class, 'category_id', 'id');
  }

  public function getImageUrlAttribute()
  {
    if (!$this->image) {
      return asset('assets/images/no-image.jpg');
    }
    return asset('storage/' . $this->image);
  }
}
