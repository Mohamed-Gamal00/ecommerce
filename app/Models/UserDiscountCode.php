<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDiscountCode extends Model
{
    use HasFactory;

    protected $table = 'cookie_discount_ids';
    public $timestamps = false;

    protected $fillable = ['cookie_id', 'discount_id'];
}
