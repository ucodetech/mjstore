@extends('layouts.app')

@section('frontcontent')
@include('inc.bread-front')

     <!-- Login Area -->
     <div class="bigshop_reg_log_area section_padding_100_50">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="login_form mb-50">
                        <h5 class="mb-3">Login</h5>

                        <form action="{{ route('user.user.login.process') }}" method="post">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <input type="text" class="form-control" name="login" id="login" placeholder="Email or Username" value="{{ old('login') }}">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                            </div>
                            <div class="form-check">
                                <div class="custom-control custom-checkbox mb-3 pl-1">
                                    <input type="checkbox" class="custom-control-input" id="customChe">
                                    <label class="custom-control-label" for="customChe">Remember me for this computer</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Login</button>
                        </form>
                        <!-- Forget Password -->
                        <div class="forget_pass mt-15">
                            <a href="#">Forget Password?</a>
                        </div>
                        <div class="forget_pass mt-15">
                           Don't have an account?  <a href="{{ route('user.user.register') }}"><i class="fa fa-user-plus"></i> Sign Up</a>
                        </div>
                        <hr class="invisible">
                        @include('inc.messages')
                        
                    </div>

                    
                </div>

                <div class="col-12 col-md-6">
                    <div class="login_form mb-50">
                        <img src="https://thumbs.dreamstime.com/b/vector-illustration-isolated-white-background-login-button-icon-login-icon-button-127001338.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Area End -->

@endsection
@section('frontscripts')

    <script>
    </script>
@endsection