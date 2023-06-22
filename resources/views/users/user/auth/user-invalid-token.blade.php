
@extends('layouts.app')

@section('frontcontent')
@include('inc.bread-front')

     <!-- Login Area -->
     <div class="bigshop_reg_log_area section_padding_100_50">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="login_form mb-50">
                        <img src="https://storage.googleapis.com/desktop-client-assets/images/success.png" alt="">
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="login_form mb-50">
                        <h3 class="mb-3 text-center">Invalid Token Please enter your register email to get a fresh token! registered email is {{ $email }}</h3>
                         <div class="text-center">
                          @include('inc.messages')
                          <form action="" method="post">
                            @csrf
                            @method('POST')
                            <div class="input-group mb-3">
                              <input type="email" class="form-control" placeholder="Email">
                              <div class="input-group-append">
                                <div class="input-group-text">
                                  <span class="fas fa-envelope"></span>
                                </div>
                              </div>
                            </div>
                            
                        </form>   
                        </div>                       
                         
                         
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Area End -->

@endsection

@endsection