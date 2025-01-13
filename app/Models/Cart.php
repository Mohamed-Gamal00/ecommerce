<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;


class Cart extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'cookie_id', 'status', 'color_id', 'product_id', 'user_id', 'guest_id', 'quantity', 'weight', 'discounted_price'
    ];

    protected static function booted()
    {
        static::addGlobalScope('cookie_id', function (Builder $builder) {
            $builder->where('cookie_id', '=', Cart::getCookieId());
        });

        static::creating(function (Cart $cart) {
            $cart->id = Str::uuid();

            // Check if the request is from the API
            if (str_contains(request()->path(), 'api')) {
                $cart->cookie_id = Cart::getCookieIdApi();
            } else {
                $cart->cookie_id = Cart::getCookieId();
            }
        });
    }

    public static function getCookieId()
    {
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('cart_id', $cookie_id, 30 * 24 * 60);
        }
        return $cookie_id;
    }

    public static function getCookieIdApi()
    {
        $request = request();
        if (request()->user()) {
            $cookie_id = Cart::where('status', 0)->where('user_id', $request->user()->id)->withoutGlobalScope('cookie_id')->value('cookie_id');
        } else {
            $cookie_id = Cart::where('status', 0)->where('guest_id', $request->guest_id)->withoutGlobalScope('cookie_id')->value('cookie_id');
        }
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
        }
        return $cookie_id;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault([
            'name' => 'Anonymous'
        ]);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
