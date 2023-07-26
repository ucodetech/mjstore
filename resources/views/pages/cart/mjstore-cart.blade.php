@extends('layouts.app')
@section('frontcontent')
{{-- @include('inc.bread-user') --}}
@php
    $cart = \Gloudemans\Shoppingcart\Facades\Cart::instance('shopping');
    
@endphp
 <!-- Cart Area -->
  <div class="cart_area section_padding_100_70 pt-3 clearfix" id="cart_page_render">
    @include('inc.cart-page')
</div>
<!-- Cart Area End -->


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