    <div class="container mt-3">
        <div class="col-md-12 shadow rounded-full">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-carousel">
                        <div class="owl-carousel carousel-main">
                           
                            @foreach ($categories as $category)
                                <div class="imgHolder text-center">
                                    <a href="{{ url('category',$category->slug) }}" class="imgLik">
                                        <img src="{{ asset('storage/uploads/products/category/' .$category->photo)}}" alt="{{ $category->title }}">
                                        
                                    </a>
                                    <span>
                                        {{ $category->title }}
                                    </span>
                                </div>
                                
                            @endforeach
                        </div>
                    </div>
            </div>
        </div> 
    </div>
</div>
    <!-- Top Catagory Area -->
   