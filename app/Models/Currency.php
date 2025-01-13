<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
  use HasFactory;
  protected $table = 'currencies';
  public $fillable = ['name', 'name_ar', 'status', 'code', 'symbol', 'price_in_default_currency', 'default_currency'];
}
