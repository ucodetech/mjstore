@extends('layouts.app')
@section('frontcontent')
@include('inc.bread-front')


<section class="shop_grid_area section_padding_100">
    <div class="container">
        <div class="row">
            @include('inc.product-sidebar')

            <div class="col-12 col-sm-7 col-md-8 col-lg-9">
                <!-- Shop Top Sidebar -->
                <div class="shop_top_sidebar_area d-flex flex-wrap align-items-center justify-content-between">
                    <div class="view_area d-flex">
                        <div class="grid_view">
                            <a href="{{ route('shop') }}" data-toggle="tooltip" data-placement="top" title="Grid View"><i class="icofont-layout"></i></a>
                        </div>
                        <div class="list_view ml-3">
                            <a href="{{ route('shop.list') }}" data-toggle="tooltip" data-placement="top" title="List View"><i class="icofont-listine-dots"></i></a>
                        </div>
                    </div>
                    <select class="small right">
                        <option selected>Short by Popularity</option>
                        <option value="1">Short by Newest</option>
                        <option value="2">Short by Sales</option>
                        <option value="3">Short by Ratings</option>
                    </select>
                </div>
                
                @if(count($products)>0)
                <div class="shop_list_product_area">
                    <div class="row">
                        <!-- Single Product -->
                        @foreach ($products as $product)
                            <div class="col-12">
                                <div class="single-product-area mb-30">
                                    <div class="product_image">
                                        <!-- Product Image -->
                                        @php
                                            $photo = explode(',',$product->photo);
                                        @endphp
                                        @if(count($photo)> 1)
                                            <img class="normal_img" src="{{ asset('storage/uploads/products/'.$photo[0])}}" alt="">
                                            <img class="hover_img" src="{{ asset('storage/uploads/products/'.$photo[1])}}" alt="">
                                        @else
                                        <img class="normal_img" src="{{ asset('storage/uploads/products/'.$photo[0])}}" alt="">
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
                                            <a href="#"  
                                            data-quantity="1"
                                            data-product-id="{{ $product->id }}"
                                            class="add_to_cart"
                                            id="add_to_cart{{ $product->id }}"
                                            data-stock="{{ $product->stock }}"
                                            
                                            ><i class="icofont-shopping-cart"></i> Add to Cart</a>
                                        </div>

                                        <!-- Quick View -->
                                        <div class="product_quick_view">
                                            <a href="#" id="quickViewProduct" data-url="{{ route('product.quickview.detail') }}" data-id="{{ $product->unique_key }}"><i
                                                    class="icofont-eye-alt"></i> Quick View</a>
                                        </div>

                                        <p class="brand_name">{{ $product->brand->title }}</p>
                                        <a href="{{ route('product.details', $product->slug) }}">{{ $product->title }}</a>
                                        <h6 class="product-price">{{ Naira($product->sales_price) }} <span class="text-danger">{{ Naira($product->price) }}</span></h6>

                                        <p class="product-short-desc">{{ removeTag($product->summary) }}</p>
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
                            <li class="page-item">
                                <a class="page-link" href="#"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                            <li class="page-item"><a class="page-link" href="#">...</a></li>
                            <li class="page-item"><a class="page-link" href="#">8</a></li>
                            <li class="page-item"><a class="page-link" href="#">9</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
                @else
                    <h2 class="text-center text-muted">No Products Yet</h2>
                @endif
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
                        })


                        //add to cart 
                        
                })
        </script>
@endsection