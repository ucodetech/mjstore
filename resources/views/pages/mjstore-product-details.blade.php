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
                                        <h4 class="price">{{ currency_converter($product->sales_price) }}</h4> &nbsp;
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
                                   <form action="{{ route('cart.store') }}" method="post" id="addToCartFormClick">
                                    @csrf
                                    @method("POST")
                                        {{-- color option --}}
                                        @if ($product->color != '')
                                            <h6 class="widget-title mb-0">Color</h6>
                                            <div class="widget-desc d-flex">
                                                @php
                                                    $colors = explode(',',$product->color);
                                                @endphp
                                                @foreach ($colors as $key=>$color)
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="color{{ $key }}" data-product_color="{{ $color }}" name="product_color" class="custom-control-input">
                                                        <label class="custom-control-label {{ strtolower($color) }}" for="color{{ $key }}"></label>
                                                    </div>
                                                @endforeach
                                        
                                               
                                            </div>
                                            @endif
                                       
                                            {{-- size option --}}
                                            @if ($product->size != '')
                                            <h6 class="widget-title mt-1 mb-0">Size</h6>
                                            <div class="widget-desc d-flex">
                                                    @php
                                                        $sizes = explode(',',$product->size);
                                                    @endphp
                                                    @foreach ($sizes as $key=>$size)
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="size{{ $key }}" data-product_size="{{ $size }}" name="product_size" class="custom-control-input">
                                                            <label class="custom-control-label mr-2" for="size{{ $key }}">{{ $size }}</label>
                                                        </div>
                                                    @endforeach
                                            </div>
                                            @endif
                                            
                                           <div class="form-group mt-4">
                                            <div class="row">
                                                <div class="col-md-8 d-flex">
                                                     <input type="number" class="qty-text form-control mt-1" id="quantity" step="1" min="1" max="{{ $product->stock }}" name="quantity" value="1">
                                                    <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="product_stock" id="product_stock" value="{{ $product->stock }}">
                                                    <button type="submit" class="btn btn-block btn-primary mt-1 mt-md-0 ml-1 ml-md-3">
                                                        <i class="fa fa-cart-arrow-down"></i>Add to Cart</button>
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
                                   </form>
                                    <hr>
                                    <!-- Overview -->
                                    <div class="short_overview mb-4">
                                        <h6 class="text-bold">Summary</h6>
                                        <p>{{ removeTag($product->summary) }}</p>
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
                                <a href="#reviews" class="nav-link" data-toggle="tab" role="tab">Reviews <span class="text-muted">(3)</span></a>
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
                            <div role="tabpanel" class="tab-pane fade show active" id="description">
                                <div class="description_area">
                                    <h5>Description</h5>
                                    {{ removeTag(nl2br($product->description)) }}
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="reviews">
                                <div class="reviews_area">
                                    <ul>
                                        <li>
                                            <div class="single_user_review mb-15">
                                                <div class="review-rating">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <span>for Quality</span>
                                                </div>
                                                <div class="review-details">
                                                    <p>by <a href="#">Designing World</a> on <span>12 Sep 2019</span></p>
                                                </div>
                                            </div>
                                            <div class="single_user_review mb-15">
                                                <div class="review-rating">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <span>for Design</span>
                                                </div>
                                                <div class="review-details">
                                                    <p>by <a href="#">Designing World</a> on <span>12 Sep 2019</span></p>
                                                </div>
                                            </div>
                                            <div class="single_user_review">
                                                <div class="review-rating">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <span>for Value</span>
                                                </div>
                                                <div class="review-details">
                                                    <p>by <a href="#">Designing World</a> on <span>12 Sep 2019</span></p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="submit_a_review_area mt-50">
                                    <h4>Submit A Review</h4>
                                    <form action="#" method="post">
                                        <div class="form-group">
                                            <span>Your Ratings</span>
                                            <div class="stars">
                                                <input type="radio" name="star" class="star-1" id="star-1">
                                                <label class="star-1" for="star-1">1</label>
                                                <input type="radio" name="star" class="star-2" id="star-2">
                                                <label class="star-2" for="star-2">2</label>
                                                <input type="radio" name="star" class="star-3" id="star-3">
                                                <label class="star-3" for="star-3">3</label>
                                                <input type="radio" name="star" class="star-4" id="star-4">
                                                <label class="star-4" for="star-4">4</label>
                                                <input type="radio" name="star" class="star-5" id="star-5">
                                                <label class="star-5" for="star-5">5</label>
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Nickname</label>
                                            <input type="email" class="form-control" id="name" placeholder="Nazrul">
                                        </div>
                                        <div class="form-group">
                                            <label for="options">Reason for your rating</label>
                                            <select class="form-control small right py-0 w-100" id="options">
                                                <option>Quality</option>
                                                <option>Value</option>
                                                <option>Design</option>
                                                <option>Price</option>
                                                <option>Others</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="comments">Comments</label>
                                            <textarea class="form-control" id="comments" rows="5" data-max-length="150"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit Review</button>
                                    </form>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="addi-info">
                                <div class="additional_info_area">
                                    <h5>Additional Info</h5>
                                    <p>What should I do if I receive a damaged parcel?
                                        <br> <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit impedit similique qui, itaque delectus labore.</span></p>
                                    <p>I have received my order but the wrong item was delivered to me.
                                        <br> <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis quam voluptatum beatae harum tempore, ab?</span></p>
                                    <p>Product Receipt and Acceptance Confirmation Process
                                        <br> <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum ducimus, temporibus soluta impedit minus rerum?</span></p>
                                    <p class="mb-0">How do I cancel my order?
                                        <br> <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nostrum eius eum, minima!</span></p>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="refund">
                                <div class="refund_area">
                                    <h6>Return Policy</h6>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa quidem, eos eius laboriosam voluptates totam mollitia repellat rem voluptate obcaecati quas fuga similique impedit cupiditate vitae repudiandae. Rem, tenetur placeat!</p>

                                    <h6>Return Criteria</h6>
                                    <ul class="mb-30 ml-30">
                                        <li><i class="icofont-check"></i> Package broken</li>
                                        <li><i class="icofont-check"></i> Physical damage in the product</li>
                                        <li><i class="icofont-check"></i> Software/hardware problem</li>
                                        <li><i class="icofont-check"></i> Accessories missing or damaged etc.</li>
                                    </ul>

                                    <h6>Q. What should I do if I receive a damaged parcel?</h6>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit impedit similique qui, itaque delectus labore.</p>

                                    <h6>Q. I have received my order but the wrong item was delivered to me.</h6>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis quam voluptatum beatae harum tempore, ab?</p>

                                    <h6>Q. Product Receipt and Acceptance Confirmation Process</h6>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum ducimus, temporibus soluta impedit minus rerum?</p>

                                    <h6>Q. How do I cancel my order?</h6>
                                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nostrum eius eum, minima!</p>
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
                                        <a style="cursor:pointer"
                                        data-quantity="1"
                                        data-product-id="{{ $product->id }}"
                                        class="btn btn-info text-light  add_to_cart"
                                        id="add_to_cart{{ $product->id }}"
                                        data-stock="{{ $product->stock }}"
                                        data-url-cart="{{route('cart.store') }}"
                                        ><i class="fa fa-shopping-cart"></i> Add To Cart</a>
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
                                })
                        });





          

                })
        </script>
@endsection