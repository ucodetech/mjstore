<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Shipping;
use App\Models\TemporaryCheckoutProcess;
use Illuminate\Support\Facades\Validator;
use App\Models\State;
use App\Models\LocalGov;
use Illuminate\Support\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Order;
use Illuminate\Support\Str;
use App\Models\OrderItems;
use Illuminate\Support\Facades\Mail;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\DB;


class CheckoutController extends Controller
{


    public function getOrderDetails(Request $request){
        $is_user_entered = TemporaryCheckoutProcess::where('user_id', auth()->user()->id)->first();
        $output = '';
        $cart = Cart::instance('shopping');
        $output .='<div class="table-responsive">
            <table class="table mb-3">
                <tbody>
                    <tr>
                        <td>Sub Total</td>
                        <td>'.currency_converter(Cart::subtotal()).'</td>
                    </tr>
                    <tr>';
                    if (session()->has('coupon')){
                        $output .='<td>Saved:</td>
                         <td>'.currency_converter(session("coupon")["value"]).'</td>';
                     }
                    $output.='</tr>
                    <tr>';
                    if($is_user_entered){
                        if($is_user_entered->delivery_charge != 0){
                            $output.='<td>Delivery Fee</td>
                            <td>'.currency_converter($is_user_entered->delivery_charge).'</td>';
                        }
                    }
                    $output .='</tr>
                    
                    <tr>
                        <td>Total</td>';
                        if (session()->has('coupon')){
                                $totalpay = removeComma($cart->subtotal()) - session('coupon')['value'];
                                if($is_user_entered){
                                    $totalpay = $totalpay + $is_user_entered->delivery_charge;
                                    
                                }
                                    $output.='<td class="text-primary">'.currency_converter($totalpay).'</td>';
                        }else{
                            
                            if($is_user_entered){
                                $totPay = removeComma($cart->subtotal()) + $is_user_entered->delivery_charge;
                                $output.='<td class="text-primary">'.currency_converter($totPay).'</td>';
                                
                            }else{  
                                $totPay = $cart->subtotal();
                                $output.='<td class="text-primary">'.currency_converter($totPay).'</td>';
                            }
                              
                    }
                        
                    $output.='</tr>
                </tbody>
            </table>
            <a href="'.route('shop.cart').'" class="btn btn-info btn-block">Modify Cart</a>
        </div>';

        return $output;
}

    
    public function CheckoutProcess(Request $request){
        $tmp_order_delete = TemporaryCheckoutProcess::where('user_id', auth()->user()->id)
        ->where('created_at', '<', Carbon::today() )->first();
            if($tmp_order_delete){
            $tmp_order_delete->delete();
         }
        $countries = Country::orderBy('country', 'asc')->get();
        $states = State::all();
        $shippings = Shipping::where('status', 'active')->orderBy('id', 'desc')->get();
        // dd($states);
        $is_user_entered = TemporaryCheckoutProcess::where('user_id', auth()->user()->id)->first();
        return view('pages.checkout.mjstore-checkoutprocess', 
                        [
                            // 'countries'=>$countries,
                            'states' => $states,
                            'is_user_entered' => $is_user_entered,
                            'shippings' => $shippings 
                        ]
                    );
    }

    public function getStateLGA(Request $request){
        $state = $request->state;
        
        $stateid = State::where('name', $state)->first()->state_id;
        $data = LocalGov::where('state_id', $stateid)->pluck('local_id', 'local_name');
       
        if($data->count()){
            return  response()->json(['code'=>1, 'data'=>$data, 'msg'=>'']);
        }else{
            return response()->json(['code'=>0, 'data'=>Null, 'msg'=>'No LGA!']);
        }
    }

    public function BillingCheckoutSubmit(Request $request){
        $validator = Validator::make($request->all(), [
                        'address' => 'required',
                        'email' => 'required',
                        'fullname' => 'required',
                        'phone_number' => 'required',
                        'state' => 'required',
                        'city' => 'required'
                 ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0, 'error'=>$validator->errors()->toArray()]);
        }else{
            $check = TemporaryCheckoutProcess::where('user_id', auth()->user()->id)->first();
            if($check){
                // update
                $check->where('user_id', auth()->user()->id)->update([
                    'address' => $request->address,
                    'town'  => $request->town,
                    'state'  => $request->state,
                    'postcode'  => $request->postcode,
                ]);
                return response()->json(['code'=>1, 'msg'=>'Address Saved!']);
            }else{
                // create new 
                TemporaryCheckoutProcess::create([
                    'user_id'  => auth()->user()->id,
                    'fullname' => $request->fullname,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'address' => $request->address,
                    'town' => $request->city,
                    'state' => $request->state,
                    'postcode' => $request->postcode,
                    'address_entered' => 1
                ]);
                return response()->json(['code'=>1,'msg'=>'Address Saved!']);
                
            }

        }
    }

    //get cities of pre selected state on edit of address
    public function getStateCity(Request $request){
        $state = $request->state_name;
        $selected = $request->selected;
        $state_id  =  State::where('name', $state)->first()->state_id;
        $cities =  LocalGov::where('state_id', $state_id)->get();
        $output = '';

        $output .= '<option value="">--Select City--</option>';
        foreach($cities as $city){
            $output.='<option value="'.$city->local_name.'" '.(($request->selected == $city->local_name)?' selected':'').'>'.$city->local_name.'</option>';
        }

        return $output;
    }
    

    public function ShippingCheckoutSubmit(Request $request){

        if($request->updateShippingEntered == 'shippingEntered'){
            $user = auth()->user()->id;
            TemporaryCheckoutProcess::where('user_id', $user)->update([
                        'delivery_method_entered' => 1
            ]);
            
            return true;
        }else{
            $id = $request->method_id;
            $fee =  $request->delivery_fee;
            $user = auth()->user()->id;
            $cart = Cart::instance('shopping');

            $totalAmount = removeComma($cart->subtotal()) + $fee;
            $totalAmount = session()->has('coupon') ? $totalAmount - session('coupon')['value'] : $totalAmount;
            TemporaryCheckoutProcess::where('user_id', $user)->update([
                        'delivery_charge' => $fee,
                        'shipping_method' => $id,
                        'sub_total'  => removeComma($cart->subtotal()),
                        'total_amount' => $totalAmount,
                        'quantity' => count($cart->content())
            ]);
            if(session()->has('shipping_method_checked')){
                session()->flash('shipping_method_checked');
            }
            session()->put('shipping_method_checked', [
                            'method_id' => $id
            ]);
            return true;
         }
        
    }

    public function getShippingDetails(Request $request){
            $is_user_entered = TemporaryCheckoutProcess::where('user_id', auth()->user()->id)->first();
            $output = '';
            $cart = Cart::instance('shopping');
            $output .='<div class="table-responsive">';

                    $output .= '<small class="text-muted"> Shipment '.count($cart->content()).'</small> <br>';
                       
                   $output.='<ul class="list-group border-1">';

                    foreach ($cart->content() as $item) {
                        $output.='<li class="list text-muted"><small> '.$item->qty.'x &nbsp; '.$item->name.'</small></li>';
                    }
                    $delivery_time = $is_user_entered ?  Shipping::where('id',  $is_user_entered->shipping_method)->first()->delivery_time:'';
                    $output.='<small class="text-muted mt-2">
                        '.$delivery_time.'
                    </small>';
                   $output.='</ul>';
               
                $output.='<hr class="invisible">
                <table class="table mb-3">
                    <tbody>
                        <tr>
                            <td>Sub Total</td>
                            <td>'.currency_converter(Cart::subtotal()).'</td>
                        </tr>
                        <tr>';
                        if (session()->has('coupon')){
                            $output .='<td>Saved:</td>
                            <td>'.currency_converter(session("coupon")["value"]).'</td>';
                        }
                        $output.='</tr>
                        <tr>';
                        if($is_user_entered){
                            if($is_user_entered->delivery_charge != 0){
                                $output.='<td>Delivery Fee</td>
                                <td>'.currency_converter($is_user_entered->delivery_charge).'</td>';
                            }
                        }
                        $output .='</tr>
                        
                        <tr>
                            <td>Total</td>';
                            if (session()->has('coupon')){
                                $totalpay = removeComma($cart->subtotal()) - session('coupon')['value'];
                                if($is_user_entered){
                                    $totalpay = $totalpay + $is_user_entered->delivery_charge;
                                    
                                }
                                    $output.='<td class="text-primary">'.currency_converter($totalpay).'</td>';
                        }else{
                            
                            if($is_user_entered){
                                $totPay = removeComma($cart->subtotal()) + $is_user_entered->delivery_charge;
                                $output.='<td class="text-primary">'.currency_converter($totPay).'</td>';
                                
                            }else{  
                                $totPay = $cart->subtotal();
                                $output.='<td class="text-primary">'.CurrencySign().$totPay.'</td>';
                            }
                              
                        }
                            
                        $output.='</tr>
                    </tbody>
                </table>
            </div>';

            return $output;
    }


    //change shipping method
    public function changeShippingMethod(Request $request){

        if($request->updateShippingMethod == 'shippingMethodUp'){
            $user = auth()->user()->id;
            TemporaryCheckoutProcess::where('user_id', $user)->update([
                        'delivery_method_entered' => 0
            ]);
            
            return true;
        }
        
    }


    public function UpdateBillingCheckoutSubmit(Request $request){
        $validator = Validator::make($request->all(), [
            'edit_address' => 'required',
            'edit_email' => 'required',
            'edit_fullname' => 'required',
            'edit_phone_number' => 'required',
            'state' => 'required',
            'city' => 'required'
        ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0, 'error'=>$validator->errors()->toArray()]);
        }else{
            
            // create new 
        TemporaryCheckoutProcess::where('user_id',  auth()->user()->id)->update([
            'fullname' => $request->edit_fullname,
            'email' => $request->edit_email,
            'phone_number' => $request->edit_phone_number,
            'address' => $request->edit_address,
            'town' => $request->city,
            'state' => $request->state,
            'postcode' => $request->postcode,
            'address_entered' => 1
        ]);
        return response()->json(['code'=>1,'msg'=>'Address Updated!']);
        
    

        }
    }

    public function PaymentCheckoutSubmit(Request $request){
        $smethod = $request->p_method;
        TemporaryCheckoutProcess::where('user_id', auth()->user()->id)->update([
                'payment_method' =>  $smethod,
                'payment_status' => 0
        ]);
        return true;
    }
    public function PaymentProceed(){
        if(TemporaryCheckoutProcess::where('user_id', auth()->user()->id)->first()->payment_method == ''){
            return redirect()->back()->withErrors('Please select payment method before proceeding to next step')->withInput();
        }

       
        $tmp_order = TemporaryCheckoutProcess::where('user_id', auth()->user()->id)->first();
        $orderNo = 'MJORD-'.Str::random(10);
        $create = Order::create([
                'order_number' => $orderNo,
                'user_id' => auth()->user()->id,
                'sub_total' => $tmp_order->sub_total,
                'total_amount' => $tmp_order->total_amount,
                'coupon' => $tmp_order->coupon,
                'delivery_charge' => $tmp_order->delivery_charge,
                'quantity' => $tmp_order->quantity,
                'payment_method' => $tmp_order->payment_method,
                'payment_status' => $tmp_order->payment_status,
                'order_status' => 'pending',
                'fullname' => $tmp_order->fullname,
                'email' => $tmp_order->email,
                'phone_number' => $tmp_order->phone_number,
                'address' => $tmp_order->address,
                'town' => $tmp_order->town,
                'state' => $tmp_order->state,
                'postcode' => $tmp_order->postcode,
                'order_notes' => $tmp_order->order_notes,
                'shipping_method' => $tmp_order->shipping_method
        ]);

        if($create){
                $cart = Cart::instance('shopping');
                $orderid = Order::where('order_number', $orderNo)->first();
                foreach($cart->content() as $item){
                    OrderItems::create([
                        'product_id' => $item->model->id, 
                        'order_id' => $orderid->id,
                        'product_qty' => $item->qty, 
                        'u_order_id' => $orderid->order_number, 
                        'product_name' => $item->model->title
                    ]);
                   
                    $newstock = Product::where('id', $item->model->id)->first()->stock - $item->qty;
                    Product::where('id', $item->model->id)->update([
                                'stock' =>  $newstock
                    ]);
                    $attribute = ProductAttribute::where('product_id', $item->model->id)->first();
                    $color = ($item->options->has('color') ? $item->options->color : "");
                    if($color != ""){
                        OrderItems::where('u_order_id', $orderid->order_number)->update([
                            'product_color' => $color
                        ]);
                    }
                    if($attribute){
                        $attrstock = $attribute->stock - $item->qty;
                        ProductAttribute::where('product_id', $item->model->id)->update([
                            'stock' =>  $attrstock
                         ]);
                         OrderItems::where('u_order_id', $orderid->order_number)->update([
                            'product_size' => $attribute->size
                        ]);
                    }
                }
                $order_number = $orderid->order_number;
                $message = 'Order Number: ' . $order_number;
                $actionLink = route('user.customer.orders', ['service'=>'Order Comfirmation']);
                $orderItems = OrderItems::with('products')->where('u_order_id', $order_number)->get();
                $current_order =  Order::where('order_number', $order_number)->first();
                $data = [
                        'mailFrom' =>  $tmp_order->email,
                        'mailTo' =>  $tmp_order->email,
                        'mailFromName' =>  $tmp_order->fullname,
                        'subject' => 'Order Comfirmation',
                        'body' => $message,
                        'actionLink' => $actionLink,
                        'orderid' => $order_number,
                        'orderItems' => $orderItems,
                        'current_order' => $current_order
                ];
                //send mail 
                    Mail::send('inc.order-email-template', $data, function ($message) use ($data) {
                        $message->from($data['mailFrom'], $data['mailFromName'])
                        ->to($data['mailTo'])
                        ->cc(['gtechnoproject22@gmail.com', 'admin@gmail.com'])
                        ->subject($data['subject']);
                    //    ->replyTo('john@johndoe.com', 'John Doe')
                    //    ->attach('pathToFile');
                    });

                    // Mail::send('Html.view', $data, function ($message) {
                    //     $message->from('john@johndoe.com', 'John Doe');
                    //     $message->sender('john@johndoe.com', 'John Doe');
                    //     $message->to('john@johndoe.com', 'John Doe');
                    //     $message->cc('john@johndoe.com', 'John Doe');
                    //     $message->bcc('john@johndoe.com', 'John Doe');
                    //     $message->replyTo('john@johndoe.com', 'John Doe');
                    //     $message->subject('Subject');
                    //     $message->priority(3);
                    //     $message->attach('pathToFile');
                    // });
                    
                   
                // end send mail 
                $tmp_order->delete();
                if(session()->has('shipping_method_checked')){
                    session()->forget('shipping_method_checked');
                }
                if(session()->has('checked_method')){
                    session()->forget('checked_method');
                }
                $cart->destroy();
                
                return redirect()->route('shop.order.completed', $order_number);
            // return view('pages.checkout.order-completed', ['order_number',$order_number]);
        }
    }
    public function orderCompleted($order_number){
        $order_number=$order_number;
        return view('pages.checkout.order-completed', ['order_number'=>$order_number]);
    }

    // public function tempView(){
    //     return view('inc.order-email-template');
    // }
}//end of class
