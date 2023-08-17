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
                    'status',
                    'is_top',
                    'vendor_id'
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
    public function products()
    {
        return $this->hasMany(Product::class, 'cat_id'); // you pass forign key so as to override laravel from using default check
    }

    public static function catChild($id){
        return self::where('parent_id', $id)->get();
    }

    /**
     * Get all of the brands for the ProductCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function brands()
    {
        return $this->hasMany(Brand::class);
    }
}

