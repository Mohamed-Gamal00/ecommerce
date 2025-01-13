<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = ['cookie_id', 'first_name', 'email', 'family_name', 'phone_number', 'address'];

    public function wishlistProducts()
    {
        return $this->belongsToMany(Product::class,
            'wishlist_products_guest',
            'guest_id',
            'product_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'guest_id', 'id');
    }

    public function returnProducts()
    {
        return $this->belongsToMany(
            Product::class,
            'return_products',
            'guest_id',
            'product_id'
        );
    }
}
