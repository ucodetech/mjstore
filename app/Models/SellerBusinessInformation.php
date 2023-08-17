<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerBusinessInformation extends Model
{
    use HasFactory;
    protected $fillable = [
                    'seller_id',
                    'shop_address',
                    'shop_city',
                    'shop_state',
                    'shop_logo',
                    'bank_name',
                    'account_name',
                    'account_number',
                    'registered_biz_name',
                    'cac_registration_no',
                    'cac_certificate',
                    'customer_support_email',
                    'customer_support_phone_no',
                    'customer_support_whatsapp',
                    'approved',
                    'Date_Approved'
                ];



        /**
         * Get the seller that owns the SellerBusinessInformation
         *
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function seller()
        {
            return $this->belongsTo(Seller::class);
        }
}
