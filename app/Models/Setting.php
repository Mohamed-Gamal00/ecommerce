<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_name',
        'website_name_en',
        'subscription_title',
        'phone',
        'image',
        'facebook',
        'twitter',
        'description',
        'address',
        'email',
        'google_play',
        'apple_store',
        'logo',
        'instagram',
        'phone_number',
        'snap',
        'tiktok',
        'tax_number',
        'value_added_tax',
        'publishable_key',
        'secret_key',

        'sms_api_key',
        'sms_user_name',
        'sms_sender',
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('assets/images/logo.jpg');
        }
        return asset('storage/' . $this->image);
    }

    public function getCurrentNameLangAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'ar' || empty($this->website_name_en)) {
            return $this->website_name;
        }
        return $this->website_name_en;
    }
}
