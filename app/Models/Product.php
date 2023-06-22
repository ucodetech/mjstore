<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
                    'photo',
                    'title',
                    'slug',
                    'summary',
                    'description',
                    'stock',
                    'brand_id',
                    'cat_id',
                    'child_cat_id',
                    'price',
                    'sales_price',
                    'product_discount',
                    'weights',
                    'size',
                    'condition',
                    'vendor_id',
                    'status',
                    'color',
                    'unique_key',
                    'home_shop',
                    'featured',
                    
    ];

    /**
     * The brands that belong to the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the category that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productcategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    /**
     * Get the vendor that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vendor()
    {
        return $this->belongsTo(User::class);
    }


    public static function getProductByCart($id){
        return self::where('id', $id)->get()->toArray();
    }

  

    

    /**
     * Get the orderitem that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderitems()
    {
        return $this->belongsTo(OrderItems::class);
    }

}
