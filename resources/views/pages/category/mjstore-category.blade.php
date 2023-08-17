@extends('layouts.app')
@section('frontcontent')
    <style>
        .select {
            width: 100%;
            height: 100px !important;
            overflow-x: scroll;
        }
    </style>
    <div class="container-fluid mt-3">
        <div class="row">
            @include('inc.pro-side')
            <div class="col-md-9">

                <!-- Shop Top Sidebar -->
                <div class="shop_top_sidebar_area d-flex flex-wrap align-items-center justify-content-between">
                    {{-- <div class="view_area d-flex">
                        <div class="grid_view">
                            <a href="" data-toggle="tooltip" data-placement="top" title="Grid View"><i
                                    class="icofont-layout"></i></a>
                        </div>
                        <div class="list_view ml-3">
                            <a href="{{ route('shop.list') }}" data-toggle="tooltip" data-placement="top"
                                title="List View"><i class="icofont-listine-dots"></i></a>
                        </div>
                    </div> --}}
                    @php
                        $sorts = [
                            'default' => 'Default',
                            'priceAsc' => 'Price - Low-High',
                            'priceDsc' => 'Price - High-Low',
                            'titleAsc' => 'Title - Ascending',
                            'titleDsc' => 'Title - Descending',
                            'discountAsc' => 'Discount - Low-High',
                            'discountDsc' => 'Discount - High-Low',
                        ];
                    @endphp
                    <select id="sortBy" class="small right">
                        @foreach ($sorts as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Multi filter --}}
                <div class="card bg-white shadow mb-5">
                    <div class="card-header border-0 bg-white rounded-0">
                        <h4 class="text-center text-muted">Multi
                            <i class="fas fa-filter fa-lg fa-fw"></i>
                            <span class="text-danger text-bold lead">
                                Filter
                            </span>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('multi.filter') }}" method="post" id="multiFilterForm">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="cat_id" id="cat_id" value="{{ $categories->id }}">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="m_brand">Brand</label> <br>
                                    <select type="text" name="m_brand" id="m_brand" class="form-control  w-100">
                                        <option value="">--Select Brand--</option>
                                        @foreach ($brands as $m_b)
                                            <option value="{{ $m_b->id }}">{{ $m_b->title }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger text-error m_brand_error"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="m_color">Color</label> <br>
                                    <select type="text" name="m_color" id="m_color" class="form-control w-100">
                                        <option value="">--Select Color--</option>
                                        @foreach ($colors as $m_c)
                                            <option value="{{ $m_c->color }}">{{ $m_c->color }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger text-error m_color_error"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="m_size">Size</label> <br>
                                    <select type="text" name="m_size" id="m_size" class="form-control w-100">
                                        <option value="">--Select Size--</option>
                                        @foreach ($sizes as $m_s)
                                            <option value="{{ $m_s->size }}">{{ $m_s->size }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger text-error m_size_error"></span>
                                </div>

                                <div class="col-md-12 form-group">
                                    <hr class="invisible">
                                    <div class="d-flex  flex-grow-1 justify-content-between">
                                        <button type="submit"
                                            class="btn btn-sm btn-secondary bg-gradient-gray-dark">Filter</button>
                                        <button type="button" id="clearFilterM"
                                            class="btn btn-sm btn-warning bg-gradient-gray-dark">Clear</button>
                                    </div>

                                </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End of Multi Filter  --}}
            <div class="card-body rounded-10 bg-white shadow" id="showAjaxProduct">

                @if (count($products) > 0)
                    {{-- single product --}}
                    <div class="row">
                        @foreach ($products as $product)
                            @php
                                $photo = explode(',', $product->photo);
                            @endphp
                            <div class="col-md-3 col-sm-6 pb-3">
                                <div class="product-grid">
                                    <div class="product-image">
                                        <a href="{{ route('product.details', $product->slug) }}"
                                            title="{{ $product->title }}">
                                            @if (count($photo) > 1)
                                                <img decoding="async" class="pic-1"
                                                    src="{{ asset('storage/uploads/products/' . $photo[0]) }}">
                                                <img decoding="async" class="pic-2"
                                                    src="{{ asset('storage/uploads/products/' . $photo[1]) }}">
                                            @else
                                                <img decoding="async" class="pic-1"
                                                    src="{{ asset('storage/uploads/products/' . $photo[0]) }}">
                                            @endif

                                        </a>
                                        <ul class="social">
                                            {{-- quick view --}}
                                            <li><a style="cursor:pointer" data-tip="Quick View" id="quickViewProduct"
                                                    data-url="{{ route('product.quickview.detail') }}"
                                                    data-id="{{ $product->unique_key }}"><i class="fa fa-search"></i></a>
                                            </li>
                                            {{-- add to wishlist  --}}
                                            <li>
                                                <a style="cursor:pointer" data-tip="Add to Wishlist"
                                                    href="javascript:void(0)" class="add_to_wishlist"
                                                    data-product-id="{{ $product->id }}"
                                                    data-url={{ route('wishlist.store') }}
                                                    id="add_to_wishlist-{{ $product->id }}"><i
                                                        class="fa fa-shopping-bag"></i></a>
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
                                        <span class="product-discount-label"
                                            style="background:orangered">{{ N2P($product->product_discount) }}</span>
                                    </div>
                                    <ul class="rating">
                                        <li class="fa fa-star"></li>
                                        <li class="fa fa-star"></li>
                                        <li class="fa fa-star"></li>
                                        <li class="fa fa-star"></li>
                                        <li class="fa fa-star disable"></li>
                                    </ul>
                                    <div class="product-content">
                                        <h3 class="title">
                                            <a href="{{ route('product.details', $product->slug) }}">
                                                {{ $product->title }}
                                            </a>
                                            <p class="m-0 p-0"><span
                                                    class="text-sm text-muted">{{ $product->brand->title }}</span></p>
                                        </h3>
                                        <div class="price text-success">{{ currency_converter($product->sales_price) }}
                                            <span
                                                class="text-danger text-strike">{{ $product->product_discount == 0.0 ? ' ' : currency_converter($product->price) }}</span>
                                        </div>
                                        @if (\App\Models\ProductAttribute::where('product_id', $product->id)->first())
                                            <a href="{{ route('product.details', $product->slug) }}"
                                                title="You are seeing this because this product has attributes"
                                                class="btn btn-info text-light">Full details</a>
                                        @else
                                            <a style="cursor:pointer" data-quantity="1"
                                                data-product-id="{{ $product->id }}"
                                                class="btn btn-info text-light  add_to_cart"
                                                id="add_to_cart{{ $product->id }}" data-stock="{{ $product->stock }}"
                                                data-url-cart="{{ route('cart.store') }}"><i
                                                    class="fa fa-shopping-cart"></i> Add To Cart</a>
                                        @endif


                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{-- end of single product --}}
                    </div>
                @else
                    <h4 class="text-muted">No product found</h4>
                @endif

                <div class="d-flex justify-content-center align-items-center mt-4">
                    {{ $products->appends($_GET)->links('pagination::bootstrap-4') }}
                </div>
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
        $(function() {
            //quick view script
            $('body').on('click', '#quickViewProduct', function(e) {
                e.preventDefault();
                let url = $(this).data('url');
                let uniquekey = $(this).data('id');
                $.get(url, {
                    uniquekey: uniquekey
                }, function(data) {
                    $('#quickview').modal('show');
                    $('#showQuickDetails').html(data);
                })
            })
            //sort script
            $('#sortBy').on('change', function(e) {
                let sortBy = $(this).val();
                let url1 = "{{ url('' . $route . '') }}/{{ $categories->slug }}?s=" + sortBy;
                let url2 = "{{ url('' . $route . '') }}/{{ $categories->slug }}";
                window.location = sortBy == 'default' ? url2 : url1;


            })
            //select colors and set it to url
            $('.color_product').on('change', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let color = $('#product_color' + id).val();

                if ($('#color').val() != '') {
                    ecolor = $('#color').val();
                    $('#color').val(ecolor + ',' + color);
                } else {
                    $('#color').val(color);
                }

            })
            //apply color filter
            $('body').on('click', '#applyFilterColor', function(e) {
                e.preventDefault();
                let colors = $('#color').val();
                let url = "{{ url('' . $route . '') }}/{{ $categories->slug }}?color=" + colors;
                window.location = url;
            });
            //clear color filter
            $('body').on('click', '#clearFilterColor', function(e) {
                e.preventDefault();
                $('#color').val("");
                // let url = "{{ url('' . $route . '') }}/{{ $categories->slug }}";
                // window.location = url;
            })
            //slide range script
            if ($('#slider-range').length > 0) {
                const max_price = parseInt($('#slider-range').data('max')) || 9999;
                const min_price = parseInt($('#slider-range').data('min')) || 0;
                const currency = $('#slider-range').data('currency') || '';
                let price_range = min_price + '-' + max_price;

                if ($("#price_range").length > 0 && $('#price_range').val()) {
                    price_range = $("#price_range").val().trim();

                }

                let price = price_range.split('-');
                $('#slider-range').slider({
                    range: true,
                    min: min_price,
                    max: max_price,
                    values: price,
                    slide: function(event, ui) {
                        $('#amount').html("Price: " + currency + ui.values[0] + " - " + currency + ui
                            .values[1]);
                        $('#price_range').val(ui.values[0] + "-" + ui.values[1]);


                    }


                });


            }
            //apply slide data
            $('body').on('click', '#applyFilter', function(e) {
                e.preventDefault();
                let price_range = $('#price_range').val();

                let url = "{{ url('' . $route . '') }}/{{ $categories->slug }}?price_range=" + price_range;
                window.location = url;
            })
            //brand
            $('body').on('change', '.product_brand', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let brand = $('#product_brand' + id).val();
                if ($('#brands').val() != '') {
                    let ebrand = $('#brands').val();
                    $('#brands').val(ebrand + ',' + brand);
                } else {
                    $('#brands').val(brand);
                }
            })

            $('body').on('click', '#applyFilterBrand', function(e) {
                e.preventDefault();
                let brand = $('#brands').val();
                let url = "{{ url('' . $route . '') }}/{{ $categories->slug }}?brand=" + brand;
                window.location = url;
            })


            //search brand
            $('#searchBrand').keyup(function(e) {
                e.preventDefault();
                let brand = $(this).val();
                let _token = "{{ csrf_token() }}";
                let url = "{{ route('search.brand') }}";
                let brands = "{{ !empty($_GET['brand']) ? $_GET['brand'] : '' }}";
                if (brand.length > 0) {
                    $.post(url, {
                        brand: brand,
                        brands: brands,
                        _token: _token
                    }, function(data) {
                        $('#showBrandResult').html(data);
                    })
                } else {
                    fetchBrands();
                }

            });
            //clear brand filter
            $('body').on('click', '#clearFilterBrand', function(e) {
                e.preventDefault();
                let url = "{{ url('' . $route . '') }}/{{ $categories->slug }}";
                window.location = url;
            })


            //fetch brand with ajax
            fetchBrands();

            function fetchBrands() {
                let url = "{{ route('fetch.brand') }}";
                let _token = "{{ csrf_token() }}";
                let brands = "{{ !empty($_GET['brand']) ? $_GET['brand'] : '' }}";
                $.post(url, {
                    brands: brands,
                    _token: _token
                }, function(data) {
                    $('#showBrandResult').html(data);
                })
            }

            //filter by size 
            $('.product_size').on('change', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let msize = $('#product_size' + id).val();
                // console.log(msize);
                let url = "{{ url('' . $route . '') }}/{{ $categories->slug }}?size=" + msize;
                window.location = url;
            })
            ///clear multiple  filter
            $('body').on('click', '#clearFilterM', function(e) {
                e.preventDefault();
                location.reload();

            })
            //Multi filter
            $('#multiFilterForm').on('submit', function(e) {
                e.preventDefault();
                let form = this;
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $(form).find('span.text-error').text('');
                    },
                    success: function(data) {
                        if (data.code == 0) {
                            $.each(data.error, function(prefix, val) {
                                $(form).find('span.' + prefix + '_error').text(val[0]);
                            })
                        } else {
                            // $('#multiFilterForm')[0].reset();
                            $('#showAjaxProduct').html(data.data);
                        }
                    }
                });
            })

        })
    </script>
@endsection
