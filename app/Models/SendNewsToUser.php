<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SendNewsToUser extends Model
{
    use HasFactory, Notifiable;

    public $timestamps = false;
    protected $table = 'send_news_to_users';
    protected $fillable = ['subscription_email'];
}
