<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rule;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

class Admin extends User
{
    use HasFactory, Notifiable;

    protected $guard = 'admin';

    protected $fillable = ['name', 'email', 'password', 'super_admin', 'image'];


    public function rules()
    {
        return $this->belongsToMany(Rule::class, 'admin_rule');
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('assets/images/admin.jpg');
        }
        return asset('storage/' . $this->image);
    }

    public function hasAbility($ability)
    {
        $notAllow = $this->rules()->whereHas('abilities', function ($query) use ($ability) {
            $query->where('ability', $ability)
                ->where('type', '!=', 'allow');
        })->exists();

        if ($notAllow) {
            return false;
        }

        return $this->rules()->whereHas('abilities', function ($query) use ($ability) {
            $query->where('ability', $ability)
                ->where('type', '=', 'allow');
        })->exists();
    }
}
