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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductInformation;
use App\Models\ProductAttribute;
use App\Models\ProductReview;




class FrontPagesController extends Controller
{
    public function Index(){
        $banners = Banner::where('status', 'active')->where('condition', 'banner')->orderBy('id', 'desc')->limit(5)->get();
        $categories = ProductCategory::where('status', 'active')->where('is_parent', 1)->orderBy('title', 'asc')->get();
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
        $route = 'category';

        if($request->all() != null){
            $sort = $request->s;
            $getcolors = $request->color;
            $price_range = $request->price_range;
            $getbrands = $request->brand;
            $getsize = $request->size;
            
        }
        $price_range = $request->price_range;
        if(isset($_GET[$price_range])){
            $price_range = $_GET[$price_range];
        }
        $getcolors = $request->color;
        if(!empty($_GET[$getcolors])){
            $getcolors = $_GET[$getcolors];
        }
        $getbrands = $request->brand;
        if(!empty($_GET[$getbrands])){
            $getbrands = $_GET[$getbrands];
        }
        $getsize = $request->size != null ? $request->size : "";


        
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
            }
            else if($getcolors){
                $cols = explode(',',$getcolors);
                foreach($cols as $col){
                    $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])->where('color', 'LIKE', '%'.$col.'%')
                    ->paginate(20);
                }
                
            } else if($getsize){
                 $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])->where('size', 'LIKE', '%'.$getsize.'%')
                    ->paginate(20);
                
            }
            else if($getbrands){
                $bs = explode(',', $getbrands);
                $brs_ids = Brand::select('id')->whereIn('slug', $bs)->pluck('id')->toArray();
                $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])->whereIn('brand_id',$brs_ids)
                ->paginate(20);
                
                
            }
            else if($price_range){
                $price = explode('-', $price_range);
                $pricemin = floor($price[0]);
                $pricemax = floor($price[1]);
                $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])->whereBetween('sales_price', [$pricemin, $pricemax])
                ->paginate(20);
            }
            
            else{
                $products = Product::where(['status'=>'active', 'cat_id'=>$categories->id])->orWhere(['child_cat_id'=>$categories->id])
                ->orderBy('id', 'desc')
                ->paginate(12);
            }
            
           
         }
        $cat_child = ProductCategory::catChild($p_id);
        if($categories->is_parent != 1){
            $cat_child_parent = ProductCategory::where('id', $categories->parent_id)->first();
        }else{
            $cat_child_parent = '';
        }
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
//multi filter
    public function multiFilter(Request $request){
        //code
       
        $validator = Validator::make($request->all(), [
                    'm_brand' => 'required',
                    'm_color' => 'required',
                    'm_size' => 'required',  
        ],[
            'm_brand.required'=> "Brand is required!",
            'm_color.required'=> "Color is required!",
            'm_size.required'=> "Size is required!"
        ]);
        if(!$validator->passes()){
            return  response()->json(['code'=>0, 'error'=>$validator->errors()->toArray()]);
        }else{
            $cat_id = $request->cat_id;
            $brand = $request->m_brand;
            $color = $request->m_color;
            $size = $request->m_size;

            $products = Product::where('cat_id', $cat_id)
                                ->where('brand_id',$brand)
                                ->Where('color','LIKE', '%'.$color.'%')
                                ->Where('size', 'LIKE', '%'.$size.'%')
                                ->paginate(20);
             
          }
         

        $output = '';
      
          // product
          if(count($products)>0){
         
          $output.=' <div class="row">';
                foreach($products as $product){
                    $photo = explode(',',$product->photo);
                    $price = ($product->product_discount == 0.00) ? " ": currency_converter($product->price);

         $output.='<div class="col-md-3 col-sm-6 pb-3">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="'.route('product.details', $product->slug) .'" title="'.$product->title .'">';
                            if (count($photo)>1)
                            $output.='  <img decoding="async" class="pic-1" src="'.asset('storage/uploads/products/'.$photo[0] ) .'">
                                <img decoding="async" class="pic-2" src="'.asset('storage/uploads/products/'.$photo[1] ).'">';
                            else
                            $output.=' <img decoding="async" class="pic-1" src="'.asset('storage/uploads/products/'.$photo[0] ) .'">';
                                                        
                     $output.='</a>';
                     $output.=' <ul class="social">
                                <li><a 
                                    style="cursor:pointer"
                                    data-tip="Quick View"
                                    id="quickViewProduct" 
                                    data-url="'. route('product.quickview.detail') .'" 
                                    data-id="'. $product->unique_key .'"
                                    ><i class="fa fa-search"></i></a>
                                </li>
                                
                                <li>
                                <a
                                style="cursor:pointer"  
                                data-tip="Add to Wishlist"
                                href="javascript:void(0)"
                                class="add_to_wishlist"
                                data-product-id="'.$product->id .'"
                                data-url='.route('wishlist.store') .'
                                id="add_to_wishlist-'.$product->id .'" 
                                ><i class="fa fa-shopping-bag"></i></a>
                                </li>
                                
                                
                            </ul>
                                <span class="product-new-label bg-primary">'.$product->condition.'</span>
                             <span class="product-discount-label" style="background:orangered">'.N2P($product->product_discount).'</span>
                        </div>
                                <ul class="rating">
                                    <li class="fa fa-star"></li>
                                    <li class="fa fa-star"></li>
                                    <li class="fa fa-star"></li>
                                    <li class="fa fa-star"></li>
                                    <li class="fa fa-star disable"></li>
                                </ul>
                                <div class="product-content">
                                    <h3 class="title">
                                        <a href="'.$product->slug.'">
                                           '.$product->title.'
                                        </a>
                                        <p class="m-0 p-0"><span class="text-sm text-muted">'.$product->brand->title.'</span></p>
                                    </h3>
                                    <div class="price text-success">
                                    '.currency_converter($product->sales_price).'
                                    <span class="text-danger text-strike"> 
                                    '.$price.'
                                    </span>
                                    </div>
                                    <a style="cursor:pointer"
                                    data-quantity="1"
                                    data-product-id="'. $product->id .'"
                                    class="btn btn-info text-light  add_to_cart"
                                    id="add_to_cart'. $product->id .'"
                                    data-stock="'. $product->stock .'"
                                    data-url-cart="'.route('cart.store') .'"
                                    ><i class="fa fa-shopping-cart"></i> Add To Cart</a>
                                </div>
                            </div>
                    </div>';
                    
               
                }
                
      $output.='</div>';
      
         } else {
            
          $output.='<h4 class="text-muted">No product found</h4>';
          
         }
                    
         return ['code'=>1, 'data'=> $output];
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
        $count_review = ProductReview::where('status', 'accept')->count();

        if($product){
            $likeproducts = Product::where('status', 'active')
                                    ->where('slug', '!=', $slug_url)
                                    ->where('cat_id', $product->cat_id)
                                    ->orderBy('id', 'desc')
                                    ->limit(5)
                                    ->get();
            $pinfo = ProductInformation::where('product_id', $product->id)->first();
            $productAttr = ProductAttribute::where('product_id', $product->id)->get();
                return view('pages.mjstore-product-details', 
                [
                    'product'=>$product,
                    'likeproducts'=>$likeproducts,
                    'pinfo'=>$pinfo,
                    'productAttr'=>$productAttr,
                    'count_review' => $count_review
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
        $price = $product->product_discount == 0 ? " " :  currency_converter($product->price);
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
                        <h5 class="price">'.currency_converter($product->sales_price).' <span class="text-danger">'.$price.'</span></h5>
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
    //not using this
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


    //fetch brands
    public function fetchBrand(Request $req){
        $brands = Brand::with('product')->where('status', 'active')->OrderBy('title', 'asc')->get(); 
        $output = "";
            $brnds = $req->brands;
            if($brnds){
                $filteredbrand = explode(',',$brnds);
            }else{
                $filteredbrand = [];
            }
             

            if(count($brands)>0){
                foreach($brands as $key=>$brand){
                
                        if(count($brand->product)==0){
                            $text = 'text-danger';
                        }elseif(count($brand->product) < 5){
                            $text = 'text-warning';
                        }else{
                            $text = 'text-success';
                        }
                        
                
                $output.='<div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                        <input type="checkbox" class="custom-control-input product_brand" id="product_brand'.$brand->id.'" name="product_brand[]" data-id="'.$brand->id.'" value="'.$brand->slug.'"  '.(in_array($brand->slug, $filteredbrand) ? " checked": "").'>
                        <label class="custom-control-label" for="product_brand'.$brand->id.'">'.$brand->title.' <span class="'.$text.'">('.count($brand->product) .')</span></label>
                    </div>';
                }
               
        }else{
            $output.='<h5 class="text-center text-muted">No brand found</h5>';
        }
        return $output;
        
    }
    //search brand
    public function searchBrand(Request $req){
        $search = $req->brand;
        $brands = Brand::with('product')->where('status', 'active')
                        ->where('title', 'LIKE', '%'.$search.'%')->get(); 
        $output = "";
        $brnds = $req->brands;
        $filteredbrand = explode(',',$brnds);

            if(count($brands)>0){
                foreach($brands as $key=>$brand){
                
                        if(count($brand->product)==0){
                            $text = 'text-danger';
                        }elseif(count($brand->product) < 5){
                            $text = 'text-warning';
                        }else{
                            $text = 'text-success';
                        }
                        
                
                        $output.='<div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                        <input type="checkbox" class="custom-control-input product_brand" id="product_brand'.$brand->id.'" name="product_brand[]" data-id="'.$brand->id.'" value="'.$brand->slug.'"  '.(in_array($brand->slug, $filteredbrand) ? " checked": "").'>
                        <label class="custom-control-label" for="product_brand'.$brand->id.'">'.$brand->title.' <span class="'.$text.'">('.count($brand->product) .')</span></label>
                    </div>';
                }
            
        }else{
            $output.='<h6 class="text-center text-muted">No brand found</h6>';
        }
        return $output;
        
    }

    public function autoSearch(Request $request){
        $search_term = $request->search_term;
        $titles = PRODUCT::select(['title', 'slug','photo'])->where('title', 'LIKE', '%'.$search_term.'%')->where('status', 'active')->get();
        $data= "";
        if(count($titles)>0){
            foreach($titles as $title){
                $photo = explode(',',$title->photo);
                $data .='<a href="'.route('product.details', $title->slug).'" class="text-dark mb-3">
                <img src="'.asset('storage/uploads/products/'.$photo[0] ).'" class="img-fluid img-thumbnail" width="50">
                <i class="fa fa-check fa-sm text-muted"></i>&nbsp;<span>'.$title->title.'</span>
                </a>';
            }
        }else{
            $data .='<a  class="text-muted  text-center mb-3"><span>No record found!</span></a>';
        }
        return $data;
    }

    public function formattedCurrency(Request $req){
        return currency_converter($req->attr_price);
    }


// product review
public function submitReview(Request $request){
    $validator = Validator::make($request->all(), [
                'rate' => 'required',
                'review_reason' => 'required'
    ]);

    if(!$validator->passes()){
            return response()->json(['code'=>0, 'error'=> $validator->errors()->toArray()]);
    }else{
             $user = auth()->user()->id;
            ProductReview::create([
                'product_id' => $request->product_id,
                'user_id' => $user,
                'reason' => $request->review_reason,
                'comment' => $request->comments,
                'rate' => $request->rate,
                'nickname' => $request->nickname,
                'status'=> 'pending'
            ]);
            return response()->json(['code'=>1, 'msg'=> "Your review have been submitted and will be visible to the public once the admin approves it!"]);
    }

}

public function fetchReview(Request $req){
    //
    if($req->data == "getReviews"){
        $reviews = ProductReview::where(['product_id'=>$req->product_id,'status'=>'accept'])->orderBy('created_at', 'desc')->get();

        $data = "";
        if(count($reviews)> 0 ){
            foreach($reviews as $review){
                $data .= '
                <div class="single_user_review mb-15" >
                <div class="review-rating">';
                for($i = 0; $i <= $review->rate; $i++){
                    $data .= '<i class="fa fa-star" aria-hidden="true"></i>';
                }
                    $comments = ($review->comment != "") ? $review->comment : "";
                   $data.='<span>'.$review->review_reason.'</span>
                </div>
                <div class="review-details">
                    <p>by <a href="#">'.strtoupper($review->nickname).'</a> on <span>'.pretty_dates($review->created_at).'</span></p>
                    <p>'.$comments.'</p>
                </div>
                </div>
                
                ';
            }
        }else{
            $data .='<span class="text-center text-muted">No reviews yet</span>';
        }

        return $data;
        
    }

}

}//end of class



