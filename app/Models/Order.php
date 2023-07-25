<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
                'order_number',
                'user_id',
                'sub_total',
                'total_amount',
                'coupon',
                'delivery_charge',
                'quantity',
                'payment_method',
                'payment_status',
                'order_status',
                'shipping_method',
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
            ];


        /**
         * Get the user that owns the Order
         *
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function user()
        {
            return $this->belongsTo(User::class, 'user_id');
        }

        /**
         * Get all of the orderitems for the Order
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function orderitems()
        {
            return $this->hasMany(OrderItems::class);
        }

        public static function OrderSelf($order_id){
            return self::where('order_number', $order_id)->get()->first();
        }
}
