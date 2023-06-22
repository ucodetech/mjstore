@extends('layouts.app')

@section('frontcontent')

    @include('inc.bread-front')

       <!-- Single Product Details Area -->
       <section class="single_product_details_area section_padding_100">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="single_product_thumb">
                        <div id="product_details_slider" class="carousel slide" data-ride="carousel">
                            <!-- Carousel Inner -->
                            @php
                            $photos = explode(',',$product->photo);
                                $x = 0;
                            @endphp
                            <div class="carousel-inner">
                               @foreach ($photos as $key=>$photo)
                                {{-- @php
                                $active = '';
                                if($x == 0){
                                    $active = 'active';
                                }
                                @endphp --}}
                                <div class="carousel-item {{ (($key==0)?'active':'') }}">
                                    <a class="gallery_img" href="{{ asset('storage/uploads/products/'.$photo)}}" title="{{ $product->title }}">
                                        <img class="d-block w-100" src="{{ asset(asset('storage/uploads/products/'.$photo)) }}" alt="{{ $product->title }}">
                                    </a>
                                    <!-- Product Badge -->
                                    <div class="product_badge">
                                        <span class="badge-new">{{ $product->condition }}</span>
                                    </div>
                                </div>
                                {{-- @php
                                    $x++;
                                @endphp --}}
                                @endforeach

                            </div>

                            <!-- Carosel Indicators -->
                            <ol class="carousel-indicators">
                                {{-- @php
                                    $x =0;
                                @endphp --}}
                                @foreach ($photos as $key=>$photo)
                                {{-- @php
                                    
                                    $current = '';
                                    if($x==0){
                                        $current = 'active';
                                    }
                                @endphp --}}
                                    <li class="{{ (($key==0)?'active':'') }}" data-target="#product_details_slider" data-slide-to="{{ $key }}" style="background-image: url('{{ asset('storage/uploads/products/'.$photo) }}');">
                                    </li>
                                @endforeach
                                
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Single Product Description -->
                <div class="col-12 col-lg-6">
                    <div class="single_product_desc">
                        <h4 class="title mb-2">{{ $product->title }}</h4>
                        <div class="single_product_ratings mb-2">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <span class="text-muted">(8 Reviews)</span>
                        </div>
                        <h4 class="price mb-4">{{ Naira($product->sales_price) }} <span class="text-danger">{{ Naira($product->price) }}</span></h4>

                        <!-- Overview -->
                        <div class="short_overview mb-4">
                            <h6>Overview</h6>
                            <p>{{ removeTag($product->summary) }}</p>
                        </div>

                        <!-- Color Option -->
                        <div class="widget p-0 color mb-3">
                            @if ($product->color != '')
                            <h6 class="widget-title">Color</h6>
                            <div class="widget-desc d-flex">
                                @php
                                    $colors = explode(',',$product->color);
                                @endphp
                                @foreach ($colors as $key=>$color)
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="customRadio{{ $key }}" name="customRadio" class="custom-control-input">
                                        <label class="custom-control-label {{ strtolower($color) }}" for="customRadio{{ $key }}"></label>
                                    </div>
                                @endforeach
                                
                               
                               
                            </div>
                            @endif
                        </div>

                        <!-- Size Option -->
                        <div class="widget p-0 size mb-3">
                            @if ($product->size != '')
                            <h6 class="widget-title">Size</h6>
                            <div class="widget-desc">
                              
                                <ul>
                                    @php
                                        $sizes = explode(',',$product->size);
                                    @endphp
                                    @foreach ($sizes as $key=>$size)
                                        <li><a href="#">{{ $size }}</a></li>
                                    @endforeach
                                   
                                    
                                </ul>
                               
                                
                            </div>
                            @endif
                        </div>

                        <!-- Add to Cart Form -->
                        <form class="cart clearfix my-5 d-flex flex-wrap align-items-center" method="post">
                            <div class="quantity">
                                <input type="number" class="qty-text form-control" id="qty2" step="1" min="1" max="12" name="quantity" value="1">
                            </div>
                            <button type="submit" name="addtocart" value="5" class="btn btn-primary mt-1 mt-md-0 ml-1 ml-md-3">Add to cart</button>
                        </form>

                        <!-- Others Info -->
                        <div class="others_info_area mb-3 d-flex flex-wrap">
                            <a class="add_to_wishlist" href="wishlist.html"><i class="fa fa-heart" aria-hidden="true"></i> WISHLIST</a>
                            <a class="add_to_compare" href="compare.html"><i class="fa fa-th" aria-hidden="true"></i> COMPARE</a>
                            <a class="share_with_friend" href="#"><i class="fa fa-share" aria-hidden="true"></i> SHARE WITH FRIEND</a>
                        </div>

                        <!-- Size Guide -->
                        <div class="sizeguide">
                            <h6>Size Guide</h6>
                            <div class="size_guide_thumb d-flex">
                                <a class="size_guide_img" href="{{ asset('assets_front/img/bg-img/size-1.png')}}" style="background-image: url('{{ asset('assets_front/img/bg-img/size-1.png')}} ');">
                                </a>
                                <a class="size_guide_img" href="{{ asset('assets_front/img/bg-img/size-2.png')}}" style="background-image: url('{{ asset('assets_front/img/bg-img/size-2.png')}} ');">
                                </a>
                                <a class="size_guide_img" href="{{ asset('assets_front/img/bg-img/size-3.png')}}" style="background-image: url('{{ asset('assets_front/img/bg-img/size-3.png')}} ');">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
    </section>
    <!-- Single Product Details Area End -->

    <!-- Related Products Area -->
    <section class="you_may_like_area section_padding_0_100 clearfix">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_heading new_arrivals">
                        <h5>You May Also Like</h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="you_make_like_slider owl-carousel">
                        @foreach ($likeproducts as $product)
                             <div class="single-product-area">
                                 <div class="product_image">
                                     <!-- Product Image -->
                                     @php
                                     $photo = explode(',',$product->photo);
                                     
                                     @endphp
                                   
                                     @if(count($photo)>1)
                                         <img class="normal_img" src="{{ asset('storage/uploads/products/'.$photo[0]) }}" alt="{{ $product->title }}">
                                         <img class="hover_img" src="{{ asset('storage/uploads/products/'.$photo[1]) }}" alt="{{ $product->title }}">
                                     @else
                                         <img class="normal_img" src="{{ asset('storage/uploads/products/'.$photo[0]) }}" alt="{{ $product->title }}">
                                     @endif
                                    
 
                                     <!-- Product Badge -->
                                     <div class="product_badge">
                                         <span>{{ $product->condition }}</span>
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
                                         <a href="#"><i class="icofont-shopping-cart"></i> Add to Cart</a>
                                     </div>
 
                                     <!-- Quick View -->
                                     <div class="product_quick_view">
                                         <a href="#" id="quickViewProduct" data-url="{{ route('product.quickview.detail') }}" data-id="{{ $product->unique_key }}"><i
                                                 class="icofont-eye-alt"></i> Quick View</a>
                                     </div>
 
 
                                     <p class="brand_name">{{ $product->brand->title }}</p>
                                     <a href="{{ route('product.details', $product->slug) }}">{{ $product->title }}</a>
                                     <h6 class="product-price">{{ Naira($product->sales_price) }} <span class="text-strike text-danger">{{ Naira($product->price) }}</span></h6>
                                 </div>
                             </div>
                         @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Related Products Area -->

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
                        })
                })
        </script>
@endsection