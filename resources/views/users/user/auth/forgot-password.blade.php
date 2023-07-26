@extends('layouts.app')

@section('frontcontent')
{{-- @include('inc.bread-front') --}}

     <!-- Login Area -->
     <div class="bigshop_reg_log_area section_padding_100_50 pt-3">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="login_form mb-50">
                        <img src="https://media.istockphoto.com/id/497347644/photo/hand-pressing-register-now.jpg?s=612x612&w=0&k=20&c=XzXNw7_71cx23yPATWsSnYwGytZW-KU3eTpy3WCFQgw=" alt="">
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="login_form mb-50">
                        <h5 class="mb-3">Forgot Password</h5>
                        <form action="{{ route('user.user.register.process') }}" method="post" id="registerUserForm">
                            @csrf
                            @method('POST')
                           
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                <span class="text-danger text-error email_error"></span>
                            </div>
                            <button type="submit" class="btn btn-info btn-sm">Request</button>
                        </form>                        
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
@endsection