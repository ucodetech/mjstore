@extends('layouts.app')
@section('frontcontent')
    
        @include('inc.welcome_area')
        @include('inc.top_catagory_area')
        @include('inc.quickviewModal')
        @include('inc.new_arrivals_area')
        @include('inc.featured_product_area')
        @include('inc.best_rated_onsale_top_sellares')
        @include('inc.offer_area')
        @include('inc.popular_brands_area')
        @include('inc.special_feature_area')


@endsection

@section('frontscripts')
<script src="{{ asset('shopjs/wishlist.js') }}"></script>
<script src="{{ asset('shopjs/cart.js') }}"></script>

        <script>
 


                $(function(){
                        
                        $('.carousel-main').owlCarousel({
                                items: 5,
                                loop: true,
                                autoplay: false,
                                autoplayTimeout: 1500,
                                margin:10,
                                padding:0,
                                nav: true,
                                dots: false,
                                navText: ['<span class="fas fa-chevron-circle-left fa-2x"></span>','<span class="fas fa-chevron-circle-right fa-2x"></span>'],
                        })
                      
                        $('.carousel-main-latest-product').owlCarousel({
                                items:5,
                                loop: true,
                                autoplay: true,
                                autoplayTimeout: 3000,
                                margin:10,
                                padding:0,
                                nav: true,
                                dots: false,
                                navText: ['<span class="fas fa-chevron-circle-left fa-2x"></span>','<span class="fas fa-chevron-circle-right fa-2x"></span>'],
                        })
                        $('.carousel-main-featured-product').owlCarousel({
                                items:4,
                                loop: true,
                                autoplay: true,
                                autoplayTimeout: 3000,
                                margin:10,
                                padding:0,
                                nav: true,
                                dots: false,
                                navText: ['<span class="fas fa-chevron-circle-left fa-2x"></span>','<span class="fas fa-chevron-circle-right fa-2x"></span>'],
                        })

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