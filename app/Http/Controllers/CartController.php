<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;
use Illuminate\Support\Facades\Validator;
use App\Models\AppliedCoupon;
use App\Models\ProductAttribute;
use App\Models\Wishlist;

 

class CartController extends Controller
{
   public function StoreCartItem(Request $request){
        if($request->product_quantity2){
          $product_quantity = $request->product_quantity2;
        }else{
           $product_quantity = $request->product_quantity;
        }
        
        if($request->product_stock2){
          $product_stock = $request->product_stock2; // total stock of the product in the database
        }else{
           $product_stock = $request->product_stock; 
        }
        $product_id = $request->product_id;
        $msg = "";
        //check if product has attributes
        $pro_attr = ProductAttribute::where('product_id', $product_id)->first();

        if($pro_attr){
          if($request->attribute_size == ""){
             $msg = 'Please select product size before adding to cart!';
              return response()->json(['status'=>false, 'message'=>$msg]);
          }

        }
      
          // if requested quantity is greater than  product stock return false, product is out of stock 
          if($product_quantity > $product_stock){
              $msg = 'Product has ran out of stock!';
              return response()->json(['status'=>false, 'message'=>$msg]);
          }elseif($product_quantity<1){
              $msg = 'Cart quantity can not be less than 1';
              return response()->json(['status'=>false, 'message'=>$msg]);
  
          }
  
        $product = Product::getProductByCart($product_id); //getProductByCart will be defined in the product model so that we can easily return self
        // $product returns a collection of the product in the database with zero index

        //let $product be used as $p
        $p =  $product[0]; 
        $price = $p['sales_price'];
        //check if product has color 
        // if(Product::where('id', $product_id)->first()->color != null){
        //   if($request->color == ""){
        //     $msg = 'Please select product color before adding to cart!';
        //      return response()->json(['status'=>false, 'message'=>$msg]);
        //   }
             
        // }
        //check attribute requests
        if($request->attr_sales_price){
          $price = $request->attr_sales_price;
        }else{
          $price = $price;
        }
        if($request->color){
          $color = $request->color;
        }else{
          $color = "";
        }
        if($request->attribute_size){
          $attribute_size = $request->attribute_size;
        }else{
          $attribute_size = "";
        }
        //end check
       //make a cart array
       $cart_array=[];
        // let cart instance = Cart::instance()
        $cart_instance = Cart::instance('shopping');
       foreach($cart_instance->content() as $item){
            $cart_array[] = $item->id;
       }
      //  Cart::add('293ad', 'Product 1', 1, 9.99);
      // id, name, quantity, price of the product,size if exist, color if exist
       $result = $cart_instance->add($product_id, $p['title'], $product_quantity, $price, ['size'=>$attribute_size,'color'=> $color])->associate(Product::class);
      //  To store your cart instance into the database, you have to call the store($identifier)  method. Where $identifier is a random key, for instance the id or username of the user.

      // Cart::store('username');
      // // To store a cart instance named 'wishlist'
      // Cart::instance('wishlist')->store('username');
      if(Auth::check()){
         Cart::store(auth()->user()->id);
      }
     
        
       if($result){
          if($request->wishlist_id){
            Wishlist::find($request->wishlist_id)->delete();
           }
         $response['status']=true;
         $response['product_id']=$product_id;
         $response['product_quantity']=$product_quantity;
         $response['total'] = Cart::subtotal();
         $response['cart_count']=$cart_instance->count();
         $response['message']='Item added to cart!';
       }
       if($request->ajax()){
         $cart_header = view('inc.cart_area')->render();
         $response['cart_header']=$cart_header;
       }
       return json_encode($response);
        
   }


public function DeleteCartItem(Request $request){
      $id = $request->cart_id;
      $cart_instance = Cart::instance('shopping');
      $cart_instance->remove($id);
      //if session has coupon delete it
      if(session()->has('coupon')){
        //  session()->destroy('coupon');
         session()->forget('coupon');
        
      }
      $response['status']= true;
      $response['total'] = Cart::subtotal();
      $response['cart_count']=$cart_instance->count();
      $response['message'] = 'Item removed from cart';
      
      if($request->ajax()){
         $cart_header = view('inc.cart_area')->render();
         $response['cart_header']=$cart_header;
         $cart_page_render = view('inc.cart-page')->render();
         $response['cart_page_render']=$cart_page_render;
       }
       return json_encode($response);
}


public function updateCart(Request $request){
    $cart_id = $request->cart_id;
    $requested_quantity = $request->product_cart_quantity;
    $productStockQuantity = $request->productQuantityStock;

    // if requested quantity is greater than  product stock return false, product is out of stock 
    if($requested_quantity>$productStockQuantity){
      $msg = 'Product has ran out of stock!';
      $response['status']=false;
    }elseif($requested_quantity<1){
        $msg = 'Cart quantity can not be less than 1';
        $response['status']=false;
    }else{
      $cart_instance = Cart::instance('shopping');
            //table fields id, name, quantity, price of the product
      $cart_instance->update($cart_id, $requested_quantity);
      $msg = 'Cart has been updated!';
      $response['total'] = Cart::subtotal();
      $response['cart_count']=$cart_instance->count();
      $response['status']=true;
    }
    if($request->ajax()){
      $cart_header = view('inc.cart_area')->render();
      $response['cart_header']=$cart_header;
      $cart_page_render = view('inc.cart-page')->render();
      $response['cart_page_render']=$cart_page_render;
      $response['msg']=$msg;
    }
    return json_encode($response);
}

//apply coupon 
public function applyCoupon(Request $request){

    $validator = Validator::make($request->all(),[
                    'coupon_code' => 'required|exists:coupons,coupon_code'
    ],[
      'coupon_code.exists' => 'Coupon does not exist! retype code'
    ]);
    if(!$validator->passes()){
      return response()->json(['code'=>0, 'error'=> $validator->errors()->toArray()]);
    }else{
      $code = $request->coupon_code;
      $coupon = Coupon::where('coupon_code', $code)->first();
      if($coupon->coupon == 'inactive'){
        $msg = 'Coupon has expired!';
        $response['code']=2;
        $response['error']=$msg;
        return json_encode($response);  
        // return response()->json(['code'=>2, 'error'=>'Coupon has expired']);
      }else{
          $cart_instance = Cart::instance('shopping');
          $tot_price = $cart_instance->subtotal();
          if(session()->has('coupon')){
            //  session()->destroy('coupon');
             session()->forget('coupon');
            
          }
          session()->put('coupon',[
                'id' => $coupon->id,
                'code' => $coupon->coupon_code,
                'value' => $coupon->discount(removeComma($tot_price)),
               
                //try to convert the tot price to int or double
                // convert to int first
          ]);
          $msg = 'Coupon applied Successfully!';
          $response['code']=1;
          $response['msg']=$msg;

          if($request->ajax()){
            $cart_header = view('inc.cart_area')->render();
            $response['cart_header']=$cart_header;
            $cart_page_render = view('inc.cart-page')->render();
            $response['cart_page_render']=$cart_page_render;
          }
          return json_encode($response);
          // return response()->json(['code'=>1,'cart_header'=>$cart_header, 'cart_page_render'=>$cart_page_render, ]); 
          

      }
    }
  
  
}

public function clearCouponSession(){
  $cart = Cart::instance('shopping');
  if(count($cart->content()) < 1){
      if(session()->has('coupon')){
          session()->forget('coupon');
          return true;
      }
  }
}

}//end of class
