<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
                    'coupon_code',
                    'type',
                    'status',
                    'value',
                    'vendor_id'
    ];


    public function discount($total){
        
        if($this->type == 'fixed'){
            return $this->value;
        }elseif($this->type == 'percent'){
                $value = ($this->value/100);
                $disc = $value*$total;
            return $disc;
        }else{
            return 0;
        }
    }
}
