<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFeature extends Model
{
    use HasFactory;

    public $timestamps = false;


    protected $fillable = ['feature_name', 'feature_name_en', 'feature_description', 'product_id', 'id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getCurrentNameLangAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'ar' || empty($this->feature_name_en)) {
            return $this->feature_name;
        }
        return $this->feature_name_en;
    }
}
