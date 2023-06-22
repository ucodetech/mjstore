@extends('layouts.usersapp')

@section('frontcontent')
@include('inc.bread-user')
@if (Auth::check())
     @php
         $customer = auth()->user();
     @endphp
@endif
   <!-- My Account Area -->
   <section class="my-account-area section_padding_100_50">
    <div class="container">
        <div class="row">
            @include('inc.customerdashboard')
            <div class="col-12 col-lg-9">
                <div class="my-account-content mb-50">
                    {{-- contents --}}
                    <p>The following addresses will be used on the checkout page by default.</p>

                    <div class="row">
                        <div class="col-12 col-lg-6 mb-5 mb-lg-0">
                           <section id="showBillingAddress"></section>
                            <a href="#" id="editBillingAddress" data-target="#billingAddressModal" data-toggle="modal" class="btn btn-primary btn-sm">Edit Address</a>
                        </div>

                        <div class="col-12 col-lg-6">
                            <section id="showShippingAddress"></section>
                            <a href="#" id="editShippingAddress" data-target="#shippingAddressModal" data-toggle="modal" class="btn btn-primary btn-sm">Edit Address</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('inc.customer-addresses')

<!-- My Account Area -->

@endsection

@section('frontscripts')
  <script>
    // let user = '{{ auth()->user()->id }}';

    // checkStatus();
    
    // function checkStatus(user){
    //   let url = 'check-user-status';
    //   let _token = '{{ csrf_token() }}';
    //   $.post(url, {_token:_token}, function(data){
    //         toastr.error('An Error Occured Please relogin!');
    //         setTimeout(() => {
    //             location.reload();
    //         }, 3000);
          
    //   })
    // }

  
    
    //   setInterval(() => {
    //       checkStatus();
    //   }, 1000);

    $(function(){

        $('#customerBillingForm').on('submit', function(e){
            e.preventDefault();
           let form = this;
           $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data: new FormData(form),
                contentType:false,
                processData:false,
                beforeSend:function(){
                    $(form).find('span.text-error').text('');
                },
                success:function(data){
                    if(data.code == 0){
                        $.each(data.error, function(prefix, val){
                            $(form).find('span.'+prefix+'_error').text(val[0]);
                        })
                    }else{
                        $('#customerBillingForm')[0].reset();
                        $('#billingAddressModal').modal('hide');
                        toastr.success(data.msg);
                        fetchBillingAddress();

                    }

                    
                }
                
           })
        })
        fetchBillingAddress();
        function fetchBillingAddress(){
            let url = 'fetch-billing-address';
            let data = 'fetchBillingAddress';
            $.get(url, {data:data}, function(response){
                $('#showBillingAddress').html(response);
            })
        }


        $('#customerShippingForm').on('submit', function(e){
            e.preventDefault();
           let form = this;
           $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data: new FormData(form),
                contentType:false,
                processData:false,
                beforeSend:function(){
                    $(form).find('span.text-error').text('');
                },
                success:function(data){
                    if(data.code == 0){
                        $.each(data.error, function(prefix, val){
                            $(form).find('span.'+prefix+'_error').text(val[0]);
                        })
                    }else{
                        $('#customerShippingForm')[0].reset();
                        $('#shippingAddressModal').modal('hide');
                        toastr.success(data.msg);
                        fetchShippingAddress();

                    }

                    
                }
                
           })
        })
        fetchShippingAddress();
        function fetchShippingAddress(){
            let url = 'fetch-shipping-address';
            let data = 'fetchShippingAddress';
            $.get(url, {data:data}, function(response){
                $('#showShippingAddress').html(response);
            })
        }
    })
  
  </script>
@endsection