
    <!-- Popular Brands Area -->
    <section class="popular_brands_area section_padding_100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="popular_section_heading mb-50">
                        <h5>Popular Brands</h5>
                    </div>
                </div>
                <div class="col-12">
                    <div class="popular_brands_slide owl-carousel">
                        @if($brands)
                            @foreach($brands as $brand)
                        <div class="single_brands">
                            <img src="{{ asset('storage/uploads/brands/'.$brand->photo)}}" alt="{{ $brand->title }}">
                        </div>
                            @endforeach
                        @endif
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Popular Brands Area -->