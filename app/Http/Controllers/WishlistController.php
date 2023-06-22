<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class WishlistController extends Controller
{
   public function StoreWishlist(Request $request){
        if(!Auth::check()){
            return response()->json(['code'=>0, 'error'=> 'You have to login to add item to wishlist']);
        }else{
            $product_id = $request->product_id;
            $mywishlists = Wishlist::where('product_id', $product_id)->first();
            if($mywishlists){
                return response()->json(['code'=>2, 'error'=> 'You have already added this item to wishlist!']);
            }else{
                Wishlist::create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $product_id,
                    'created_at' => Carbon::now()
                ]);
                return response()->json(['code'=>1, 'message'=> 'Item added to wishlist']);
            }
        }
    }


    public function ShopWishlist(){
        // $mywishlists = Wishlist::where('user_id', auth()->user()->id)->get();
        return view('users.user.wishlist.mjstore-wishlist');
    }

    
    public function DeleteWishlist(Request $request){
        $id = $request->item_id;
        Wishlist::where('id', $id)->delete();
        // return redirect()->back()->withErrors('Item deleted')->withInput();
        // $wishlist_section = view('inc.wishlist-page')->render();
        return response()->json(['code'=>1,'message'=>'Item deleted from wishlist!']);
       
    }

    public function ajaxWishlist(Request $request){
           if($request->grab == 'fetchUserWishlist'){
                $wishlists = Wishlist::where('user_id', auth()->user()->id)->get();
                $output = '';
                if(count($wishlists)){
                    $output .= '<div class="col-md-12 shadow p-4 mb-3 rouneded-end">
                    Wishlist: All Items (<span class="text-info">'.(($wishlists)? count($wishlists):'').'</span>)</div>';
                    foreach($wishlists as $item){
                        $pro = Product::find($item->product_id);
                        $photo = explode(',',$pro->photo);
                        $output .= '
                        <input type="hidden" name="wishlist_id" id="wishlist_id" value="'.$item->id.'">
                        <div class="col-md-12 shadow p-4 mb-3 rounded-end">
                        <div class="container-fluid d-flex gap-10">
                            <div class="img d-md-flex">
                                <img src="'.asset('storage/uploads/products/'.$photo[0]) .'" alt="" class="img-fluid img-bordered rounded-10" width="108"> &nbsp; &nbsp;
                                <section class="d-block">
                                    <hr class="invisible">
                                    <a href="'.url("/product-details/". $pro->slug).'"><span>'.$pro->title .'</span></a><br>  
                                    <small class="text-muted"><i>400+ orders</i></small><br> 
                                    <span class="text-success">'.Naira( $pro->sales_price).' <small class="text-danger"><strike>'.Naira( $pro->price).'</strike></small></span> <br> 
                                    <small class="text-danger">discount: '.Naira($pro->product_discount) .' =>>>> '.  N2P($pro->product_discount) .'</small> 
                                </section>
                            </div>
                            <div class="actions">
                            <div class="row p-2">

                                <div class="col-md-6 mb-2">
                                    <button type="button" class="btn btn-success btn-rounded btn-block"
                                    id="quickViewProduct" data-url="'.route('product.quickview.detail').'" data-id="'.$pro->unique_key.'"> <i class="fa fa-cart-plus fa-lg"></i> Move to Cart</button>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <a href="javascript:void(0)" class="btn btn-block btn-danger btn-rounded deleteWishlistItem"
                                    data-id="'.$item->id .'"
                                    data-url="'.route('user.wishlist.delete') .'"
                                    id="deleteWishlistItem"> <i class="fa fa-trash-alt fa-lg"></i> Delete</a>
                                  
                                </div>
                                <div class="col-md-12">
                                        <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="product_link'.$item->id.'" aria-label="product Link" aria-describedby="basic-addon2" value="'.url('/product-details/'.$pro->slug).'" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-info" data-id="'.$item->id.'" id="copyLinkBtn" type="button"> <i class="fa fa-share-alt fa-lg"></i> Share</button>
                                        </div>
                                     </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                        
                        ';
                    }
                  
                    
                }else{
                    $output .= '<div class="col-md-12 shadow p-4 mb-3 rouneded-end">
                                    <h3 class="text-muted text-center">Wishlist is empty</h3>
                                </div>';
                }
                return $output;
                
           }
    }



}//end of class
