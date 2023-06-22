<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryCheckoutProcess extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_number',
        'user_id',
        'product_id',
        'sub_total',
        'total_amount',
        'coupon',
        'delivery_charge',
        'shipping_method',
        'quantity',
        'order_status',
        'payment_method',
        'payment_status',
        'fullname',
        'email',
        'phone_number',
        // 'country',
        'address',
        'town',
        // 'apartment',
        'state',
        'postcode',
        'order_notes',
        'ship_fullname',
        'ship_email',
        'ship_phone_number',
        'ship_country',
        'ship_street',
        'ship_town',
        'ship_apartment',
        'ship_state',
        'ship_postcode',
        'address_entered',
        'delivery_method_entered',
        'payment_entered'
    ];

    /**
     * Get the user that owns the TemporaryCheckoutProcess
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

   
}
