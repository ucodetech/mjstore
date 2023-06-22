@extends('layouts.app')
@section('frontcontent')
@include('inc.bread-user')

        
      <!-- Checkout Area -->
      <div class="checkout_area section_padding_100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="order_complated_area clearfix">
                        <h5>Thank You For Your Order.</h5>
                        <p>You will receive an email of your order details</p>
                        <p class="orderid mb-0">Your Order id <span style="color:orangered">{{ (($order_number)? $order_number: '') }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout Area End -->
  
  

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
                    
                    $('body').on('change', '#myNo', function(e){
                        e.preventDefault();
                        let chosedNo = $(this).val();
                        $('#phone_number').val(chosedNo);
                    })

                    $('#ShipdiifAddress').on('change', function(e){
                        e.preventDefault();
                        if(this.checked){
                            $('.shippingBox').removeClass('d-none');
                        }else{
                            $('.shippingBox').addClass('d-none');
                        }
                    })
                      
                })
        </script>
@endsection