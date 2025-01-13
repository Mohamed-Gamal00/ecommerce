<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HeaderBanner extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['header_image', 'header_image_en', 'image_link'];

    public function getCurrentImageLangAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'ar' || empty($this->header_image)) {
            return $this->header_image;
        }
        return $this->header_image_en;
    }
}
