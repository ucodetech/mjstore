 <!-- Cart -->
 @php
    $cart = \Gloudemans\Shoppingcart\Facades\Cart::instance('shopping');
@endphp
 <!-- Wishlist -->


 <div class="cart-area" id="cart_header">
    <div class="cart--btn"><i class="icofont-cart"></i> <span class="cart_quantity" id="cart_quantity">{{ $cart->count() }}</span>
    </div>

    <!-- Cart Dropdown Content -->
    <div class="cart-dropdown-content">
        <ul class="cart-list">
           @foreach ($cart->content() as $item)
           @php
               $photo = explode(',',$item->model->photo);
               
           @endphp
            <li>
                <div class="cart-item-desc">
                    <a href="#" class="image">
                        <img src="{{ asset('storage/uploads/products/'.$photo[0]) }}" class="cart-thumb" alt="{{ $item->name }}">
                    </a>
                    <div>
                        <a href="
                        {{ route('product.details', $item->model->slug) }}
                        ">{{ $item->name }}</a>
                        <p>{{ $item->qty }} x - <span class="price">{{ $item->price }}</span></p>
                    </div>
                </div>
                <span class="dropdown-product-remove" data-url="{{ route('cart.delete') }}" data-id="{{ $item->rowId }}" id="deleteCart" ><i class="icofont-bin"></i></span>
            </li>
           @endforeach
            
            
        </ul>
        <div class="cart-pricing my-4">
            <ul>
                <li>
                    <span>Sub Total:</span>
                    <span>{{CurrencySign().$cart->subtotal() }}</span>
                </li>
                @if (session()->has('coupon'))
                    <li>
                        <span>Saved:</span>
                        <span>{{ currency_converter(session('coupon')['value']) }}</span>
                    </li>
                @endif
                <li>
                    <span>Total:</span>
                    <span>
                        @if (session()->has('coupon'))
                                @php
                                    $totalpay = removeComma($cart->subtotal()) - session('coupon')['value'];
                                @endphp
                                    {{ currency_converter($totalpay) }}
                            @else
                                  {{ CurrencySign().$cart->subtotal() }}
                        @endif
                    </span>
                </li>
            </ul>
        </div>
        <div class="cart-box display-flex">
            <a href="{{ route('shop.cart') }}" class="btn  btn-sm  btn-primary">Cart</a>
            <a href="{{ route('shop.billing.checkout') }}" class="btn  btn-sm btn-warning">Checkout</a>
        </div>
    </div>
</div>
