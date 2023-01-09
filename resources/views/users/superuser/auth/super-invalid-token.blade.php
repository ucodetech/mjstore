@extends('layouts.authhead')

@section('auth')
<section class="login-page dark-mode">
    <div class="login-box">
      <!-- /.login-logo -->
      <div class="card card-outline card-primary">
        <div class="card-header text-center">
          <a href="" class="h1"><b>MJStore</b> Admin Panel</a>
        </div>
        <div class="card-body">
          <p class="login-box-msg">Invalid Token Please enter your register email to get a fresh token! registered email is {{ $email }}</p>
          @include('inc.messages')
          <form action="" method="post">
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
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
</section>
@endsection