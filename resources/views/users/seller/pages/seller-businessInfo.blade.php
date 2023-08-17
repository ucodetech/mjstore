@extends('layouts.sellerapp')
@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('inc.bread')
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      
        <div class="row">
              <div class="card card-outline card-danger w-100">
                <div class="card-header d-flex justify-content-center text-center">
                  <h3 class="card-title text-info">
                    <i class="fa fa-info-circle fa-1x"></i> 
                    @if (seller()->business_options == 0)
                    Your Business is not registered and does not have CAC certificate! your shop might be limited to some extent, but we will serve you better
                    @else
                    Your Business is a registered, you will have to provide details of your CAC registrations!
                  <!-- /.row -->
                  @endif
                  </h3>
                </div>
                <div class="card-body">
                 
                  <form action="{{ route('seller.vendor.biz.info.process') }}" method="post" id="bizInfoForm">
                    <h3 class="text-center">Business Information</h3>
                    @csrf
                    @method("POST")
                    <div class="bs-stepper">
                      <div class="bs-stepper-header" role="tablist">
                        <!-- your steps here -->
                        <div class="step" data-target="#shoplocation-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="shoplocation-part" id="shoplocation-part-trigger">
                            <span class="bs-stepper-circle">1</span>
                            <span class="bs-stepper-label">Shop Details</span>
                          </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#customersupport-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="customersupport-part" id="customersupport-part-trigger">
                            <span class="bs-stepper-circle">2</span>
                            <span class="bs-stepper-label">Customer Support</span>
                          </button>
                        </div>
                      </div>
                      <div class="bs-stepper-content">
                        <!-- your steps content here -->
                        <div id="shoplocation-part" class="content" role="tabpanel" aria-labelledby="shoplocation-part-trigger">
                          <h3 class="text-center">Shop Location/Logo</h3>

                          <div class="row">
                            <div class="col-md-6 form-group">
                              <label for="shop_address">Shop Address</label>
                              <input type="text" name="shop_address" id="shop_address" class="form-control">
                              <span class="text-error text-danger shop_address_error"></span>
                            </div>
                            <div class="col-md-3 form-group">
                              <label for="shop_state">State to ship From</label>
                              <select name="shop_state" id="shop_state" class="form-control">
                                <option value="">--Select State--</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->name }}">{{ $state->name }}</option>
                                @endforeach
                              </select>
                              <span class="text-error text-danger shop_state_error"></span>
                            </div>
                            <div class="col-md-3 form-group">
                              <label for="shop_city">City/Town</label>
                              <select name="shop_city" id="shop_city" class="custom-select d-block w-100 form-control">
                              </select>
                              <span class="text-error text-danger shop_city_error"></span>
                            </div>
                            <div class="col-md-6 form-group">
                              <label for="shop_logo">Shop Logo</label>
                              <div class="input-group">
                                <div class="custom-file">
                                  <input type="file" class="custom-file-input" name="shop_logo" id="shop_logo">
                                  <label class="custom-file-label" for="shop_logo">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                  <span class="input-group-text">png or jpeg</span>
                                </div>
                              </div>
                              <span class="text-error text-danger shop_logo_error"></span>
                            </div>
                            <div class="form-group col-md-6">
                              <div id="previewShopLogo">
                                <h6 class="text-center">Preview Shop Logo</h6>
                              </div>
                            </div>
                          </div>
                          <h3 class="text-center">Bank Details</h3>
                          <div class="row">
                            <div class="col-md-4 form-group">
                              <label for="bank_name">Bank Name</label>
                              <input type="text" name="bank_name" id="bank_name" class="form-control">
                              <span class="text-error text-danger bank_name_error"></span>
                            </div>
                            <div class="col-md-4 form-group">
                              <label for="account_name">Account Name</label>
                              <input type="text" name="account_name" id="account_name" class="form-control">
                              <span class="text-error text-danger account_name_error"></span>
                            </div>
                            <div class="col-md-4 form-group">
                              <label for="account_number">Account Number</label>
                              <input type="text" name="account_number" id="account_number" class="form-control" minlength="10" maxlength="10">
                              <span class="text-error text-danger account_number_error"></span>
                            </div>
                          </div>
                          @if(seller()->business_options == 1)
                            <h3 class="text-center">Registered Business Information</h3>
                            <div class="row">
                              <div class="col-md-6 form-group">
                                <label for="registered_biz_name">Registered Business Name</label>
                                <input type="text" name="registered_biz_name" id="registered_biz_name" class="form-control">
                                <span class="text-error text-danger registered_biz_name_error"></span>
                              </div>
                              <div class="col-md-6 form-group">
                                <label for="cac_registration_no">CAC Registration No.</label>
                                <input type="text" name="cac_registration_no" id="cac_registration_no" class="form-control">
                                <span class="text-error text-danger cac_registration_no_error"></span>
                              </div>
                              <div class="col-md-6 form-group">
                                <label for="cac_certificate">CAC Certificate</label>
                                <div class="input-group">
                                  <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="cac_certificate" id="cac_certificate">
                                    <label class="custom-file-label" for="cac_certificate">Choose file</label>
                                  </div>
                                  <div class="input-group-append">
                                    <span class="input-group-text">png/jpeg</span>
                                  </div>
                                </div>
                                <span class="text-error text-danger cac_certificate_error"></span>

                              </div>
                              <div class="form-group col-md-6">
                                <h6 class="text-center">CAC Certificate preview</h6>
                                <div id="previewCAC">

                                </div>
                              </div>
                            </div>
                          @endif
                          <button type="button" class="btn btn-primary" onclick="stepper.next()">Next</button>
                        </div>
                        <div id="customersupport-part" class="content" role="tabpanel" aria-labelledby="customersupport-part-trigger">
                          <h3 class="text-center">Customer Support Info</h3>
                          <div class="row">
                            <div class="col-md-4 form-group">
                              <label for="customer_support_email">Customer Support Email</label>
                              <input type="email" name="customer_support_email" id="customer_support_email" class="form-control">
                              <span class="text-error text-danger customer_support_email_error"></span>
                            </div>
                            <div class="col-md-4 form-group">
                              <label for="customer_support_phone_no">Customer Support Phone No (Call)</label>
                              <input type="tel" name="customer_support_phone_no" id="customer_support_phone_no" class="form-control">
                              <span class="text-error text-danger customer_support_phone_no_error"></span>
                            </div>
                            <div class="col-md-4 form-group">
                              <label for="customer_support_whatsapp">Customer Support Whatsapp No</label>
                              <input type="tel" name="customer_support_whatsapp" id="customer_support_whatsapp" class="form-control">
                              <span class="text-error text-danger customer_support_whatsapp_error"></span>
                            </div>
                           
                          </div>
                          <hr>
                          <p class="text-warning"><i  class="fa fa-warning fa-1x"></i> Please make your the form is correctly filed as there will be no room for editing later thanks!</p>
                          <div class="row">
                            <div class="col-md-6">
                              <button type="button" class="btn btn-primary" onclick="stepper.previous()">Previous</button>

                            </div>
                            <div class="col-md-6 text-right">
                              <button type="submit" class="btn btn-primary">Submit</button>

                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                   
                  </form>
                </div>
              </div>
        </div>
        
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection
@section('scripts')
  <script>
    // BS-Stepper Init
    document.addEventListener('DOMContentLoaded', function () {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
      })

      function readURLS(input,holder,size){
        if(input.files && input.files[0]){
          reader = new FileReader();
          reader.onload = function(e){
            $(holder).html('<img src="'+e.target.result+'" alt="file" class="img-fluid" width="'+size+'">');
          }
          reader.readAsDataURL(input.files[0]);
        }
      }
  
  $(function(){
    $('#shop_logo').on('change', function(e){
      e.preventDefault()
      let holder = '#previewShopLogo';
      let size = 108;
      readURLS(this, holder,size);
    });
    $('#cac_certificate').on('change', function(e){
      e.preventDefault();
      let holder = '#previewCAC';
      let size = 200;
      readURLS(this, holder,size);
    });

    $('#bizInfoForm').on('submit', function(e){
    e.preventDefault();
    let form = this;
    $.ajax({
        url:$(form).attr('action'),
        method:$(form).attr('method'),
        data:new FormData(form),
        cache:false,
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
            $('#bizInfoForm')[0].reset();
            Swal.fire(
              'Success',
              data.msg,
              'success'
            );
            setTimeout(() => {
              window.location = "{{ route('seller.vendor.dashboard') }}";
            }, 5000);

          }
        }
    })
  });



    //user town is the selected
    function get_city(selected){
        if(typeof selected === 'undefined'){
            let selected = '';
        }
        // var state_name = "Bayelsa";
        // console.log(state_name);
        let state_name = $('#shop_state').val();
        let url = "{{ route('seller.get.state.city.biz') }}";
        let _token = "{{ csrf_token() }}";
        $.post(url, {selected:selected,state_name:state_name, _token:_token}, function(data){
            $('#shop_city').html(data);
        })
        
      }

      $('select[name="shop_state"]').on('change', function(){
            get_city();
      });




  });
  </script>
@endsection