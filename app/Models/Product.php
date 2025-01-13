<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SubSettings;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_en',
        'description',
        'image',
        'price',
        'discount_price',
        'status',
        'category_id',
        'parent_id',
        'company_id',
        'quantity',
        'main_category_setting_id',
        'is_special',
        'product_availability_id',
        'weight',
        'slug'
    ];

    /// mohamed gamal

    protected static function booted()
    {
        static::creating(function ($product) {
            $slug = str_replace(' ', '-', $product->name);
            $product->slug = $slug;
        });
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items', 'product_id', 'order_id', 'id')
            ->using(OrderItem::class)
            ->as('order_items')
            ->withPivot([
                'product_name', 'price', 'quantity',
            ]);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'product_id', 'id');
    }

    public function cartItemsWithoutScope()
    {
        return $this->hasMany(Cart::class, 'product_id', 'id')->withoutGlobalScope('cookie_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'id');
    }

    public function choices()
    {
        return $this->belongsToMany(Choice::class, 'choices_products', 'product_id', 'choice_id');
    }

    public function discountCodes()
    {
        return $this->belongsToMany(DiscountCode::class, 'discount_code_product');
    }

//    public function getProductDiscountAttribute()
//    {
//        $result = $this->discount_price ? round((($this->price - $this->discount_price) / $this->discount_price) * 100) : null;
//        return $result;
//    }

    // old

    public function getCurrentNameLangAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'ar' || empty($this->name_en)) {
            return $this->name;
        }
        return $this->name_en;
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MainCategory::class, 'category_id', 'id');
    }

    // uses in product filters page in dashboard

    public function sub_category(): BelongsTo
    {
        return $this->belongsTo(MainCategory::class, 'parent_id', 'id');
    }

    public function chiled(): BelongsTo
    {
        return $this->belongsTo(MainCategorySetting::class, 'main_category_setting_id', 'id');
    }

    public function subSettings()
    {
        return $this->belongsToMany(SubSettings::class, 'product_sub_settings', 'product_id', 'sub_settings_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function features()
    {
        return $this->hasMany(ProductFeature::class, 'product_id', 'id');
    }

    public function availability()
    {
        return $this->belongsTo(ProductAvailability::class, 'product_availability_id', 'id')
            ->withDefault([
                'name' => '-'
            ]);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('assets/images/no-image.jpg');
        }

        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['name'] ?? false, function ($builder, $value) {

            $builder->where('products.name', 'LIKE', "%{$value}%");
        });

        $builder->when($filters['status'] ?? false, function ($builder, $value) {

            $builder->where('products.status', 'LIKE', $value);
        });
        $builder->when($filters['category'] ?? false, function ($builder, $value) {

            $builder->where('products.category_id', 'LIKE', $value);
        });
    }

    public function wishlistUsers()
    {
        return $this->belongsToMany(
            Product::class,
            'wishlist_products_user',
            'product_id',
            'user_id',
        );
    }
}
