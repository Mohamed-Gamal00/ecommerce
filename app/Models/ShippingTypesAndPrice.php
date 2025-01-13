<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingTypesAndPrice extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'shipping_types_and_price';

    protected $fillable = [
        'add_pickup_from_store',
        'add_wight_price',
        'add_normal_price',
        'add_price_based_on_city',
        'weight_price',
        'normal_shipping_price'
    ];

}
