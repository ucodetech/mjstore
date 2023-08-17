<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    protected $fillable = [
        'site_title',
        'meta_description',
        'meta_keywords',
        'site_logo',
        'favicon',
        'address',
        'phone',
        'email',
        'made_with',
        'facebook_url',
        'whatsapp_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'twitter_url'
    ];
}
