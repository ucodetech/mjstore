@extends('layouts.app')
@section('frontcontent')

<div class="container-fluid"> 
    <div class="row">
       @include('inc.product-sidebar')
        <div class="col-md-9">
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
            <div class="card-body rounded-10 bg-white shadow">
                @if(count($products)>0)
                        {{-- single product --}}
                <div class="row">
                    @foreach($products as $product)
                        @php
                            $photo = explode(',',$product->photo);
                        @endphp
                        <div class="col-md-3 col-sm-6 pb-3">
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
                        {{-- end of single product --}}
                </div>
                @else
                        <h4 class="text-muted">No product found</h4>
                @endif
            </div>
        </div>
       
    </div>
</div> 



@include('inc.quickviewModal')


@endsection


@section('frontscripts')
<script src="{{ asset('shopjs/wishlist.js') }}"></script>
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

                        $('#sortBy').on('change', function(e){
                            let sortBy = $(this).val();
                            let url1 = "{{ url(''.$route.'') }}/{{ $categories->slug }}?s="+sortBy;
                            let url2 = "{{ url(''.$route.'') }}/{{ $categories->slug }}";
                            window.location = sortBy=='default' ? url2:url1;
                            
                            
                        })

                        $('.color_product').on('change', function(e){
                            e.preventDefault();
                            let colors = $(this).val();
                            let url = "{{ url(''.$route.'') }}/{{ $categories->slug }}?color="+colors;
                            window.location = url;
                        })



                        
                })
        </script>
@endsection