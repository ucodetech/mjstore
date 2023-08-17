<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Seller extends Authenticatable
{
    use HasFactory;
    public $timestamp = false;
    protected $guard = 'seller';
    protected $primaryKey = 'id';
    protected $table = "sellers";
    protected $fillable = [
        'unique_key',
        'shop_name',
        'business_options',
        'manager_fullname',
        'manager_tel',
        'manager_email',
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

    public $timestamps = false;
     /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

//get self
public static function GetSellerByID($seller_id){
    return self::where('id', $seller_id)->first();
}

    /**
     * Get the business_information associated with the Seller
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function business_information()
    {
        return $this->hasOne(SellerBusinessInformation::class);
    }

}
