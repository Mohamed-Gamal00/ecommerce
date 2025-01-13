<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCategoryMainCategorySetting extends Model
{
    use HasFactory;
    protected $table = 'main_category_main_category_setting';

    protected $fillable = [
        'main_category_id',
        'category_setting_id'
    ];
}
