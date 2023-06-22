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
                        <h3 class="mb-3 text-center">Success</h3>
                         <div class="text-center">
                            <i class="fa fa-check-circle fa-4x text-success"></i>  
                            <h3>Registeration Completed Successfully</h3>
                            <p>Please check your registered email for verification </p>  
                            <a href="https://mail.google.com/mail/u/0/?tab=rm#inbox" target="_blank" class="btn btn-danger">Gmail App</a>
                        </div>                       
                         
                         
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Area End -->

@endsection
