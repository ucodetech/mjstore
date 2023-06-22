@extends('layouts.app')
@section('frontcontent')
@include('inc.bread-cat')
      
<section class="shop_grid_area section_padding_100">
    <div class="container">
        <div class="row">
            <div class="col-12">
             
                <!-- Shop Top Sidebar -->
                <div class="shop_top_sidebar_area d-flex flex-wrap align-items-center justify-content-between">
                    <div class="view_area d-flex">
                        <div class="grid_view">
                            <a href="" data-toggle="tooltip" data-placement="top" title="Grid View"><i class="icofont-layout"></i></a>
                        </div>
                        <div class="list_view ml-3">
                            <a href="{{ route('shop.list') }}" data-toggle="tooltip" data-placement="top" title="List View"><i class="icofont-listine-dots"></i></a>
                        </div>
                    </div>
                    @php
                            $sorts = [
                               'default'=>'Default',
                               'priceAsc'=>'Price - Low-High', 
                               'priceDsc'=>'Price - High-Low', 
                               'titleAsc'=>'Title - Ascending', 
                               'titleDsc'=>'Title - Descending', 
                               'discountAsc'=>'Discount - Low-High', 
                               'discountDsc'=>'Discount - High-Low',
                               
                            ];
                    @endphp
                    <select id="sortBy" class="small right">
                        @foreach ($sorts as $key=>$value)
                         <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                @if(count($products) > 0)
                <div class="shop_grid_product_area">
                    <div class="row justify-content-center">
                        
                        <!-- Single Product -->
                        @foreach ($products as $cat_pro)
                        <div class="col-9 col-sm-6 col-md-4 col-lg-3">
                            <div class="single-product-area mb-30">
                                <div class="product_image">
                                    <!-- Product Image -->
                                    @php
                                    $photo = explode(',',$cat_pro->photo);
                                    
                                    @endphp
                                  
                                    @if(count($photo)>1)
                                        <img class="normal_img" src="{{ asset('storage/uploads/products/'.$photo[0]) }}" alt="{{ $cat_pro->title }}">
                                        <img class="hover_img" src="{{ asset('storage/uploads/products/'.$photo[1]) }}" alt="{{ $cat_pro->title }}">
                                    @else
                                        <img class="normal_img" src="{{ asset('storage/uploads/products/'.$photo[0]) }}" alt="{{ $cat_pro->title }}">
                                    @endif
                                   

                                    <!-- Product Badge -->
                                    <div class="product_badge">
                                        <span>{{ $cat_pro->condition }}</span>
                                    </div>

                                    <!-- Wishlist -->
                                    <div class="product_wishlist">
                                        <a href="wishlist.html"><i class="icofont-heart"></i></a>
                                    </div>

                                    <!-- Compare -->
                                    <div class="product_compare">
                                        <a href="compare.html"><i class="icofont-exchange"></i></a>
                                    </div>
                                </div>

                                <!-- Product Description -->
                                <div class="product_description">
                                    <!-- Add to cart -->
                                    <div class="product_add_to_cart">
                                        <a href="#"  
                                        data-quantity="1"
                                        data-product-id="{{ $cat_pro->id }}"
                                        class="add_to_cart"
                                        id="add_to_cart{{ $cat_pro->id }}"
                                        data-stock="{{ $cat_pro->stock }}"
                                        
                                        ><i class="icofont-shopping-cart"></i> Add to Cart</a>
                                    </div>

                                    <!-- Quick View -->
                                    <div class="product_quick_view">
                                        <a href="#" id="quickViewProduct" data-url="{{ route('product.quickview.detail') }}" data-id="{{ $cat_pro->unique_key }}"><i
                                                class="icofont-eye-alt"></i> Quick View</a>
                                    </div>


                                    <p class="brand_name">{{ $cat_pro->brand->title }}</p>
                                    <a href="#">{{ $cat_pro->title }}</a>
                                    <h6 class="product-price">{{ Naira($cat_pro->sales_price) }} <span class="text-strike text-danger">{{ Naira($cat_pro->price) }}</span></h6>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
                <!-- Shop Pagination Area -->
                <div class="shop_pagination_area mt-30">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm justify-content-center">
                          
                            {{-- {{  $categories->links()  }} --}}
                            {!! $products->links('pagination::bootstrap-4') !!}
                        </ul>
                    </nav>
                </div>
                @else
                    <h2 class="text-center text-muted">{{ $categories->title }} has no products</h2>
                @endif
            </div>
        </div>
    </div>
</section>
       


    {{-- product quick view modal --}}
    @include('inc.quickviewModal'); 

@endsection

@section('frontscripts')

        <script>
                $(function(){
                        $('body').on('click','#quickViewProduct', function(e){
                                e.preventDefault();
                                let url = $(this).data('url');
                                let uniquekey = $(this).data('id');
                                $.get(url, {uniquekey:uniquekey}, function(data){
                                        $('#quickview').modal('show');
                                        $('#showQuickDetails').html(data);
                                })
                        })


                        $('#sortBy').on('change', function(e){
                            let sortBy = $(this).val();
                            let url1 = "{{ url(''.$route.'') }}/{{ $categories->slug }}?s="+sortBy;
                            let url2 = "{{ url(''.$route.'') }}/{{ $categories->slug }}";
                            window.location = sortBy=='default' ? url2:url1;
                            
                            
                        })






            $('body').on('click', '.add_to_cart', function(e){
                e.preventDefault();
                let product_id = $(this).data('product-id');
                let product_quantity = $(this).data('quantity');
                let product_quantity2 = $('#product_quantity'+product_id).val();
                let product_stock = $(this).data('stock');
                let product_stock2 = $(this).data('product_stock');
                let path = "../store-cart-item";
                let token = "{{ csrf_token() }}";

            
                $.ajax({
                    url:path,
                    method:'POST',
                    dataType:'JSON',
                    data: {
                        product_id:product_id,
                        product_quantity:product_quantity,
                        product_quantity2:  product_quantity2,
                        product_stock: product_stock,
                        product_stock2:product_stock2,
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
            
                    },
                    beforeSend:function(){
                        $('#add_to_cart'+product_id).html('<i class="fa fa-spinner fa-spin"></i> loading...');
                    },
                    complete:function(){
                        $('#add_to_cart'+product_id).html('Add to Cart');
                    },
                    success:function(data){
                        if(data.status=true){
                            Swal.fire(
                                'Success',
                                data.message,
                                'success',
                            )
                            $('#cart_quantity').html(data.cart_count);
                            $('#cart_header').html(data.cart_header);
                        }
                    },
                    error:function(err){
                        console.log(err);
                    }
                })
            })


        $('body').on('click', '#deleteCart', function(e){
            let cart_id = $(this).data('id');
            let path = "../delete-cart-item";
            $.ajax({
                url:path,
                method:'POST',
                dataType:'JSON',
                data: {
                    cart_id:cart_id,
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }

                },
            
                success:function(data){
                    if(data.status){
                        Swal.fire(
                            'Success',
                            data.message,
                            'success',
                        )
                        clearCouponSession();
                        $('#cart_quantity').html(data.cart_count);
                        $('#cart_header').html(data.cart_header);
                        $('#cart_page_render').html(data.cart_page_render);
                        
                    }
                },
                error:function(err){
                    console.log(err);
                }
            })
        })

        setInterval(() => {
            clearCouponSession();
        }, 1000);

        function clearCouponSession(){
            let url = '../clear-coupon-session';
            $.post(url, function(){
                return true;
            })
        }

        $('body').on('change', '.DecIncQty', function(e){
            e.preventDefault();
            let cart_id = $(this).data('id');
            let input_val = $(this).val();
            if(input_val < 1){
                alert('Cart quantity can not be less than 1');
                return false;
            }else{
                let newValue = input_val;
                let product_quantity = $("#update-cart-"+cart_id).data('product-quantity');
                updateCart(cart_id, product_quantity)
                
            }
        })

        //this function updates the cart 
        function updateCart(cart_id, productQuantityStock){
            // productQuantityStock this represents the stock quantity
            // product_cart_quantity this represents the current quantity coming from the input value each time u add or minus from cart
                let path = '../update-cart';
                let product_cart_quantity = $('#qty-input'+cart_id).val();
                $.ajax({
                    url:path,
                    method:'POST',
                    dataType:'JSON',
                    data:{
                        cart_id:cart_id,
                        productQuantityStock:productQuantityStock,
                        product_cart_quantity: product_cart_quantity,
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                    },
                    success:function(data){
                        console.log(data);
                        if(data.status == true){
                            $('#cart_quantity').html(data.cart_count);
                            $('#cart_header').html(data.cart_header);
                            $('#cart_page_render').html(data.cart_page_render); 
                            toastr.success(data.msg);   
                        }else{
                            toastr.error(data.msg);
                            $('#cart_quantity').html(data.cart_count);
                            $('#cart_header').html(data.cart_header);
                            $('#cart_page_render').html(data.cart_page_render);
                        }
                    },
                    error:function(err){
                        console.log(err);
                    }
                })
        }   

        //apply coupon
        $('#applyCouponForm').on('submit', function(e){
            e.preventDefault();
            let form = this;
            $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:new FormData(form),
                contentType:false,
                processData:false,
                dataType: 'json',
                beforeSend:function(){
                    $(form).find('span.text-error').text('');
                    $('#couponBtn').html('<i class="fa fa-spinner fa-spin"></i>Applying');
                },
                success:function(data){
                    console.log(data);
                    if(data.code == 0){
                        $.each(data.error, function(prefix, val){
                           $(form).find('span.'+prefix+'_error').text(val[0]);
                        })
                    }else if(data.code == 2){
                        toastr.error(data.error);
                    }else{
                        toastr.success(data.msg);
                        $('#cart_header').html(data.cart_header);
                        $('#cart_page_render').html(data.cart_page_render); 
                    }
                },
                complete:function(){
                    $('#couponBtn').html('Apply Coupon');

                }
            });
        })



})

        </script>
@endsection