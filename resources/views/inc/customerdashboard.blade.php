@php
      $title = basename($_SERVER['PHP_SELF'], '.blade.php');
      $title = explode('-', $title);
      $title2 =$title[1];
  @endphp
<div class="col-12 col-lg-3">
    <div class="my-account-navigation mb-50">
        <ul>
            <li class="{{ (($title2=='dashboard')?' active':'') }}"><a href="{{ route('user.customer.dashboard') }}">Dashboard</a></li>
            <li class="{{ (($title2=='orders')?' active':'') }}"><a href="{{ route('user.customer.orders') }}">Orders</a></li>
            <li class="{{ (($title2=='wishlist')?' active':'') }}"><a href="{{ route('user.customer.wishlist') }}">Wishlist</a></li  >
            <li class="{{ (($title2=='addresses')?' active':'') }}"><a href="{{ route('user.customer.addresses') }}">Addresses</a></li>
            <li class="{{ (($title2=='profile')?' active':'') }}"><a href="{{ route('user.customer.profile') }}">Profile</a></li>
            <li class="{{ (($title2=='logout')?' active':'') }}"><a href="{{ route('user.customer.logout') }}">Logout</a></li>
        </ul>
    </div>
</div>