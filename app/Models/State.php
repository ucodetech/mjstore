<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    protected $table = 'states';
    protected $fillable = ['name'];


    /**
     * Get all of the localgovs for the State
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function localgovs()
    {
        return $this->hasMany(LocalGov::class, 'state_id');
    }

}
