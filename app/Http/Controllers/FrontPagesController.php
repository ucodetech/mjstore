<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use Laravel\Ui\Presets\React;

class FrontPagesController extends Controller
{
    public function Index(){
        $banners = Banner::where('status', 'active')->where('condition', 'banner')->orderBy('id', 'desc')->limit(5)->get();
        $categories = ProductCategory::where('status', 'active')->where('is_parent', 1)->orderBy('id', 'desc')->get();
        $products_new = Product::where('status', 'active')->where('condition', 'new')->orderBy('created_at', 'desc')->get();
        $products_featured = Product::where('status', 'active')->where('featured', 1)->orderBy('created_at', 'desc')->get();
        $brands = Brand::where('status', 'active')->get();
        return view('pages.mjstore-index', 
            [
                'banners'=>$banners, 
                'categories'=>$categories,
                'products_new' => $products_new,
                'products_featured' => $products_featured,
                'brands' => $brands

            ]);
    }

    public function Category(Request $request, $slug_url){
        $categories = ProductCategory::where('slug', $slug_url)->where('status', 'active')->first();
        $p_id = $categories->id;
        $brands = Brand::with('product')->where('status', 'active')->get();
        $colors = Color::all();
        $sizes = Size::all();
        $product_color = Product::where('status', 'active')->get();

        $sort = '';
        $cols = '';
        if($request->all() != null){
            $sort = $request->s;
            $cols = $request->color;
        }

         if($categories->slug == ''){
            return view('errors.404');
         }else{
            if ($sort=='priceAsc') {
                $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])
                                        ->orderBy('sales_price', 'asc')
                                        ->paginate(20);
            } else if($sort=='priceDsc') {
                $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])
                ->orderBy('sales_price', 'desc')
                ->paginate(20);
            }else if($sort=='titleAsc') {
                $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])
                                        ->orderBy('title', 'asc')
                                        ->paginate(20);
            }else if($sort=='titleDsc') {
                $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])
                                        ->orderBy('title', 'desc')
                                        ->paginate(20);
            }else if($sort=='discountAsc') {
                 $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])
                                        ->orderBy('product_discount', 'asc')
                                        ->paginate(20);
            }else if($sort=='discountDsc') {
                $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])
                                        ->orderBy('product_discount', 'desc')
                                        ->paginate(20);
            } else if($cols){
                // $color = explode(',',$cols);
                $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])->where('color', 'LIKE', '%'.$cols.'%')
                ->paginate(20);
            }else{
                $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])->orWhere(['child_cat_id'=>$categories->id])
                ->orderBy('id', 'desc')
                ->paginate(12);
            }
            
            // switch ($sort) {
            //     case 'priceAsc':
            //         $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])
            //                             ->orderBy('sales_price', 'asc')
            //                             ->paginate(20);
            //         break;
            //     case 'priceDsc':
            //         $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])
            //                             ->orderBy('sales_price', 'desc')
            //                             ->paginate(20);
            //         break;
            //     case 'titleAsc':
            //         $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])
            //                             ->orderBy('title', 'asc')
            //                             ->paginate(20);
            //         break;
            //     case 'titleDsc':
            //         $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])
            //                             ->orderBy('title', 'desc')
            //                             ->paginate(20);
            //         break;
            //     case 'discountAsc':
            //         $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])
            //                             ->orderBy('product_discount', 'asc')
            //                             ->paginate(20);
            //         break;
            //     case 'discountDsc':
            //         $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])
            //                             ->orderBy('product_discount', 'desc')
            //                             ->paginate(20);
            //         break;
               
            //     default:
            //         $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])->orWhere(['child_cat_id'=>$categories->id])
            //         ->orderBy('id', 'desc')
            //         ->paginate(12);
            //         break;
            // }
         }
        $cat_child = ProductCategory::catChild($p_id);
        if($categories->is_parent != 1){
            $cat_child_parent = ProductCategory::where('id', $categories->parent_id)->first();
        }else{
            $cat_child_parent = '';
        }
        $route = 'category';
        return view('pages.category.mjstore-category', 
        [
            'categories'=>$categories,
            'cat_child'=> $cat_child,
            'cat_child_parent'=> $cat_child_parent,
            'route'=>$route,
            'products'=>$products,
            'brands' => $brands,
            'colors' => $colors,
            'sizes' => $sizes,
            'product_color' => $product_color
        ]);
       
       
    }
    public function ShopList(){
        $products = Product::where('status', 'active')->orderBy('id', 'desc')->paginate(20);
        $categories = ProductCategory::with('products')->where('status', 'active')->where('is_parent', 1)->orderBy('title', 'asc')->get();
        $brands = Brand::with('product')->where('status', 'active')->get();
        $colors = Color::all();
        $sizes = Size::all();
        $product_color = Product::where('status', 'active')->get();
        return view('pages.mjstore-shop-list', 
        [
            'products'=>$products,
            'categories' => $categories,
            'brands' => $brands,
            'colors' => $colors,
            'sizes' => $sizes,
            'product_color' => $product_color
        ]);
    }

    public function productDetails($slug_url){
       
        $product = Product::where('slug', $slug_url)->first();
        if($product){
            $likeproducts = Product::where('status', 'active')
                                    ->where('slug', '!=', $slug_url)
                                    ->where('cat_id', $product->cat_id)
                                    ->orderBy('id', 'desc')
                                    ->limit(5)
                                    ->get();
        
                return view('pages.mjstore-product-details', 
                [
                    'product'=>$product,
                    'likeproducts'=>$likeproducts
                ]);
        }
         return redirect()->route('404')->withInput();
        
    }
    
    public function Error404(){
        return view('errors.404');
    }

    public function productQuickview(Request $request){
        $uniquekey = $request->uniquekey;
        $product = Product::where('unique_key', $uniquekey)->first();
        $output = '';
        $output = '
        <div class="quickview_body">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-5">
                    <div class="quickview_pro_img">';
                    $photos = explode(',',$product->photo);
                    if(count($photos)>1){
                        $output .='

                        <img class="first_img" src="'.asset('storage/uploads/products/'.$photos[0]).'" alt="'.$product->title.'">
                        <img class="hover_img" src="'.asset('storage/uploads/products/'.$photos[1]).'" alt="'.$product->title.'">
                    ';
                    
                    }else{
                        $output .= '
                        <img class="first_img" src="'.asset('storage/uploads/products/'.$photos[0]).'" alt="'.$product->title.'">

                        ';
                    }
                   
                    $output .='
                        <!-- Product Badge -->
                        <div class="product_badge">
                            <span class="badge-new">'.$product->condition.'</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="quickview_pro_des">
                        <h4 class="title">'.$product->title.'</h4>
                        <div class="top_seller_product_rating mb-15">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                        </div>
                        <h5 class="price">'.Naira($product->sales_price).' <span class="text-danger">'.Naira($product->price).'</span></h5>
                        <p>'.$product->summary.'</p>
                        <a href="'.route('product.details', $product->slug).'">View Full Product Details</a>
                    </div>
                    <!-- Add to Cart Form -->
                    <div class="cart">
                    
                        <input type="hidden" name="product_id" id="product_id" value="'.$product->id.'" >
                        <div class="quantity">
                            <input type="number" class="qty-text" id="product_quantity'.$product->id.'" step="1"  min="1" max="'.$product->stock.'" name="quantity" value="1">
                        </div>
                        <button href="#"  
                            data-product-id="'.$product->id.'"
                            class="add_to_cart cart-submit"
                            id="add_to_cart'.$product->id.'"
                            data-product_stock="'.$product->stock.'"
                            data-url-cart="'.route('cart.store').'"
                            >
                            Add to cart
                        </button>

                        <!-- Wishlist -->
                        <div class="modal_pro_wishlist">
                        <a href="javascript:void(0)"
                            class="add_to_wishlist"
                            data-product-id="'.$product->id .'"
                            data-url='.route('wishlist.store') .'
                            id="add_to_wishlist-'.$product->id .'"><i class="icofont-heart"></i></a>
                           
                        </div>
                        <!-- Compare -->
                        <div class="modal_pro_compare">
                            <a href="compare.html"><i class="icofont-exchange"></i></a>
                        </div>
                    </div>
                    <!-- Share -->
                    <div class="share_wf mt-30">
                        <p>Share with friends</p>
                        <div class="_icon">
                            <a href="#"><i class="fab fa-facebook" aria-hidden="true"></i></a>
                            <a href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                            <a href="#"><i class="fab fa-pinterest" aria-hidden="true"></i></a>
                            <a href="#"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
                            <a href="#"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                            <a href="#"><i class="fab fa-envelope-o" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
            ';
        return $output;
    }

    public function categoryProducts(Request $request,$slug_url){
        $categories = ProductCategory::with('products')->where('slug', $slug_url)->where('status', 'active')->first();
        dd($categories->id);
       
        $sort = '';
        if($request->all() != null){
            $sort = $request->s;
        }

         if($categories->slug == ''){
            return view('errors.404');
         }else{
            switch ($sort) {
                case 'priceAsc':
                    $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])
                                        ->orderBy('sales_price', 'asc')
                                        ->paginate(20);
                    break;
                case 'priceDsc':
                    $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])
                                        ->orderBy('sales_price', 'desc')
                                        ->paginate(20);
                    break;
                case 'titleAsc':
                    $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])
                                        ->orderBy('title', 'asc')
                                        ->paginate(20);
                    break;
                case 'titleDsc':
                    $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])
                                        ->orderBy('title', 'desc')
                                        ->paginate(20);
                    break;
                case 'discountAsc':
                    $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])
                                        ->orderBy('product_discount', 'asc')
                                        ->paginate(20);
                    break;
                case 'discountDsc':
                    $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])
                                        ->orderBy('product_discount', 'desc')
                                        ->paginate(20);
                    break;
               
                default:
                    $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])->orWhere(['child_cat_id'=>$categories->id])
                    ->orderBy('id', 'desc')
                    ->paginate(12);
                    break;
            }
         }


        $route = 'products-category';
        return view('pages.category.products-category', 
        [
            'categories'=>$categories, 
            'route'=>$route,
            'products'=>$products
        ]);
    }

    public function ShopCart(Request $request){
        return view('pages.cart.mjstore-cart');
    }



}//end of class



