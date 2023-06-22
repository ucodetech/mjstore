@extends('layouts.usersapp')

@section('frontcontent')
@include('inc.bread-user')
@php
    if(Auth::check()){
        $customer = auth()->user();
    }
@endphp
   <!-- My Account Area -->
   <section class="my-account-area section_padding_100_50">
    <div class="container">
        <div class="row">
            @include('inc.customerdashboard')
            <div class="col-12 col-lg-9">
                <div class="my-account-content mb-50">
                    {{-- contents --}}
                    <h5 class="mb-3">Account Details</h5>
                    @php
                       $phone =  explode(',',$customer->phone_number);
                    @endphp
                    <form action="{{ route('user.customer.update.details') }}" method="post" id="updateDetailsForm">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="fullname">Fullname</label>
                                    <input type="text" class="form-control" name="fullname" id="fullname" placeholder="" value="{{ $customer->fullname }}">
                                    <span class="text-danger text-error fullname_error"></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="phone_number">Phone No.</label>
                                    <input type="tel" class="form-control" name="phone_number" id="phone_number" placeholder="" value="{{ $phone[0] }}">
                                    <span class="text-danger text-error phone_number_error"></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="phone_no_2">Phone No (2) <small class="text-muted">Add a second Phone No in case primary phone No fails</small>.</label>
                                    <input type="tel" class="form-control" name="phone_no_2" id="phone_no_2" placeholder="" value="{{ ((count($phone)>1)? $phone[1]:'') }}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="displayName">Display Name *</label>
                                    <input type="text" class="form-control" placeholder="" value="{{ $customer->username }}" readonly disabled>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="emailAddress">Email Address</label>
                                    <input type="email" class="form-control" placeholder="" value="{{ $customer->email }}" readonly disabled>
                                </div>
                            </div>
                          
                            <div class="col-12">
                                <button type="submit" id="updateDetailsBtn" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
                
                {{-- update password --}}
                <div class="my-account-content mb-50">
                    <div class="row">
                        <div class="col-md-6">
                            {{-- contents --}}
                    <h5 class="mb-3">Account Password Details</h5>
                    <small class="text-danger text-center">Once You change your current password the system will log you out for security reasons! kindly relogin with the new password created!</small>
                    <form action="{{ route('user.customer.update.password') }}" method="post" id="passwordUpdateForm">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="currentPass">Current Password </label>
                                    <input type="password" class="form-control" name="currentPass" id="currentPass">
                                    <span class="text-error text-danger currentPass_error"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="newPass">New Password </label>
                                    <input type="password" name="newPass" class="form-control" id="newPass">
                                    <span class="text-error text-danger newPass_error"></span>

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="confirmPass">Confirm New Password</label>
                                    <input type="password" class="form-control" name="confirmPass" id="confirmPass">
                                    <span class="text-error text-danger confrimPass_error"></span>

                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" id="updatePasswordBtn" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </form>
                        </div>
                        <div class="col-md-6">
                            
                            {{-- contents --}}
                            <h5 class="mb-3">Account Photo Details</h5>
                            <span class="text-info">Click on the image to select new photo for update</span>
                            <div class="text-center">
                               <div id="profilePhotoPreview">
                                <label for="profile_photo" style="cursor:pointer" title="Click to select new photo">
                                    <img src="{{ asset('profilePhotos/userProfile/'.$customer->photo) }}" alt="{{ $customer->fullname }}" class="shadow-lg border-4 mb-1"       style="border-radius: 50%; width:200px !important; height:200px !important;">
                                </label>
                               </div>
                               <form action="{{ route('user.customer.update.profile.photo') }}" method="POST" enctype="multipart/form-data" id="profilePhotoForm">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="col-12">
                                        <input type="file" name="profile_photo" id="profile_photo" class="d-none">
                                        <span class="text-danger text-error profile_photo_error"></span>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" id="updatePhotoBtn" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- My Account Area -->

@endsection

@section('frontscripts')
  <script>
        function readProfileUrl(input){
            if(input.files && input.files[0]){
               let reader = new FileReader();
                reader.onload = function(e){
                    $('#profilePhotoPreview').html('<label for="profile_photo" style="cursor:pointer"><img src="'+e.target.result+'" alt="profile photo" class="img-fluid img-circle" width="200"></label>');
                }
                reader.readAsDataURL(input.files[0])
            }
        }

        $(function(){

            $('#profile_photo').on('change', function(e){
                readProfileUrl(this);
            })

            $('#profilePhotoForm').on('submit', function(e){
                e.preventDefault();
                let form = this;
                $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data: new FormData(form),
                    processData:false,
                    cache:false,
                    contentType:false,
                    beforeSend:function(){
                        $(form).find('span.text-error').text('');
                        $('#updatePhotoBtn').html('<1 class="fa fa-spinner fa-spin"></1> Processing...')

                    },
                    success:function(data){
                        if(data.code == 0){
                            $.each(data.error, function(prefix, val){
                                $(form).find('span.'+prefix+'_error').text(val[0]);
                            })
                            $('#updatePhotoBtn').html('<i class="fa fa-spinner fa-spin"></i> Processing...')

                        }else if(data.code == 3){
                            toastr.error(data.uperror);
                            $('#updatePhotoBtn').html('Update')

                        }else{
                            toastr.success(data.msg);
                             $('#updatePhotoBtn').html('Update')

                        }
                    }
                })
            })


            $('#passwordUpdateForm').on('submit', function(e){
                e.preventDefault();
                let form = this;
                $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data: new FormData(form),
                    processData:false,
                    cache:false,
                    contentType:false,
                    beforeSend:function(){
                        $(form).find('span.text-error').text('');
                        $('#updatePasswordBtn').html('<i class="fa fa-spinner fa-spin"></i> Processing...')

                    },
                    success:function(data){
                        if(data.code == 0){
                            $.each(data.error, function(prefix, val){
                                $(form).find('span.'+prefix+'_error').text(val[0]);
                            })
                            $('#updatePasswordBtn').html('Save Changes')
                        }else if(data.code == 3){
                            toastr.error(data.cerror);
                            $('#updatePasswordBtn').html('Save Changes')
                        }else if(data.code == 4){
                            toastr.error(data.cerror);
                            $('#updatePasswordBtn').html('Save Changes')
                        }else{
                            toastr.success(data.msg);
                            $('#updatePasswordBtn').html('Save Changes')
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                    }
                })
            })



            $('#updateDetailsForm').on('submit', function(e){
                e.preventDefault();
                let form = this;
                $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data: new FormData(form),
                    processData:false,
                    cache:false,
                    contentType:false,
                    beforeSend:function(){
                        $(form).find('span.text-error').text('');
                        $('#updateDetailsBtn').html('<span class="fa fa-rotate-180"></span> Processing...')
                    },
                    success:function(data){
                        if(data.code == 0){
                            $.each(data.error, function(prefix, val){
                                $(form).find('span.'+prefix+'_error').text(val[0]);
                            })
                            $('#updateDetailsBtn').html('Save Changes')

                        }else if(data.code == 3){
                            $('#updateDetailsBtn').html('Save Changes')
                            toastr.error(data.perror);
                        }
                        else{
                            toastr.success(data.msg);
                            $('#updateDetailsBtn').html('Save Changes')

                        }
                    }
                })
            })






        })
  </script>
@endsection
