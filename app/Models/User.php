<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'email',
        'username',
        'password',
        'phone_number',
        'photo',
        'address',
        'apartment_suite_unit',
        'town_city',
        'state',
        'country',
        'postcode_zip',
        'additional_order_note',
        'status',
        'role',
        'deleted',
        'last_login',
        'unique_id',
        'email_verified',
        'ship_to_address',
        'ship_to_apartment_suite_unit',
        'ship_to_town_city',
        'ship_to_state',
        'ship_to_country',
        'ship_to_postcode_zip',
        

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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Get all of the orders for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'id');
    }

    /**
     * Get all of the temporarycheckoutprocesses for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function temporarycheckoutprocesses()
    {
        return $this->hasMany(TemporaryCheckoutProcess::class, 'id');
    }
}
