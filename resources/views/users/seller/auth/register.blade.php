@extends('layouts.authhead')
@section('auth')
<style>
  .m-img-holder{
    height: 100px !important;
    width: 30% !important;
   
}
</style>
<section class="register-page dark-mode mt-5 mb-5">
    <div class="register-box">
      <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="" class="h3"><b>MJStore</b> Vendor Panel</a>

            <div class="d-flex justify-content-center">
              <div class="m-img-holder  rounded-circle bg-light" id="previewMgtProfile">
                <img src="{{ asset('profilePhotos/sellerProfile/default.png') }}" alt="default photo" class="img-fluid img-circle" style="height: 100px; width:100%;border:2px double rgba(2, 77, 77, 0.795)">
              </div>
            </div>
        </div>
        <div class="card-body">
    
          <form action="{{ route('seller.vendor.register.process') }}"  method="post" enctype="multipart/form-data" id="sellerRegisterForm">
            @csrf
            @method('POST')
          
            <div class="form-group d-flex justify-content-center">
              <input type="file" class="form-control d-none" name="manager_profile_photo" id="manager_profile_photo">

              <label for="manager_profile_photo" class="btn btn-sm btn-outline-primary text-center">Profile Photo</label>

              <span  class="text-danger text-error manager_profile_photo_error"></span>
            </div>
            <div class="form-group">
              <span class="shop_name_check"></span>
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="shop_name" id="shop_name" value="{{ old('shop_name') }}" placeholder="shop name">
                <div class="input-group-append">
                  <div class="input-group-text" id="spinner">
                    <span class="fa fa-search"></span>
                  </div>
                </div>
              </div>
              <span class="text-danger text-error shop_name_error"></span>
            </div>
            <div class="form-group">
              <select name="business_options" id="business_options" class="form-control">
                  <option value="" class="text-muted">Select Business Option</option>
                  @php
                      $bizs = [0=>'unregistered business', 1=>'registered business'];
                  @endphp
                   @foreach ($bizs as $key=>$biz)
                   <option value="{{ $key }}">{{ Str::ucfirst($biz) }}</option>
                  @endforeach
              </select>
              <span class="text-error text-danger business_options_error"></span>
            </div>
           <div class="form-group">
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="manager_fullname" id="manager_fullname" value="{{ old('manager_fullname') }}" placeholder="Manager Fullname">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <span class="text-error text-danger manager_fullname_error"></span>
           </div>
           <div class="form-group">
            <div class="input-group mb-3">
              <input type="email" class="form-control" name="manager_email" value="{{ old('manager_email') }}" placeholder="Manager Email">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <span class="text-danger text-error manager_email_error"></span>
           </div>
            <div class="form-group">
              <div class="input-group mb-3">
                <input type="tel" class="form-control" name="manager_tel"  id="manager_tel" value="{{ old('manager_tel') }}" placeholder="Manager Phone Number">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-phone"></span>
                  </div>
                </div>
              </div>
              <span class="text-danger text-error manager_tel_error"></span>
            </div>
            <div class="form-group">
              <div class="input-group mb-3">
                <input type="password" class="form-control" name="password"  id="password" placeholder="Password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <span class="text-danger text-error password_error"></span>
            </div>
            <div class="form-group">
              <div class="input-group mb-3">
                <input type="password" class="form-control" name="verify_password" id="verify_password" placeholder="Retype password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <span class="text-danger text-error verify_password_error"></span>
            </div>
            <div class="row">
              {{-- <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="is_superuser" name="is_superuser" value="1"> 
                  <label for="is_superuser">
                    Is Superuser
                  </label>
                </div>
              </div> --}}
              <!-- /.col -->
              <div class="col-6">
                <button type="submit" id="sellerRegBtn" class="btn btn-primary btn-block">Register</button>
              </div>
              <!-- /.col -->
            </div>
            <div class="social-auth-links text-left text-info" id="msg">
                
              </div> 
          </form>
    
         
    
          <p class="d-flex justify-content-between mb-1">
            <a href="{{ route('seller.vendor.login') }}">Already have an account? Login</a>
          </p>
          
        </div>
        <!-- /.form-box -->
      </div><!-- /.card -->
    </div>
    <!-- /.register-box -->
</section>
@endsection

@section('scripts')
 <script>
  function readMgtUrl(input){
    if(input.files && input.files[0]){
      let reader = new FileReader();
      reader.onload = function(e){
          $('#previewMgtProfile').html('<label for="manager_profile_photo"><img src="'+e.target.result+'" alt="default photo" class="img-fluid img-circle" style="height: 100px; width:100%;border:2px double rgba(2, 77, 77, 0.795);cursor:pointer"></label>');
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
    $(function(){
      $('#manager_profile_photo').on('change', function(e){
        e.preventDefault();
        readMgtUrl(this);
      })
        $('#shop_name').keyup(function(e){
          e.preventDefault();
          let shopname = $(this).val();
          let url = "{{ route('seller.vendor.check.shopname') }}";
          let _token = "{{ csrf_token() }}";
            // $(this).find('span.shop_name_check').text('');
          if(shopname.length > 0){
             $('#spinner').html('<i class="fa fa-spinner"></i>');
              $.post(url, {shopname:shopname, _token:_token}, function(data){
                
                  if(data.code == 0){
                    $('.shop_name_check').removeClass('text-success');
                    $('.shop_name_check').addClass('text-warning');
                    $('.shop_name_check').text(data.error);
                    $('#spinner').html('<i class="fa fa-times-circle text-danger"></i>');
                  }else{
                    $('.shop_name_check').removeClass('text-warning');
                    $('.shop_name_check').addClass(' text-success');
                    $('.shop_name_check').text(data.msg);
                    $('#spinner').html('<i class="fa fa-check-circle text-success"></i>');
                  }
              
               });
          }else{
            $('#spinner').html('<i class="fa fa-search"></i>');
            $('.shop_name_check').text('');
          }
        });

        //submit form register form
        $('#sellerRegisterForm').on('submit', function(e){
          e.preventDefault();
          let form = this;
          $.ajax({
            url:$(form).attr('action'),
            method:$(form).attr('method'),
            data:new FormData(form),
            cache:false,
            processData:false,
            contentType:false,
            beforeSend:function(){
              $(form).find('span.text-error').text('');
              $('#sellerRegBtn').html('<span class="fa fa-spinner fa-1x"></span>Processing...');
            },
            success:function(data){
              if(data.code == 0 ){
                $.each(data.error, function(prefix, val){
                  $(form).find('span.'+prefix+'_error').text(val[0]);
                });
                $('#sellerRegBtn').html('Register');

              }else{
                  $('#msg').html(data.msg);
                  $('#sellerRegisterForm')[0].reset();
                  $('#sellerRegBtn').html('<span class="fa fa-spinner fa-1x"></span>Redirecting...');
                  setTimeout(() => {
                   window.location = "{{ route('seller.vendor.registeration.success') }}";

                  }, 3000);
              }
            }
          })
        })

  })
 </script>
@endsection