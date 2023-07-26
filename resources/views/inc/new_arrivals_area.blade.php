
    <!-- New Arrivals Area -->
    <div class="container mt-3">
        <div class="col-md-12 shadow rounded-full">
            <div class="container">
               <div class="card bg-white border-0 rounded-full">
                <div class="card-header bg-white border-0 rounded-full">
                   <h5 class="text-muted text-left">
                    Latest Products
                   </h5>
                </div>
                <div class="card-body bg-white border-0  rounded-full">
                    <div class="row align-items-center">
                        <div class="col-12 col-carousel">
                            <div class="owl-carousel carousel-main-latest-product">
                            @if($products_new)
                                @foreach ($products_new as $new)
                                    <div class="imgHolder-product text-center">
                                        <a href="{{ route('product.details', $new->slug) }}" class="imgLik">
                                        @php
                                            $photo = explode(',',$new->photo);
                                        @endphp
                                        <img class="normal_img" src="{{ asset('storage/uploads/products/'.$photo[0])}}" alt="{{ $new->title }}">

                                        </a>
                                         <!-- Product Badge -->
                                         <div class="product_badge">
                                            <span>{{ $new->condition }}</span>
                                        </div>
                                        <span style="font-size:12px" class="d-block">
                                            <span>{{ $new->brand->title }}</span> <br>
                                            <span>{{ Str::length($new->title) > 20 ? wrap20($new->title): $new->title }}</span>
                                        </span>
                                        <span class="product-price" style="font-size:13px">
                                            {{ currency_converter($new->sales_price) }} 
                                            <span class="text-danger" style="font-size:12px">

                                            <strike>{{ ($new->product_discount == 0.00) ? " ": currency_converter($new->price) }}</strike>
                                        </span>
                                    </span>
                                    </div>
                                    
                                @endforeach
                            @endif
                            </div>
                        </div>
                </div>
                </div>
               </div>
        </div> 
    </div>
</div>
   