
    <!-- featured Area -->
    <div class="container mt-3">
        <div class="col-md-12 shadow rounded-full">
            <div class="container">
               <div class="card bg-white border-0 rounded-full">
                <div class="card-header bg-white border-0 rounded-full">
                   <h5 class="text-muted text-left">
                    Featured Products
                   </h5>
                </div>
                <div class="card-body bg-white border-0  rounded-full">
                    <div class="row align-items-center">
                        <div class="col-12 col-carousel">
                            <div class="owl-carousel carousel-main-featured-product">
                            @if($products_featured)
                                @foreach ($products_featured as $featured)
                                    <div class="imgHolder-product text-center">
                                        <a href="{{ route('product.details', $featured->slug) }}" class="imgLik">
                                        @php
                                            $photo = explode(',',$featured->photo);
                                        @endphp
                                        <img class="normal_img" src="{{ asset('storage/uploads/products/'.$photo[0]) }}" alt="{{ $featured->title }}">

                                        </a>
                                         <!-- Product Badge -->
                                         <div class="product_badge">
                                            <span>{{ $featured->condition }}</span>
                                        </div>
                                        <span style="font-size:12px" class="d-block">
                                            <span>{{ $featured->brand->title }}</span> <br>
                                            <span>{{ Str::length($featured->title) > 20 ? wrap20($featured->title): $featured->title }}</span>
                                        </span>
                                        <span class="product-price" style="font-size:13px">{{ Naira($featured->sales_price) }} <span class="text-danger" style="font-size:12px"><strike>{{ Naira($featured->price) }}</strike></span></span>
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
   
   