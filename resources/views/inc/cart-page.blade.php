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
            <div class="card bg-white shadow border-0">
                <div class="card-header text-uppercase justify-content border-0">
                    Cart ({{ count($cart->content()) }})
                </div>
                <div class="card-body">
                    {{-- @include('inc.cart-page') --}}
                    @if (count($cart->content()) > 0)

                        @foreach ($cart->content() as $item)
                            @php
                                $photo = explode(',', $item->model->photo);
                                $total = $item->price * $item->qty;
                            @endphp
                            <div class="card border-o shadow-sm bg-white">
                                <div class="card-body">
                                    <div class="media m-media d-flex flex-grow-1">

                                        <a class="image">
                                            <img src="{{ asset('storage/uploads/products/' . $photo[0]) }}"
                                                alt="{{ $item->name }}" class="img-thumbnail" width="60">
                                        </a>

                                        <div class="media-body pl-2">
                                            <a href="{{ route('product.details', $item->model->slug) }}"
                                                class="text-center">
                                                {{ wrap50($item->name) }}
                                            </a><br>
                                            <span class="text-muted">
                                                {{ $item->model->stock < 10 ? 'Few units left' : 'In stock' }}
                                            </span>
                                            <div class="mt-3">
                                                <button class="btn btn-sm btn-outline-primary removeCart"
                                                    data-url="{{ route('cart.delete') }}" id="deleteCart"
                                                    data-id="{{ $item->rowId }}"><i class="fa fa-trash-alt"></i>
                                                    Remove</button>
                                            </div>
                                        </div>
                                        <div class="price_btns">
                                            <h6 class="price">{{ currency_converter($item->price) }} <br><span
                                                    class="text-danger pt-5"><strike>{{ currency_converter($item->model->price) }}</strike></span>
                                                <small class="text-italic" style="color: orangered">
                                                    <i>
                                                        -{{ N2P($item->model->product_discount) }}
                                                    </i>
                                                </small>
                                            </h6>

                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-number p-0 DecQty"
                                                        data-type="minus" data-id="{{ $item->rowId }}"
                                                        id="qty-input{{ $item->rowId }}"
                                                        data-value="{{ $item->qty }}">

                                                        <span class="fa fa-minus-circle fa-2x"></span>
                                                    </button>
                                                </span>
                                                <span class="w-auto ml-1 mr-1 p-1 input-number"
                                                    id="quantity_show{{ $item->rowId }}">{{ $item->qty }}
                                                </span>
                                                    
                                                <input type="hidden" name="r_quantity"
                                                    id="r_quantity{{ $item->rowId }}" value="{{ $item->qty }}">

                                                <span class="input-group-btn">
                                                    <button type="button"
                                                        class="btn btn-outline-success btn-number p-0 IncQty"
                                                        data-id="{{ $item->rowId }}"
                                                        id="qty-input{{ $item->rowId }}" data-type="plus"
                                                        data-value="{{ $item->qty }}">
                                                        <span class="fa fa-plus-circle fa-2x"></span>

                                                    </button>
                                                    @php
                                                        $attribute_stock = \App\Models\ProductAttribute::where('product_id', $item->model->id)->first();

                                                        $stock = ($attribute_stock !=null ? $attribute_stock->stock :  $item->model->stock);
                                                    @endphp
                                                    <input type="hidden" data-id="{{ $item->rowId }}"
                                                        data-product-quantity="{{ $stock }}"
                                                        id="update-cart-{{ $item->rowId }}" value="{{ $stock }}">
                                                </span>

                                            </div>


                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer d-flex flex-grow-1 justify-content-between">
                                    <div class="text-muted p-1">

                                        @php
                                            $color = $item->options->has('color') ? $item->options->color : "";
                                            $size = $item->options->has('size') ? $item->options->size : "";
                                        @endphp
                                        @if ($color)
                                            <span class="d-inline-flex text-sm">
                                                <span class="colortext">Item Color:</span>
                                                <span class="rounded-circle colorid"
                                                    style="background-color:{{ $color }}">
                                                </span>

                                            </span>
                                        @endif
                                        @if ($size)
                                            <span class="d-inline-flex text-sm">
                                                <span class="text-bold">Item Size:</span>
                                                <span class="text-bold text-sm text-dark">
                                                    {{ $size }}
                                                </span>
                                            </span>
                                        @endif


                                    </div>
                                    <div class="text-right text-muted p-2">
                                        @php
                                            $tot = $item->qty * $item->price;
                                        @endphp
                                        Total: {{ $item->qty }} x {{ currency_converter($item->price) }} =
                                        {{ currency_converter($tot) }}
                                    </div>
                                </div>
                            </div>
                            <hr class="invisible">
                        @endforeach
                    @else
                        <h4 class="text-muted text-center">No item in cart yet!</h4>
                    @endif
                </div>

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
                                {{ CurrencySign() . $cart->subtotal() }}
                            </td>
                        </tr>
                        <tr>
                            @if (session()->has('coupon'))
                                <td>Saved:</td>
                                <td>{{ currency_converter(session('coupon')['value']) }}</td>
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
                                <td> {{ currency_converter($totalpay) }}</td>
                            @else
                                <td> {{ CurrencySign().$cart->subtotal() }}</td>
                            @endif

                        </tr>
                    </table>
                    <hr>
                    <a href="{{ route('shop.billing.checkout') }}" class="btn btn-info btn-block">Checkout
                        ({{ session()->has('coupon') ? currency_converter($totalpay) : CurrencySign().$cart->subtotal() }})</a>
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
                                <input type="text" class="form-control" name="coupon_code" id="coupon_code"
                                    placeholder="Enter Your Coupon Code">
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
