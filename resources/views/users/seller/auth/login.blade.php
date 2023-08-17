@extends('layouts.authhead')

@section('auth')
<section class="login-page dark-mode">
    <div class="login-box">
      <!-- /.login-logo -->
      <div class="card card-outline card-primary">
        <div class="card-header text-center">
          <a href="" class="h1"><b>MJStore</b> Vendor Panel</a>
        </div>
        <div class="card-body">
          <p class="login-box-msg">Sign in to start your session</p>
          @include('inc.messages')
          <form action="{{ route('seller.vendor.process.login') }}" method="post">
            @csrf
            @method('POST')
            <div class="input-group mb-3">
              <input type="text" name="manager_email" value="{{ old('manager_email') }}" class="form-control" placeholder="Email">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" name="password" class="form-control" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="remember">
                  <label for="remember">
                    Remember Me
                  </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
              </div>
              <!-- /.col -->
            </div>
          </form>
    
    
          <p class="d-flex justify-content-between mb-1 mt-3">
            <a href="#">I forgot my password</a>
            <a href="{{ route('seller.vendor.register') }}">Don't have account? Register</a>
          </p>
          
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
</section>
@endsection