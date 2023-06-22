@extends('layouts.usersapp')

@section('frontcontent')
@include('inc.bread-user')

   <!-- My Account Area -->
   <section class="my-account-area section_padding_100_50">
    <div class="container">
        <div class="row">
            @include('inc.customerdashboard')
            <div class="col-12 col-lg-9">
                <div class="my-account-content mb-50">
                   
                </div>
           
            </div>
           
            
          
            
          
        </div>
    </div>
</section>
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
  
  </script>
@endsection