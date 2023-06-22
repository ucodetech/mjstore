<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected  $fillable = [
                'shipping_method',
                'delivery_charge',
                'delivery_time',
                'delivery_description',
                'status'
             ];

             public static function shippingMethod($shipping_method_id){
                return self::where('id', $shipping_method_id)->first();
            }
        
}
