<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;
    protected $fillable = ['product_id',
                            'user_id',
                            'reason',
                            'comment',
                            'rate',
                            'nickname',
                            'status'];
}
