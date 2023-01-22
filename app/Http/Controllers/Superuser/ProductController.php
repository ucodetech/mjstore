<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\ProductCategory;
use App\Models\Brand;


class ProductController extends Controller
{
    public function productPage(){
        $products = Product::all();
        $product_count = Product::all()->count();
        return view('users.superuser.product.products.super-products', ['products'=>$products, 'product_count'=>$product_count]);
    }

    public function productStatus(Request $request){
        
        if($request->mode == true){
            Product::where('id', $request->product_id)
            ->update([
                'status'=>'active'
                ]);
                return response()->json(['code'=>1, 'msg'=>'Successfully updated product status']);
        }
        if($request->mode == false){
            Product::where('id', $request->product_id)
            ->update([
                'status'=>'inactive'
            ]);
            return response()->json(['code'=>1, 'msg'=>'Successfully updated product status']);
        }

        
    }
}
