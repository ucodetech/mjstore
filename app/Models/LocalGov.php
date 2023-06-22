<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalGov extends Model
{
    use HasFactory;
    protected $table = 'localgov';
    protected $fillable = ['state_id', 'local_name'];
    
    /**
     * Get the state that owns the LocalGov
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
