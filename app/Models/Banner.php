<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['title',
                            'slug',
                            'description',
                            'photo',
                            'status',
                            'condition',
                            'price_description',
                            'link',
                            'link_descriptions'
                        ];
}
