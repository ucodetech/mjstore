<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function Dashboard(Request $request){
        return view('users.superuser.super-dashboard');
    }


    public function showBannerPage(){
        return view('users.superuser.banner.super-banner');
    }


    public function showProductCategoryPage(){
        $product_category = ProductCategory::where('status', 'active')->where('is_parent', 1)->get();
        return view('users.superuser.product.super-productcategory', compact('product_category', $product_category));
    }



    public function brandPage(){
        return view('users.superuser.brand.super-brand');
    }

}
