@extends('layouts.app')
@section('frontcontent')
@include('inc.bread-user')
  @php
          $cart = \Gloudemans\Shoppingcart\Facades\Cart::instance('shopping');

  @endphp
    <!-- Checkout Area -->
    <div class="checkout_area section_padding_100" id="checkaddress_render">
        <div class="container">
            <div class="row">
               <div class="col-lg-8">
                    <div class="card shadow-lg bg-light mb-2" >
                        <div class="card-header d-flex gap-10">
                            <div class="completedBoxAddress text-{{ ($is_user_entered)? 'success':'muted' }}">
                                <i class="icofont-check-circled fa-2x"></i>
                            </div>
                            <div class="card-title text-left text-uppercase">
                                &nbsp; 1. Address Details
                            </div>
                        </div>
                        <div class="card-body p-4 border-0 bg-white" id="addressBox">
                            @if ($is_user_entered)
                                 <div class="d-flex-block gap-0 m-0 p-1 text-sm text-muted">
                                    <h5 class="text-bolder">{{ $is_user_entered->fullname }}</h5>
                                    <span>
                                        {{ $is_user_entered->address }}, {{ $is_user_entered->town }}, {{ $is_user_entered->state }}
                                    </span><br>
                                    <span>
                                        {{ ($is_user_entered->postcode)?$is_user_entered->postcode:'' }} 
                                    </span><br>
                                    <span> 
                                        {{ $is_user_entered->phone_number }}
                                    </span>
                                    <hr>
                                    <button type="button" id="changeAddress" class="btn btn-info">Change</button>
                                </div>   
                            @else
                                @include('inc.checkout-address')
                            @endif
                        </div>
                           
                    </div>
                    <div class="card shadow-lg mb-2 bg-light" id="deliveryBox">
                        @php
                            if($is_user_entered){
                                if($is_user_entered->delivery_method_entered == 1){
                                    $text = 'text-success';
                                }else{
                                    $text ='text-muted';
                                }
                            }
                        @endphp
                        <div class="card-header d-flex gap-10">
                            <div class="completedBoxDelivery {{ $is_user_entered ? $text : '' }}">
                                <i class="icofont-check-circled fa-2x"></i>
                            </div>
                            <div class="card-title text-left text-uppercase">
                                &nbsp; 2. Delivery Method
                            </div>
                        </div>
                    @if($is_user_entered)
                            @if($is_user_entered->delivery_method_entered == 0)
                                <div class="card-body border-0">
                                    <h4 class="text-bold">How do you want your delivery</h4>
                                    @foreach ($shippings as $key=>$shipping)
                                    <input type="hidden" name="shipid" id="shipid" value="{{ $shipping->id }}">
                                    <div class="media">
                                            
                                            @php
                                                if(session()->has('shipping_method_checked')){
                                                    if(session('shipping_method_checked')['method_id'] == $shipping->id){
                                                        $checked = 'checked';
                                                    }else{
                                                        $checked = '';
                                                    }
                                                }else{
                                                    $checked = '';
                                                }
                                            @endphp
                                            <div class="media-body">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" 
                                                    name="shipping_method"
                                                    id="shipping_method{{$shipping->id}}" 
                                                    data-id="{{ $shipping->id }}"
                                                    data-fee="{{ $shipping->delivery_charge }}"
                                                    data-method="{{ $shipping->shipping_method }}"
                                                    data-qty="{{ $cart->qty }}"
                                                    data-url="{{ route('shop.shipping.submit') }}"
                                                    class="custom-control-input custom-control-input-green shipping_method" {{ ($is_user_entered->shipping_method == $shipping->id ? ' checked':$checked) }}>
                                                    <label class="custom-control-label" for="shipping_method{{ $shipping->id }}">{{ $shipping->shipping_method }}</label>
                                                </div>
                                                @php
                                                $fee = Naira($shipping->delivery_charge);
                                                @endphp
                                                <small class="text-muted ml-3">{{ $shipping->delivery_time }} 
                                                    <span class="text-primary">{{ ($shipping->delivery_charge != 0 )? $fee:' Free Delivery' }}</span>
                                                </small>
                            
                                            <div class="media">
                                                <div class="media-body mt-2 border-4 shadow-sm">
                                                <p class="p-3"><i class="fa fa-question-circle"></i>&nbsp;{{ $shipping->delivery_description !='' ? $shipping->delivery_description:'Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum voluptatem voluptate dolorum necessitatibus suscipit, qui atque eveniet possimus ad dignissimos totam, nostrum officia? Maiores deleniti, iure unde aut velit perferendis?' }}</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                
                                    <hr>
                                    
                                @endforeach
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="text-left text-bold">Shipment Details</h5>
                                        </div>
                                        <div class="card-body" id="shipmentDetails">
                                            <section class="text-center" id="spinner">
                                                <i class="fa fa-spinner fa-spin fa-3x"></i>
                                            </section>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="checkout_pagination d-flex justify-content-end mt-50">
                                            <button type="button" id="nextStepBtn" class="btn btn-block btn-primary mt-2 ml-2">Proceed To next Step</button>
                                        </div>
                                    </div>
                                </div> 
                            @else
                                <div class="card-body">
                                    <span class="text-bold pl-3">
                                        {{ \App\Models\Shipping::shippingMethod($is_user_entered->shipping_method)->shipping_method }}
                                    </span> <br>
                                    <span class="text-bold text-muted pl-3">
                                        {{ \App\Models\Shipping::shippingMethod($is_user_entered->shipping_method)->delivery_time }} for {{ ($is_user_entered->delivery_charge == 0)? 'Free': $is_user_entered->delivery_charge}}
                                    </span>
                                    <hr>
                                    <div class="form-group mt-3">
                                        <button type="button" id="changeDeliveryMethod" class="btn btn-info">Change</button>
                                    </div>
                                
                                </div>
                            @endif
                        @endif
                
                    </div>
                
                    <div class="card shadow-lg bg-light" id="paymentBox">
                        <div class="card-header d-flex gap-10">
                            <div class="completedBoxPayment">
                                <i class="icofont-check-circled fa-2x"></i>
                            </div>
                            <div class="card-title text-left text-uppercase">
                                &nbsp; 3. Payment Method
                            </div>
                        </div>
                        @php
                            if($is_user_entered ){
                               $d_method =  $is_user_entered->delivery_method_entered != 1 ? 'd-none': '';
                            }
                        @endphp
                        <div class="card-body border-none {{ $is_user_entered ? $d_method: '' }}">
                            @include('inc.payment_method')
                        </div> 
                    </div>
             </div>
                <div class="col-lg-4 bg-light">
                    <div class="card shadow-lg mb-2">
                        <div class="card-header">
                            <div class="card-title text-left text-uppercase">
                                &nbsp; Your Order({{ count($cart->content()) }} items)
                            </div>
                        </div>
                        <div class="card-body border-0">
                            @foreach ($cart->content() as $item)
                            @php
                                $photo = explode(',',$item->model->photo);
                            @endphp
                            <div class="media w-100">
                                <a class="d-flex" href="#">
                                    <img src="{{ asset('storage/uploads/products/'.$photo[0]) }}" alt="{{ $item->name }}" class="img-thumbnail" width="50">
                                </a>
                                <div class="media-body pl-2">
                                    <small>
                                        {{ $item->name }}
                                    </small> <br>
                                    <small class="price text-primary">
                                        {{ Naira($item->price) }}
                                    </small><br>
                                    <small>
                                        Qty: {{ $item->qty }}
                                    </small>
                                </div>
                            </div> <hr>
                        @endforeach
                            <div class="media">
                                <div class="media-body" id="orderDetails">
                                </div>
                               
                            </div>
                            
                        </div> 
                    </div>
                </div>
               
            </div>
        </div>
    </div>
    <!-- Checkout Area -->

    <!-- change address Modal -->
    <div class="modal fade" id="changeAddressModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg model-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Address</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    
                <form action="{{ route('shop.billing.update.submit') }}" method="post" id="updateBillingAddress">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_fullname">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="edit_fullname" id="edit_fullname" placeholder="Full Name" value="{{ muser()->fullname }}" required>
                            <span class="text-error text-danger edit_fullname_error"></span>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            
                            <label for="edit_email">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="edit_email" id="edit_email" placeholder="Email Address" value="{{ muser()->email }}" @readonly(true)>
                            <span class="text-error text-danger edit_email_error"></span>

                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label><small>Chose Phone No. to use</small></label>
                                    <select id="myNo" class="form-control w-100">
                                        <option value="{{ userPhone(muser()->phone_number)[0] }}">{{ userPhone(muser()->phone_number)[0] }}</option>
                                        <option value="{{ count(userPhone(muser()->phone_number)) > 1 ? userPhone(muser()->phone_number)[1] : userPhone(muser()->phone_number)[0] }}">{{ count(userPhone(muser()->phone_number)) > 1 ? userPhone(muser()->phone_number)[1]: userPhone(muser()->phone_number)[0] }}</option>
                                    </select>
                                    
                                </div>
                                <div class="col-md-8">
                                    <label for="edit_phone_number">Phone Number <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="edit_phone_number" id="edit_phone_number" min="0" value="{{ userPhone(muser()->phone_number)[0] }}" @readonly(true)>   
                                    <span class="text-error text-danger edit_phone_number_error"></span>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="edit_address">Deliver Address <span class="text-danger">*</span></label>
                            <textarea name="edit_address" id="edit_address"  rows="5" class="form-control" placeholder="Street Name/Building/Apartment No">{{ $is_user_entered ? $is_user_entered->address:muser()->address, muser()->apartment_suite_unit }}</textarea>
                            <span class="text-error text-danger edit_address_error"></span>

                            
                        </div>
                    </div>
                    
                    <div class="row">
                        
                        <div class="form-group col-md-6 mb-3">
                            <label for="state">State <span class="text-danger">*</span></label>
                          
                            <select name="state" id="state" class="custom-select d-block w-100 form-control">
                                <option value="">--Select State--</option>
                                    @php
                                             $entered_state = (($is_user_entered == true)? $is_user_entered->state:'');

                                    @endphp
                                @foreach ($states as $state)
                                    <option value="{{$state->name}}" {{ $state->name == $entered_state ? ' selected':''}}>{{ $state->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-error text-danger state_error"></span>

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="city">Town/City <span class="text-danger">*</span></label>
                            <select name="city" id="city" class="custom-select d-block w-100 form-control">
                                
                            </select>
                            <span class="text-error text-danger city_error"></span>

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="postcode">Postcode/Zip</label>
                            <input type="text" class="form-control" name="postcode" id="postcode" placeholder="Postcode / Zip" value="{{ $is_user_entered ? $is_user_entered->postcode:muser()->postcode_zip }}">
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="checkout_pagination d-flex justify-content-end mt-50">
                            <button type="submit" id="UpdatebillingBtn" class="btn btn-block btn-primary mt-2 ml-2">Save</button>
                        </div>
                    </div>
                </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('frontscripts')
<script src="{{ asset('shopjs/cart.js') }}"></script>

        <script>
                $(function(){
                    // pass the user exisiting city as the selected
                   


                    $('body').on('change', '#myNo', function(e){
                        e.preventDefault();
                        let chosedNo = $(this).val();
                        $('#phone_number').val(chosedNo);
                    })

                    $('body').on('click','#changeAddress', function(e){
                        e.preventDefault();
                        $('#changeAddressModal').modal('show');
                        let selected = "{{ $is_user_entered ? $is_user_entered->town:'' }}";
                        get_city(selected);
                    })

                    $('#submitBillingForm').on('submit', function(e){
                        e.preventDefault();
                        let form = this;
                        $.ajax({
                            url:$(form).attr('action'),
                            method:$(form).attr('method'),
                            data: new FormData(form),
                            contentType:false,
                            processData:false,
                            dataType:'JSON',
                            beforeSend:function(){
                                $(form).find('span.text-error').text('');
                                $('#billingBtn').html('<i class="fa fa-spinner fa-spin fa-lg"></i> Checking....');
                            },
                            complete:function(){
                                $('#billingBtn').html('Save and Contunie');
                            },
                            success:function(response){
                                if(response.code == 0){
                                    $.each(response.error,function(prefix, val){
                                        $(form).find('span.'+prefix+'_error').text(val[0]);
                                    })
                                }else{
                                    // $('#checkaddress_render').html(response.checkaddress_render);
                                    // $('.completedBoxAddress').addClass('text-success');
                                    location.reload();
                                    toastr.success(response.msg);
                                }
                            }
                        })
                    })
         
                   

                // fetch lga of a state
                $('#state').on('change', function(e){
                    e.preventDefault()
                    let state = $(this).val();
                    let url = "{{ route('get.state.lga') }}";
                    let html_option='<option value="">---Select LGA----</option>';
                    $.post(url, {state:state}, function(response){
                        if(response.code == 1){
                            $.each(response.data, function(lga_name, id){
                                html_option+='<option value="'+lga_name+'">'+lga_name+'</option>';
                                $('#city').html(html_option);
                            })
                        }else{
                            toastr.error(response.msg);
                            $('#city').html('');
                        }
                    
                    })                
                })

             //user town is the selected
             function get_city(selected){
                if(typeof selected === 'undefined'){
                    let selected = '';
                }
                // var state_name = "Bayelsa";
                // console.log(state_name);
                let state_name = $('#state').val();
                let url = "{{ route('get.state.city') }}";
                $.post(url, {selected:selected,state_name:state_name}, function(data){
                    $('#city').html(data);
                })
                
             }

             $('select[name="state"]').on('change', function(){
                    get_city();
             });


            $('#updateBillingAddress').on('submit', function(e){
                        e.preventDefault();
                        let form = this;
                        $.ajax({
                            url:$(form).attr('action'),
                            method:$(form).attr('method'),
                            data: new FormData(form),
                            contentType:false,
                            processData:false,
                            dataType:'JSON',
                            beforeSend:function(){
                                $(form).find('span.text-error').text('');
                                $('#UpdatebillingBtn').html('<i class="fa fa-spinner fa-spin fa-lg"></i> Checking....');
                            },
                            complete:function(){
                                $('#UpdatebillingBtn').html('Save');
                            },
                            success:function(response){
                                if(response.code == 0){
                                    $.each(response.error,function(prefix, val){
                                        $(form).find('span.'+prefix+'_error').text(val[0]);
                                    })
                                }else{
                                    // $('#checkaddress_render').html(response.checkaddress_render);
                                    // $('.completedBoxAddress').addClass('text-success');
                                    $('#changeAddressModal').modal('hide');
                                    location.reload();
                                    
                                }
                            }
                })
            })
                    
            
                    //SHIPPING METHOD
     
             $('body').on('change','.shipping_method', function(e){
                e.preventDefault();
               let  method_id  = $(this).data('id');
               let  delivery_fee  = $(this).data('fee');
               let  _token  = "{{ csrf_token() }}";
               let url = "{{ route('shop.shipping.submit') }}";            
                $.ajax({
                    url:url,
                    method:"POST",
                    data:{
                        method_id:method_id,
                        delivery_fee:delivery_fee,
                        _token:_token
                    },
                    success:function(data){
                        getShippingDetails();
                        getOrderDetails();

                    }

                })
            })
            
             //update shipping entered
            $('body').on('click','#nextStepBtn', function(e){
                e.preventDefault();
               let  _token  = "{{ csrf_token() }}";
               let url = "{{ route('shop.shipping.submit') }}";
                $.ajax({
                    url:url,
                    method:"POST",
                    data:{
                        updateShippingEntered: 'shippingEntered',
                        _token:_token
                    },
                    success:function(data){
                        location.reload();
                    }

                })
            })
            getShippingDetails();
            function getShippingDetails(){
                let url = "{{ route('get.shipping.details') }}";
                let _token = "{{ csrf_token() }}";
                $.ajax({
                    url:url,
                    method:'get',
                    data:{
                        _token: _token
                    },
                    beforeSend:function(){
                        $('#spinner').html('<i class="fa fa-spinner fa-spin fa-3x"></i>');
                    },
                    success:function(data){
                        // get the shipping details
                        $('#shipmentDetails').html(data);
                    }
                })
            }

            // order details
            getOrderDetails();
            function getOrderDetails(){
                let url = "{{ route('get.order.details') }}";
                let _token = "{{ csrf_token() }}";
                $.ajax({
                    url:url,
                    method:'get',
                    data:{
                        _token: _token
                    },
                    beforeSend:function(){
                        $('#spinner').html('<i class="fa fa-spinner fa-spin fa-3x"></i>');
                    },
                    success:function(data){
                        // get the shipping details
                        $('#orderDetails').html(data);
                    }
                })
            }
                    
            //change delviery method
            $('body').on('click','#changeDeliveryMethod', function(e){
                 e.preventDefault();
                 let _token = "{{ csrf_token() }}";
                 let url = "{{ route('change.delivery.method') }}";
                 let updateShippingMethod = 'shippingMethodUp';
                 $.post(url, {updateShippingMethod:updateShippingMethod, _token:_token}, function(data){
                        location.reload();
                 })       
            })

            $('body').on('change','#cashOnDelivery', function(e){
                e.preventDefault();
               let p_method = $(this).val();
               let _token  = "{{ csrf_token() }}";
               let url = "{{ route('shop.payment.method.submit') }}";            
                $.ajax({
                    url:url,
                    method:"POST",
                    data:{
                        p_method:p_method,
                        _token:_token
                    },
                    success:function(data){
                        return true;

                    }

                })
            })
            
            // $('body').on('click','#comfirmOrderBtn', function(e){
            //     e.preventDefault();
            //    let  _token  = "{{ csrf_token() }}";
            //    let url = "";
            //     $.ajax({
            //         url:url,
            //         method:"POST",
            //         data:{
            //             _token:_token
            //         },
            //         success:function(data){
            //             if(data.code == 0){
            //                 toastr.error(data.error);
            //             }
            //         }

            //     })
            // })
    })
        </script>
@endsection