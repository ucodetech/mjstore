<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;
    public $timestamp = false;
    protected $fillable = [
        'id',
        'shop_name',
        'business_options',
        'manager_fullname',
        'manager_tel',
        'manager_email',
        'username',
        'role',
        'password',
        'manager_last_login',
        'manager_date_added',
        'manager_profile_photo',
        'email_verified',
        'device_verified',
        'can_sell_now',
        'status',
        'email_changed'
    ];
}
