@extends('layouts.app')

@section('frontcontent')

{{-- @include('inc.bread-front') --}}
<style>
.carousel-indicators li {
height: 50px !important;
border-radius: 10px !important;
width: 10px;
background-color: rgb(88, 87, 95);
}
</style>
<!-- Single Product Details Area -->
<section class="single_product_details_area section_padding_100 pt-2">
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 bg-white rounded-full shadow-lg">
                <div class="card-body d-flex flex-grow-1">
                    <div class="row">
                        <div class="col-md-5">
                                <div class="card-body p-0">
                                    <div class="single_product_thumb">
                                        <div id="product_details_slider" class="carousel slide" data-ride="carousel">
                                            <!-- Carousel Inner -->
                                            @php
                                            $photos = explode(',',$product->photo);
                                            @endphp
                                            <div class="carousel-inner">
                                                @foreach ($photos as $key=>$photo)
                                                
                                                <div class="carousel-item {{ (($key==0)?'active':'') }}">
                                                    <a class="gallery_img" href="{{ asset('storage/uploads/products/'.$photo)}}" title="{{ $product->title }}">
                                                        <img class="d-block w-100" src="{{ asset(asset('storage/uploads/products/'.$photo)) }}" alt="{{ $product->title }}">
                                                    </a>
                                                    <!-- Product Badge -->
                                                    <div class="product_badge">
                                                        <span class="badge-new">{{ $product->condition }}</span>
                                                    </div>
                                                </div>
                                                
                                                @endforeach
                
                                            </div>
                
                                            <!-- Carosel Indicators -->
                                            <ol class="carousel-indicators">
                                                @foreach ($photos as $key=>$photo)
                                                
                                                    <li class="{{ (($key==0)?'active':'') }}" data-target="#product_details_slider" data-slide-to="{{ $key }}" style="background-image: url('{{ asset('storage/uploads/products/'.$photo) }}');">
                                                    </li>
                                                @endforeach
                                                
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            <hr>
                            <a class="share_with_friend" href="#"><i class="fa fa-share" aria-hidden="true"></i> SHARE WITH FRIEND</a>
                        </div>
                        <div class="col-lg col-lg-7">
                            <h2 class="text-sm">
                                {{ $product->title }}
                            </h2>
                            <span>Brand: {{ ucfirst($product->brand->title) }}</span>
                            <hr>
                            <div class="d-inline-flex flex-grow-1 mt-0">
                                <h4 class="price" id="price">{{ currency_converter($product->sales_price) }}</h4> &nbsp;
                                <span class="text-danger text-decoration-line-through">{{ $product->product_discount == 0 ? ""  : currency_converter($product->price) }}</span>  &nbsp;
                                
                            </div>
                            <span class="badge badge-pill badge-danger">-{{ N2P($product->product_discount) }}</span> <br/>
                            <span class="text-muted">{{ $product->stock > 0 ? "In Stock" : "Out of Stock" }}</span>
                                <div class="single_product_ratings mb-2">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <span class="text-muted">(8 Reviews)</span>
                                </div>
                            <hr>
                            {{-- Next time work on add to cart  --}}
                            {{-- <form action="{{ route('cart.store') }}" method="post" id="addToCartFormClick">
                            @csrf
                            @method("POST") --}}
                                {{-- color option --}}
                                @if ($product->color != '')
                                    <h6 class="widget-title mb-0">Color</h6>
                                    <div class="widget-desc d-flex">
                                        @php
                                            $colors = explode(',',$product->color);
                                        @endphp
                                        @foreach ($colors as $key=>$color)
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="product_color{{ $key }}" data-id="{{ $key }}" name="product_color" class="custom-control-input product_color" value="{{ $color }}">
                                                <label data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $color }}" class="custom-control-label {{ strtolower($color) }}" for="product_color{{ $key }}"></label>
                                            </div>
                                        @endforeach
                                
                                        
                                    </div>
                                    @endif
                                
                                    {{-- size option --}}
                                    @if (count($productAttr) > 0)
                                   
                                    <div class="widget-desc d-flex">
                                        <div class="form-group">
                                            <label for="product_size">Size</label> <br>
                                            <select name="product_size" id="product_size" class="form-control">
                                                <option value="">--Select size--</option>
                                                @foreach ($productAttr as $key=>$size)
                                                 
                                                    <option value="{{ $size->size }},{{ $size->offer_price }},{{ $size->stock }}">{{ $size->size }} ({{  $size->stock  }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                    
                                    </div>
                                    @endif
                                    
                                    <div class="form-group mt-4">
                                    <div class="row">
                                        <div class="col-md-12 d-flex">
                                             <input type="number" class="qty-text form-control mt-1" name="product_quantity" id="product_quantity" step="1" min="1" max="{{ $product->stock }}" name="quantity" value="1">
                                            <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                                            {{-- <input type="hidden" name="product_stock" id="product_stock" value="{{ $product->stock }}"> --}}
                                            <input type="hidden" name="attr_sales_price" id="attr_sales_price" class="form-control">
                                            <input type="hidden" name="attr_stock" id="attr_stock" class="form-control">
                                            <input type="hidden" name="attr_size" id="attr_size" class="form-control">
                                            <input type="hidden" name="attr_color" id="attr_color" class="form-control">

                                               
                                                <button href="#"  
                                                    data-product-id="{{ $product->id }}"
                                                    class="btn btn-block btn-primary mt-1 mt-md-0 ml-1 ml-md-3 add_to_cartd cart-submit"
                                                    id="add_to_cart-d"
                                                    data-product_stock="{{ $product->stock }}"
                                                    data-url-cart="{{ route('cart.store') }}"
                                                    >
                                                    <i class="fa fa-cart-arrow-down"></i> Add to cart
                                                </button>
                                        </div>
                                        <div class="col-md-4 cart">
                                                <!-- Wishlist -->
                                        
                                            {{-- <div class="others_info_area mb-3 d-flex flex-wrap">
                                                <a href="javascript:void(0)"
                                                class="add_to_wishlist"
                                                data-product-id="{{ $product->id }}"
                                                data-url={{ route('wishlist.store') }}
                                                id="add_to_wishlist-{{ $product->id }}"><i class="icofont-heart text-pink"></i> WISHLIST</a>
                                                
                                                <a class="add_to_compare" href="compare.html"><i class="fa fa-th" aria-hidden="true"></i> COMPARE</a> --}}
                                                
                                            {{-- </div> --}}
                    
                                        </div>
                                    </div>
                                    
                                    </div>
                            {{-- </form> --}}
                            <hr>
                            <!-- Overview -->
                            <div class="short_overview mb-4">
                                <h6 class="text-bold">Summary</h6>
                                <p>{!! removeTag($product->summary) !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- others --}}
        <div class="card bg-white shadow-lg mt-5">
        <div class="card-body">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="product_details_tab section_padding_100_0 clearfix">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs" role="tablist" id="product-details-tab">
                        <li class="nav-item">
                            <a href="#description" class="nav-link active" data-toggle="tab" role="tab">Description</a>
                        </li>
                        <li class="nav-item">
                            <a href="#reviews" class="nav-link" data-toggle="tab" role="tab">Reviews <span class="text-muted">({{ $count_review }})</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="#addi-info" class="nav-link" data-toggle="tab" role="tab">Additional Information</a>
                        </li>
                        <li class="nav-item">
                            <a href="#refund" class="nav-link" data-toggle="tab" role="tab">Return &amp; Cancellation</a>
                        </li>
                    </ul>
                    <!-- Tab Content -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade " id="description">
                            <div class="description_area">
                                <h5>Description</h5>
                                {!! removeTag($product->description) !!}
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane fade show active" id="reviews">
                            <div class="reviews_area">
                                <ul>
                                    <li id="showReviews">
                                       
                                           {{-- //reviews  --}}
                                        
                                    </li>
                                </ul>
                            </div>

                            <div class="submit_a_review_area mt-50">
                                <h4>Submit A Review</h4>
                                @if (!Auth::Check())
                                   You need to login to submit review <a href="{{ route('user.user.login') }}" class="btn btn-outline-success">Click here to login</a>
                                @else
                                <form action="{{ route('submit.review') }}" method="post" id="submitReviewForm">
                                    @csrf
                                    @method("POST")
                                    <div class="form-group">
                                        <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                                        <span>Your Ratings</span>
                                        <div class="stars">
                                            <input type="radio" name="rate" class="star-1" id="star-1" value="1">
                                            <label class="star-1" for="star-1">1</label>
                                            <input type="radio" name="rate" class="star-2" id="star-2" value="2">
                                            <label class="star-2" for="star-2">2</label>
                                            <input type="radio" name="rate" class="star-3" id="star-3" value="3">
                                            <label class="star-3" for="star-3">3</label>
                                            <input type="radio" name="rate" class="star-4" id="star-4" value="4">
                                            <label class="star-4" for="star-4">4</label>
                                            <input type="radio" name="rate" class="star-5" id="star-5" value="5">
                                            <label class="star-5" for="star-5">5</label>
                                            <span></span>
                                        </div>
                                        <span class="text-error text-danger star_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="nickname">Nickname</label>
                                        <input type="text" class="form-control" name="nickname" id="nickname" placeholder="Eg: Micky" value="{{ (auth()->check()? auth()->user()->username: "") }}">
                                    </div>
                                    <div class="form-group">
                                        @php
                                            $reasons = ['value', 'quality','design','price','others']
                                        @endphp
                                        <label for="review_reason">Reason for your rating</label>
                                        <select class="form-control small right py-0 w-100" name="review_reason" id="review_reason">
                                            <option value="">--Chose reason--</option>
                                            @foreach ($reasons as $reason)
                                              <option value="{{ $reason }}" {{ old('review_reason') == $reason ? ' selected': '' }}>{{ Str::ucfirst($reason) }}</option>
                                            @endforeach
                                          
                                        </select>
                                        <span class="text-error text-danger review_reason_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="comments">Comments</label>
                                        <textarea class="form-control" id="comments" name="comments" rows="5" max-length="500"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit Review</button>
                                </form>
                                @endif
                               
                            </div>
                        
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="addi-info">
                            <div class="additional_info_area">
                                @if ($pinfo)
                                    {!! removeTag($pinfo->additionalInformation) !!}
                                @else
                                    <h3 class="text-center text-muted">No Additonal Information</h3>
                                @endif
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="refund">
                            <div class="refund_area">
                                @if ($pinfo)
                                {!! removeTag($pinfo->return_policy) !!}
                                @else
                                    <h3 class="text-center text-muted">No Additonal Information</h3>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- //you may like  --}}
<hr>
<!-- Related Products Area -->
<section class="you_may_like_area section_padding_0_100 clearfix">
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="text-bold new_arrivals p-2 mb-3 w-75 bg-info h-75">
                <h5>You May Also Like</h5>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="you_make_like_slider owl-carousel">
                @foreach ($likeproducts as $product)
                @php
                    $photo = explode(',',$product->photo);
                @endphp
                        <div class="single-product-area">
                        <div class="product-grid">
                            <div class="product-image">
                                <a href="{{ route('product.details', $product->slug) }}" title="{{ $product->title }}">
                                    @if (count($photo)>1)
                                        <img decoding="async" class="pic-1" src="{{ asset('storage/uploads/products/'.$photo[0] ) }}">
                                        <img decoding="async" class="pic-2" src="{{ asset('storage/uploads/products/'.$photo[1] )}}">
                                    @else
                                        <img decoding="async" class="pic-1" src="{{ asset('storage/uploads/products/'.$photo[0] ) }}">
                                        
                                    @endif
                                    
                                </a>
                                <ul class="social">
                                    {{-- quick view --}}
                                    <li><a 
                                        style="cursor:pointer"
                                        data-tip="Quick View"
                                        id="quickViewProduct" 
                                        data-url="{{ route('product.quickview.detail') }}" 
                                        data-id="{{ $product->unique_key }}"
                                        ><i class="fa fa-search"></i></a>
                                    </li>
                                    {{-- add to wishlist  --}}
                                    <li>
                                        <a
                                        style="cursor:pointer"  
                                        data-tip="Add to Wishlist"
                                        href="javascript:void(0)"
                                        class="add_to_wishlist"
                                        data-product-id="{{ $product->id }}"
                                        data-url={{ route('wishlist.store') }}
                                        id="add_to_wishlist-{{ $product->id }}" 
                                        ><i class="fa fa-shopping-bag"></i></a>
                                    </li>
                                    {{-- add to cart --}}
                                    {{-- <li>
                                        <a 
                                        style="cursor:pointer"
                                        data-tip="Add to Cart"
                                        data-quantity="1"
                                        data-product-id="{{ $product->id }}"
                                        class="add_to_cart"
                                        id="add_to_cart{{ $product->id }}"
                                        data-stock="{{ $product->stock }}"
                                        >
                                            <i class="fa fa-shopping-cart"></i></a>
                                    </li> --}}
                                </ul>
                                <span class="product-new-label bg-primary">{{ $product->condition }}</span>
                                <span class="product-discount-label" style="background:orangered">{{ N2P($product->product_discount) }}</span>
                            </div>
                            <ul class="rating">
                                <li class="fa fa-star"></li>
                                <li class="fa fa-star"></li>
                                <li class="fa fa-star"></li>
                                <li class="fa fa-star"></li>
                                <li class="fa fa-star disable"></li>
                            </ul>
                            <div class="product-content">
                                <h3 class="title"><a href="{{ route('product.details', $product->slug) }}">{{ $product->title  }}</a></h3>
                                <div class="price text-success">{{ currency_converter($product->sales_price) }}
                                    <span class="text-danger text-strike">{{ ($product->product_discount == 0.00) ? " ": currency_converter($product->price) }}</span>
                                </div>
                                @if (\App\Models\ProductAttribute::where('product_id', $product->id)->first())
                                <a href="{{ route('product.details', $product->slug) }}"
                                    title="You are seeing this because this product has attributes"
                                    class="btn btn-info text-light">Full details</a>
                                    
                                @else
                                <a style="cursor:pointer"
                                    data-quantity="1"
                                    data-product-id="{{ $product->id }}"
                                    class="btn btn-info text-light  add_to_cart"
                                    id="add_to_cart{{ $product->id }}"
                                    data-stock="{{ $product->stock }}"
                                    data-url-cart="{{route('cart.store') }}"
                                    ><i class="fa fa-shopping-cart"></i> Add To Cart</a>
                                @endif
                            </div>
                        </div>
                        </div>
                    @endforeach

            </div>
        </div>
    </div>
</div>
</section>
</div>
</div>
<!-- Related Products Area -->
        </div>
        <div class="col-lg-4">
            <div class="card bg-white shadow-lg h-100">
            <div class="card-body">
                this goes here
            </div>
            </div>
        </div>
    </div>
    
</div>

</section>



@include('inc.quickviewModal')

@endsection


@section('frontscripts')
<script src="{{ asset('shopjs/cart.js') }}"></script>

<script>
        $(function(){
                $('body').on('click','#quickViewProduct', function(e){
                        e.preventDefault();
                        let url = $(this).data('url');
                        let uniquekey = $(this).data('id');
                        $.get(url, {uniquekey:uniquekey}, function(data){
                                $('#quickview').modal('show');
                                $('#showQuickDetails').html(data);
                        });
                });


                $('#product_size').on('change', function(e){
                            e.preventDefault();
                            let value = $(this).val();
                            let price = value.split(',');
                            let size = price[0];
                            let attr_price = price[1];
                            let stock = price[2]
                            $('#attr_sales_price').val(attr_price)
                            $('#attr_size').val(size)
                            $('#attr_stock').val(stock)

                            

                            getFormattedCurrency(attr_price)
                         
                  });

                  function getFormattedCurrency(attr_price){
                        let url = "{{ route('get.formatted.currency') }}";
                        $.get(url, {attr_price:attr_price}, function(data){
                            $('#price').html(data);
                        })
                  }
                  //when the color is clicked pass the value to attr color
               
                  $('.product_color').on('change', function(e){
                    e.preventDefault();
                    let id = $(this).data('id');
                    let color = $('#product_color'+id).val();
                    $('#attr_color').val(color);
                });

            $('body').on('click', '.cart-submit', function(e){
                e.preventDefault();
                let product_id = $(this).data('product-id');
                let product_quantity = $('#product_quantity').val();
                let path = $(this).data('url-cart');
                
                let attr_sales_price = $('#attr_sales_price').val(); // attribute sales price
                let color = $('#attr_color').val() // attribute color
                let attribute_size = $('#attr_size').val(); // attribute size
               
                //if the product has attribute, use the product attribute stock else use the default product stock
                if($('#attr_stock').val() != ""){
                    var product_stock = $('#attr_stock').val(); // attribute stock
                }else{
                    var product_stock = $(this).data('product_stock'); // product stock
                }

                $.ajax({
                    url:path,
                    method:'POST',
                    dataType:'JSON',
                    data: {
                        product_id:product_id,
                        product_quantity:product_quantity,
                        attr_sales_price:attr_sales_price,
                        product_stock:product_stock,
                        color:color,
                        attribute_size:attribute_size,
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
            
                    },
                    beforeSend:function(){
                        $('#add_to_cart-d').html('<i class="fa fa-spinner fa-spin"></i> loading...');
                    },
                    complete:function(){
                        $('#add_to_cart-d').html('<i class="fa fa-cart-arrow-down"></i> Add to Cart');
                    },
                    success:function(data){
                        if(data.status==true){
                            Swal.fire(
                                'Success',
                                data.message,
                                'success',
                            )
                            $('#cart_quantity').html(data.cart_count);
                            $('#cart_header').html(data.cart_header);
                        }
                        else if(data.status==false){

                            Swal.fire(
                                'Error',
                                data.message,
                                'error'
                            )
                            
                        }
                    },
                    error:function(err){
                        console.log(err);
                    }
                });
         })


         //submit review
         $('#submitReviewForm').on('submit', function(e){
             e.preventDefault();
             let form = this;

             $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:new FormData(form),
                dataType:'JSON',
                contentType:false,
                processData:false,
                beforeSend:function(){
                    $(form).find('span.text-error').text('');
                },
                success:function(data){
                    if(data.code == 0){
                        $.each(data.error, function(prefix, val){
                            $(form).find('span.'+prefix+'_error').text(val[0]);
                        })
                    }else{
                        $('#submitReviewForm')[0].reset();
                        Swal.fire(
                            'Success',
                            data.msg,
                            'success'
                        );
                        fetchReviews();
                    }
                }
             });
         })
         //fetch review
         fetchReviews();

         function fetchReviews(){
            let url = "{{ route('fetch.review') }}";
            let data = "getReviews";
            let _token = "{{ csrf_token() }}";
            $.get(url, {data:data, _token:_token}, function(response){
                $('#showReviews').html(response);
            })
         }
     
   
   })
</script>
@endsection