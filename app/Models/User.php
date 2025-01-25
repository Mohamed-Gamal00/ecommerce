<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserAddress;
use App\Models\UserToken;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'email',
        'password',
        'family_name',
        'phone_number',
        'address',
        'image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /* new */
    public function verificationCode()
    {
        return $this->hasOne(User_verfication::class, 'user_id', 'id');
    }

    public function wishlistProducts()
    {
        return $this->belongsToMany(
            Product::class,
            'wishlist_products_user',
            'user_id',
            'product_id'
        );
    }

    public function returnProducts()
    {
        return $this->belongsToMany(
            Product::class,
            'return_products',
            'user_id',
            'product_id'
        );
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(UserAddress::class, 'user_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return url('front/images/user-image.jpg');
        }
        return url('storage/' . $this->image);
    }
}
