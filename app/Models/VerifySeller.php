<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifySeller extends Model
{
    use HasFactory;
    protected $fillable = ['seller_id', 'token'];
}
