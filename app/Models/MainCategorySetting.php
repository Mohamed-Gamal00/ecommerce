<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MainCategorySetting extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    protected $table = 'main_category_settings';

    public function categories()
    {
        return $this->belongsToMany(
            MainCategory::class,
            'main_category_main_category_setting',
            'category_setting_id',
            'main_category_id',
        );
    }

    public function subSettings(): HasMany
    {
        return $this->hasMany(SubSettings::class, 'main_category_setting_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
