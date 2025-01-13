<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'page_name', 'image', 'image_en', 'description'];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('assets/images/category.jpg');
        }
        return asset('storage/' . $this->image);
    }

    public function getCurrentImageLangAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'ar' || empty($this->image)) {
            return $this->image;
        }
        return $this->image_en;
    }
}
