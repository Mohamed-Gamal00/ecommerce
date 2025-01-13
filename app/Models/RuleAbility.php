<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuleAbility extends Model
{
    use HasFactory;

    protected $fillable = [
        'rule_id',
        'ability',
        'type'
    ];

    public $timestamps = false;
}
