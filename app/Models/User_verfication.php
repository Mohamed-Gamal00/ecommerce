<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_verfication extends Model
{
    use HasFactory;

    protected $table = 'users_verificationCodes';
    protected $fillable = [
        'user_id',
        'code',
        'verification_code_expires_at',
        'compare_code',
        'is_reset_password',
        'is_verified',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
