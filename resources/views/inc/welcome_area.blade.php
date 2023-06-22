    <!-- Welcome Slides Area -->
    <section class="welcome_area container h-50 mt-3">
        <div class="row">
            <div class="col-md-3">
                <div class="card bg-white border-0 shop_hover_card shadow-lg">
                    <div class="card-header text-uppercase bg-white border-0">
                        <a class="text-left">Category</a>
                    </div>
                    <div class="card-body" style="max-height:300px; overflow-y:scroll">
                        <!-- Single Checkbox -->
                        <div class="list-group bg-white" style="font-size:14px;">
                            
                            @foreach ($categories as $cat)
                            @php
                                if(count($cat->products)==0){
                                    $text = 'text-danger';
                                }elseif(count($cat->products) < 5){
                                    $text = 'text-warning';
                                }else{
                                    $text = 'text-success';
                                }
                            @endphp
                              <a href="{{ route('category.product', $cat->slug) }}" class="list-group-item list-group-item-action list-group-item-light text-dark border-0">{{ $cat->title }}</a>
                            @endforeach
                         </div>
                    
                    </div>
                </div>
            </div>
            <div class="col-md-9 shadow-lg  p-0 rounded-full">
                <div id="carouselId" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach ($banners as $key=>$banner)
                        <li data-target="#carouselId{{ $key }}" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active': '' }}"></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        @foreach ($banners as $key=>$banner)
                        <div class="carousel-item {{ $key == 0 ? 'active': '' }}">
                            <img data-src="{{ asset('storage/uploads/banners').'/'.$banner->photo}}" src="{{ asset('storage/uploads/banners').'/'.$banner->photo}}" alt="{{ $banner->title }}" style="height:350px">
                            {{-- <div class="carousel-caption d-none d-md-block">
                                <h3>Title</h3>
                                <p>Description</p>
                            </div> --}}
                        </div>
                        @endforeach

                    </div>
                    <a class="carousel-control-prev" href="#carouselId{{ $key }}" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselId" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

              
            </div>
        </div>
    </section>
    <!-- Welcome Slides Area -->