<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSettings extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'main_category_setting_id'];

    public function setting()
    {
        return $this->belongsTo(MainCategorySetting::class, 'main_category_setting_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'product_sub_settings',
            'sub_settings_id',
            'product_id',
        );
    }

    public function parent()
    {
        return $this->belongsTo(MainCategorySetting::class, 'main_category_setting_id', 'id');
    }


}
