<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Superuser extends Authenticatable
{
    use HasFactory;
    public $table = 'superusers';
    protected $guard = 'superuser';
    protected $primaryKey = 'id';
    public $timestamps = false;


    protected $fillable = [
        'id',
        'super_fullname',
        'super_email',
        'super_phone_no',
        'super_email_verified',
        'super_uniqueid',
        'username',
        'role',
        'password',
        'super_last_login',
        'super_date_added',
        'super_profile_photo',
        'deleted',
        'device_Verified',
        'status'
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

   
}
