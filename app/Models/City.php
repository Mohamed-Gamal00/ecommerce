<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['name_ar', 'name_en', 'code', 'status', 'country_id', 'shipping_price'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function shippingLocations()
    {
        return $this->hasMany(ShippingLocation::class);
    }

    public function getCurrentNameLangAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'ar' || empty($this->name_en)) {
            return $this->name_ar;
        }
        return $this->name_en;
    }
}
