@extends('layouts.authhead')
@section('auth')
<section class="register-page dark-mode">
    <div class="register-box">
      <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="" class="h1"><b>MJStore</b> Admin Panel</a>
        </div>
        <div class="card-body">
          <p class="login-box-msg">Register a new membership</p>
    
          <form action="{{ route('superuser.super.process.register') }}"  method="post">
            @csrf
            @method('POST')
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="fullname" value="{{ old('fullname') }}" placeholder="Full name">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="email" class="form-control" name="super_email" value="{{ old('super_email') }}" placeholder="Email">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
                <input type="tel" class="form-control" name="super_phone_no" value="{{ old('super_phone_no') }}" placeholder="Phone Number">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-phone"></span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <select name="role" id="role" class="form-control">
                    <option value="" class="text-secondary">Select Role</option>
                    @php
                        $roles = ['superuser', 'editor'];
                    @endphp
                     @foreach ($roles as $role)
                     <option value="{{ $role }}">{{ $role }}</option>
                    @endforeach
                </select>
              </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" name="password" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
            </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" name="verify_password" placeholder="Retype password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                  <label for="agreeTerms">
                   I agree to the <a href="#">terms</a>
                  </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Register</button>
              </div>
              <!-- /.col -->
            </div>
            <div class="social-auth-links text-center">
                @include('inc.messages')
              </div> 
          </form>
    
         
    
          {{-- <a href="login.html" class="text-center">I already have a membership</a> --}}
        </div>
        <!-- /.form-box -->
      </div><!-- /.card -->
    </div>
    <!-- /.register-box -->
</section>
@endsection