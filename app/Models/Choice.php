<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'parent_id',
    ];

    public function choice()
    {
        return $this->belongsTo(Choice::class, "parent_id");
    }

    public function children()
    {
        return $this->hasMany(Choice::class, 'parent_id');
    }

    public function categories()
    {
        return $this->belongsToMany(MainCategory::class, 'category_choices', 'choice_id', 'main_category_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'choices_products', 'choice_id', 'product_id');
    }

    public function getCurrentNameLangAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'ar' || empty($this->name_en)) {
            return $this->name;
        }
        return $this->name_en;
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_choices')
            ->withPivot('sub_choice_id')
            ->withTimestamps();
    }
}
