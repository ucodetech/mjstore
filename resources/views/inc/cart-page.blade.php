@php
    $cart = \Gloudemans\Shoppingcart\Facades\Cart::instance('shopping');
    // if(count($cart->content()) < 1){
    //     if(session()->has('coupon')){
    //         session()->flush('coupon');
           
    //     }
    // }
@endphp
<div class="container">
    <div class="row">
        <div class="col-lg-8">
          <div class="card bg-white">
            <div class="card-header text-uppercase justify-content">
                Cart ({{ count($cart->content()) }})   
            </div>
            {{-- @include('inc.cart-page') --}}
            @if (count($cart->content())> 0)
                        
    @foreach ($cart->content() as $item)
        @php
            $photo = explode(',',$item->model->photo);
            $total =  $item->price*$item->qty;
        @endphp
        <div class="card-body">
            <div class="media d-flex">
                
                <a class="d-flex">
                    <img src="{{ asset('storage/uploads/products/'.$photo[0]) }}" alt="{{ $item->name }}" class="img-thumbnail" width="60">
                </a>
                
                <div class="media-body pl-2">
                    <a href="{{ route('product.details', $item->model->slug) }} class="text-center">
                       {{wrap50($item->name)}}
                    </a><br>
                    <span class="text-muted">
                        {{( $item->model->stock < 10)? 'Few units left': 'In stock' }}
                    </span>
                    <div class="mt-3">
                        <button class="btn btn-sm btn-outline-primary"
                        data-url="{{ route('cart.delete') }}" id="deleteCart" data-id="{{ $item->rowId }}"><i class="fa fa-trash-alt"></i> Remove</button>
                    </div>
                </div>
                <div class="price_btns">
                    <h6 class="price">{{ Naira($item->price) }}  <br><span class="text-danger pt-5"><strike>{{ Naira($item->model->price) }}</strike></span>
                    <small class="text-italic" style="color: orangered"> 
                        <i>
                        -{{ N2P($item->model->product_discount) }}
                        </i>
                    </small>
                    </h6>
                        <style>
                            .input-number{
                                margin: 0 4px;
                                width: 50px !important;
                                border: 0;

                            }
                        </style>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-outline-danger btn-number p-0 DecQty" 
                                 data-type="minus" 
                                 data-id="{{ $item->rowId }}" 
                                 id="qty-input{{ $item->rowId }}" 
                                 data-value="{{ $item->qty }}">
                                 
                                <span class="fa fa-minus-circle fa-2x"></span>
                                </button>
                            </span>
                            <span class="form-control input-number" id="quantity_show{{ $item->rowId }}">{{ $item->qty }}</span>
                            <input type="hidden" name="r_quantity" id="r_quantity{{ $item->rowId }}" value="{{ $item->qty }}">
                            
                            <span class="input-group-btn">
                                <button type="button" 
                                class="btn btn-outline-success btn-number p-0 IncQty" 
                                data-id="{{ $item->rowId }}" 
                                id="qty-input{{ $item->rowId }}" 
                                data-type="plus"
                                data-value="{{ $item->qty }}">
                                <span class="fa fa-plus-circle fa-2x"></span>
                               
                                </button>
                                <input type="hidden" 
                                data-id="{{ $item->rowId }}" 
                                data-product-quantity="{{ $item->model->stock }}"
                                id="update-cart-{{ $item->rowId }}">
                            </span>
                            
                        </div>
                        
                    
                </div>
            </div>
           
        </div> 
        <hr>
        <span class="text-right text-muted p-2">
            @php
                $tot = $item->qty*$item->price ;
            @endphp
            Total: {{ $item->qty }} x {{ Naira($item->price) }} = {{ Naira($tot)}}
        </span>
        <hr>
    @endforeach
@else
    <h4 class="text-muted text-center">No item in cart yet!</h4>
@endif
              
    </div>              
        </div>
        <div class="col-lg-4">
            <div class="card bg-white">
                <div class="card-header bg-white text-uppercase">
                    <h6 class="card-title text-bold">
                            cart summary
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table border-0">
                        <tr class="border-0">
                            <th>
                                    Subtotal        
                            </th>        
                            <td class="text-info">
                                    {{ NairaSign().$cart->subtotal() }}
                            </td>
                        </tr>  
                        <tr>
                            @if (session()->has('coupon'))
                                <td>Saved:</td>
                                <td>{{ Naira(session('coupon')['value']) }}</td>
                            @endif
                            {{-- <td>Shipping</td>
                            <td>$10.00</td> --}}
                        </tr>
                        {{-- <tr>
                            <td>VAT (10%)</td>
                            <td>$5.60</td>
                        </tr> --}}
                        
                        <tr>
                            <td>Total</td>
                            @if (session()->has('coupon'))
                                @php
                                    $totalpay = removeComma($cart->subtotal()) - session('coupon')['value'];
                                @endphp
                                   <td> {{ Naira($totalpay) }}</td>
                            @else
                                 <td> {{ NairaSign().$cart->subtotal() }}</td>
                                  
                         @endif
                           
                        </tr>      
                    </table>
                <hr>
                <a href="{{ route('shop.billing.checkout') }}" class="btn btn-info btn-block">Checkout ({{session()->has('coupon') ?removeComma($cart->subtotal()) - session('coupon')['value'] : NairaSign().$cart->subtotal() }})</a>   
                </div>
            </div>
            <div class="card mt-5">
                <div class="cart-apply-coupon">
                    <h6>Have a Coupon?</h6>
                    <p>Enter your coupon code here &amp; get awesome discounts!</p>
                    <!-- Form -->
                    <div class="coupon-form">
                        <form action="{{ route('cart.apply.coupon.code') }}" method="POST" id="applyCouponForm">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="Enter Your Coupon Code">
                                 <span class="text-danger text-error coupon_code_error"></span>
                            </div>
                            <button type="submit" id="couponBtn" class="btn btn-primary">Apply Coupon</button>
                        </form>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
  

</div>

