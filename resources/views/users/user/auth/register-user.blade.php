@extends('layouts.app')

@section('frontcontent')
@include('inc.bread-front')

     <!-- Login Area -->
     <div class="bigshop_reg_log_area section_padding_100_50">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="login_form mb-50">
                        <img src="https://media.istockphoto.com/id/497347644/photo/hand-pressing-register-now.jpg?s=612x612&w=0&k=20&c=XzXNw7_71cx23yPATWsSnYwGytZW-KU3eTpy3WCFQgw=" alt="">
                    </div>
                </div>
               
                <div class="col-12 col-md-6">
                    <div class="login_form mb-50">
                        <h5 class="mb-3">Register</h5>

                        <form action="{{ route('user.user.register.process') }}" method="post" id="registerUserForm">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <input type="text" class="form-control" name="fullname" id="fullame" placeholder="Full Name">
                                <span class="text-danger text-error fullname_error"></span>
                            </div>
                            <div class="form-group">
                                <input type="tel" name="phone_number" id="phone_number" class="form-control" placeholder="Phone No" min="7" max="15">
                                <span class="text-danger text-error phone_number_error"></span>
                                
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                <span class="text-danger text-error email_error"></span>
                            </div>
                            
                            {{-- <div class="form-group">
                                @php
                                    $options = ['customer'];
                                @endphp
                                <select name="role" id="role" class="form-control mb-2">
                                    <option value="">---Select Role---</option>
                                    @foreach ($options as $role)
                                        <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                                &nbsp;<span class="text-danger text-error role_error"></span>
                            </div> --}}
                            <div class="form-group">
                                <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                                <span class="text-danger text-error username_error"></span>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                <span class="text-danger text-error password_error"></span>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="comfirm_password" id="comfirm_password" placeholder="Repeat Password">
                                <span class="text-danger text-error comfirm_password_error"></span>
                            </div>
                            <button type="submit" id="registerBtn" class="btn btn-primary btn-sm">Register</button>
                        </form>

                        <div class="forget_pass mt-15">
                            Already have an account?  <a href="{{ route('user.user.login') }}"> <i class="fa fa-sign-in-alt"></i> Sign In</a>
                         </div>
                         <hr class="invisible">
                         @include('inc.messages')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Area End -->

@endsection
@section('frontscripts')
    <script src="{{ asset('shopjs/userregister.js') }}"></script>

    <script>
    </script>
@endsection