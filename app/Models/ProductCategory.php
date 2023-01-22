<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
                    'title',
                    'slug',
                    'photo',
                    'summary',
                    'parent_id',
                    'is_parent',
                    'status'
                ];

    public static function shiftChild($child_cat_id){
        foreach ($child_cat_id as $childid) {
            ProductCategory::where('id', $childid)->update([
                'is_parent' => 1, 
                'parent_id' => NULL
             ]);
        }
    }


    /**
     * Get all of the products for the ProductCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
