<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkOrder extends Model
{
  use HasFactory;
  protected $fillable = ['name','phone','company_name','description'];
}
