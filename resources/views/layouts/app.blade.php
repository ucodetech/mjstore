<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- title --}}
    @php
        $title = basename($_SERVER['PHP_SELF'], '.blade.php');
        $title = explode('-', $title);
        $title = ucfirst($title[0]);
    @endphp
    <title>{{ config('app.name', 'Laravel') }}| {{ (($title == 'Index.php')? 'Index':((is_numeric($title))? 'Product': $title)) }}</title>
    

    <!-- Favicon  -->
    <link rel="icon" href="{{ asset('assets_front/img/core-img/favicon.ico')}}">

    <link rel="stylesheet" href="{{ asset('assets_front/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets_front/css/classy-nav.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets_front/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets_front/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{ asset('assets_front/css/animate.css')}}">
    <link rel="stylesheet" href="{{ asset('assets_front/css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets_front/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{ asset('assets_front/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets_front/css/icofont.min.css')}}">
    
    <link rel="stylesheet" href="{{ asset('assets_back/plugins/sweetalert2/sweetalert2.css')}}">
    <link rel="stylesheet" href="{{ asset('assets_back/plugins/toastr/toastr.css')}}">
    <link rel="stylesheet" href="{{ asset('assets_back/plugins/summernote/summernote-bs4.min.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.4.0/css/all.min.css" integrity="sha512-eBNnVs5xPOVglLWDGXyZnZZ2K2ixXhR/3aECgCpFnW2dGCd/yiqXZ6fcB3BubeA91kM6NX234b6Wrah8RiYAPA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets_front/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('shopcss/shop.css') }}">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Oswald:wght@300;400&family=Passion+One&display=swap" rel="stylesheet">
    <style>
        *{
          /* font-family: 'Fredoka One', cursive; */
          font-family: 'Oswald', sans-serif; 
          /* font-family: 'Passion One', cursive;  */
        }
        html{
          /* font-family: 'Fredoka One', cursive;
          font-family: 'Oswald', sans-serif; */
          font-family: 'Passion One', cursive;
        }
      </style>
</head>
<body>
   <!-- Preloader -->
   <div id="preloader">
    <div class="spinner-grow" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
@php
    $cart = \Gloudemans\Shoppingcart\Facades\Cart::instance('shopping');
   
@endphp
  <!-- Header Area -->
  <header class="header_area">
    <!-- Top Header Area -->
    <div class="top-header-area">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-6">
                    <div class="welcome-note">
                        <span class="popover--text" data-toggle="popover"
                            data-content="Welcome to Mummy Joy Store."><i
                                class="icofont-info-square"></i></span>
                        <span class="text">Welcome to Mummy Joy Store.</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="language-currency-dropdown d-flex align-items-center justify-content-end">
                        <!-- Language Dropdown -->
                        <div class="language-dropdown">
                            <div class="dropdown">
                                <a class="btn btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenu1"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    English
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                                    <a class="dropdown-item" href="#">Bangla</a>
                                    <a class="dropdown-item" href="#">Arabic</a>
                                </div>
                            </div>
                        </div>

                        <!-- Currency Dropdown -->
                        <div class="currency-dropdown">
                            <div class="dropdown">
                                <a class="btn btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenu2"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Seller Account
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                    <a class="dropdown-item" href="#"> <i class="fa fa-user-plus"></i> Create Account</a>
                                    <a class="dropdown-item" href="#"> <i class="fa fa-sign-in-alt"></i> Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        @include('inc.messages')
    </div>
    <!-- Main Menu -->
    <div class="bigshop-main-menu">
        <div class="container">
            <div class="classy-nav-container breakpoint-off">
                <nav class="classy-navbar" id="bigshopNav">

                    <!-- Nav Brand -->
                    <a href="{{ route('home') }}" class="nav-brand"><img src="{{ asset('assets_front/img/core-img/logo.png')}}" alt="logo"></a>

                    <!-- Toggler -->
                    <div class="classy-navbar-toggler">
                        <span class="navbarToggler"><span></span><span></span><span></span></span>
                    </div>

                    <!-- Menu -->
                    <div class="classy-menu">
                        <!-- Close -->
                        <div class="classycloseIcon">
                            <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                        </div>

                        <!-- Nav -->
                        <div class="classynav">
                            <ul>
                                <li><a href="{{ route('home') }}">Home</a></li>
                                {{-- <li><a href="{{ route('shop') }}">Shop</a></li> --}}
                                <li><a href="#">Pages</a>
                                    <div class="megamenu">
                                        <ul class="single-mega cn-col-4">
                                            <li><a href="about-us.html">- About Us</a></li>
                                            <li><a href="faq.html">- FAQ</a></li>
                                            <li><a href="contact.html">- Contact</a></li>
                                        </ul>
                                        
                                    </div>
                                </li>
                                <li><a href="#">Blog</a></li>
                                <li><a href="contact.html">Contact</a></li>
                                <li>
                                    @if (Auth::check())
                                        <a href="{{ route('user.customer.dashboard') }}">Dashboard</a>
                                    @else
                                        <a href="{{ route('user.user.login') }}">Login</a>
                                    @endif    
                                </li>
                                
                            </ul>
                        </div>
                    </div>

                    <!-- Hero Meta -->
                    <div class="hero_meta_area ml-auto d-flex align-items-center justify-content-end">
                        <!-- Search -->
                        <div class="search-area">
                            <div class="search-btn"><i class="icofont-search"></i></div>
                            <!-- Form -->
                            <div class="search-form">
                                <input type="search" class="form-control" placeholder="Search">
                                <input type="submit" class="d-none" value="Send">
                            </div>
                        </div>

                        <!-- Wishlist -->
                        <div class="wishlist-area">
                            <a href="{{ route('user.customer.wishlist') }}" class="wishlist-btn"><i class="icofont-heart"></i></a>
                        </div>

                        @include('inc.cart_area')
                        
                        <!-- Account -->
                        <div class="account-area">
                            @if (Auth::check())
                            <div class="user-thumbnail">
                                <img src="{{ asset('profilePhotos/userProfile') .'/'. auth()->user()->photo }}" alt="{{  auth()->user()->fullname  }}" class="img-fluid img-thumbnail">
                            </div>
                            <ul class="user-meta-dropdown">
                                <li class="user-title"><span>Hello,</span> {{ auth()->user()->fullname  }}</li>
                                <li><a href="{{ route('user.customer.dashboard') }}">Dashboard</a></li>
                                <li><a href="{{ route('user.customer.orders') }}">Orders List</a></li>
                                <li><a href="{{ route('user.customer.wishlist') }}">Wishlist</a></li>
                                <li><a href="{{ route('user.customer.logout') }}"><i class="icofont-logout"></i> Logout</a></li>
                            </ul>
                            @else
                            <div class="user-thumbnail">
                                <img src="{{ asset('profilePhotos/userProfile/user.png')}}" alt="" class="img-fluid img-thumbnail">
                            </div>
                            <ul class="user-meta-dropdown">
                                <li><a href="{{ route('user.user.login') }}"> <i class="fa fa-sign-in-alt"></i> Sign In</a></li>
                                <li><a href="{{ route('user.user.register') }}"><i class="fa fa-user-plus"></i> Sign Up</a></li>
                                
                            </ul>
                            @endif
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- Header Area End -->
    @yield('frontcontent')
 <!-- Footer Area -->
 <footer class="footer_area section_padding_100_0">
    <div class="container">
        <div class="row">
            <!-- Single Footer Area -->
            <div class="col-12 col-sm-6 col-md-5 col-lg-4 col-xl-3">
                <div class="single_footer_area mb-100">
                    <div class="footer_heading mb-4">
                        <h6>Contact Us</h6>
                    </div>
                    <ul class="footer_content">
                        <li><span>Address:</span> Lords, London, UK - 1259</li>
                        <li><span>Phone:</span> 002 63695 24624</li>
                        <li><span>FAX:</span> 002 78965 369552</li>
                        <li><span>Email:</span> support@example.com</li>
                    </ul>
                    <div class="footer_social_area mt-15">
                        <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                        <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                        <a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a>
                        <a href="#"><i class="fa fa-rss" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>

            <!-- Single Footer Area -->
            <div class="col-12 col-sm-6 col-md col-lg-4 col-xl-2">
                <div class="single_footer_area mb-100">
                    <div class="footer_heading mb-4">
                        <h6>Information</h6>
                    </div>
                    <ul class="footer_widget_menu">
                        <li><a href="#"><i class="icofont-rounded-right"></i> Your Account</a></li>
                        <li><a href="#"><i class="icofont-rounded-right"></i> Free Shipping Policy</a></li>
                        <li><a href="#"><i class="icofont-rounded-right"></i> Your Cart</a></li>
                        <li><a href="#"><i class="icofont-rounded-right"></i> Return Policy</a></li>
                        <li><a href="#"><i class="icofont-rounded-right"></i> Free Coupon</a></li>
                        <li><a href="#"><i class="icofont-rounded-right"></i> Delivary Info</a></li>
                    </ul>
                </div>
            </div>

            <!-- Single Footer Area -->
            <div class="col-12 col-sm-6 col-md col-lg-4 col-xl-2">
                <div class="single_footer_area mb-100">
                    <div class="footer_heading mb-4">
                        <h6>Account</h6>
                    </div>
                    <ul class="footer_widget_menu">
                        <li><a href="#"><i class="icofont-rounded-right"></i> Product Support</a></li>
                        <li><a href="#"><i class="icofont-rounded-right"></i> Terms &amp; Conditions</a></li>
                        <li><a href="#"><i class="icofont-rounded-right"></i> Help</a></li>
                        <li><a href="#"><i class="icofont-rounded-right"></i> Payment Method</a></li>
                        <li><a href="#"><i class="icofont-rounded-right"></i> Affiliate Program</a></li>
                        <li><a href="#"><i class="icofont-rounded-right"></i> Privacy Policy</a></li>
                    </ul>
                </div>
            </div>

            <!-- Single Footer Area -->
            <div class="col-12 col-sm-6 col-md-5 col-lg-4 col-xl-2">
                <div class="single_footer_area mb-100">
                    <div class="footer_heading mb-4">
                        <h6>Support</h6>
                    </div>
                    <ul class="footer_widget_menu">
                        <li><a href="#"><i class="icofont-rounded-right"></i> Payment Method</a></li>
                        <li><a href="#"><i class="icofont-rounded-right"></i> Help</a></li>
                        <li><a href="#"><i class="icofont-rounded-right"></i> Product Support</a></li>
                        <li><a href="#"><i class="icofont-rounded-right"></i> Terms &amp; Conditions</a></li>
                        <li><a href="#"><i class="icofont-rounded-right"></i> Privacy Policy</a></li>
                        <li><a href="#"><i class="icofont-rounded-right"></i> Affiliate Program</a></li>
                    </ul>
                </div>
            </div>

            <!-- Single Footer Area -->
            <div class="col-12 col-md-7 col-lg-8 col-xl-3">
                <div class="single_footer_area mb-50">
                    <div class="footer_heading mb-4">
                        <h6>Join our mailing list</h6>
                    </div>
                    <div class="subscribtion_form">
                        <form action="#" method="post">
                            <input type="email" name="mail" class="form-control mail"
                                placeholder="Your E-mail Addrees">
                            <button type="submit" class="submit"><i class="icofont-long-arrow-right"></i></button>
                        </form>
                    </div>
                </div>
                <div class="single_footer_area mb-100">
                    <div class="footer_heading mb-4">
                        <h6>Download our Mobile Apps</h6>
                    </div>
                    <div class="apps_download">
                        <a href="#"><img src="{{ asset('assets_front/img/core-img/play-store.png')}}" alt="Play Store"></a>
                        <a href="#"><img src="{{ asset('assets_front/img/core-img/app-store.png')}}" alt="Apple Store"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer_bottom_area">
        <div class="container">
            <div class="row align-items-center">
                <!-- Copywrite -->
                <div class="col-12 col-md-6">
                    <div class="copywrite_text">
                        <p>Made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="#">Designing
                                World</a></p>
                    </div>
                </div>
                <!-- Payment Method -->
                <div class="col-12 col-md-6">
                    <div class="payment_method">
                        <img src="{{ asset('assets_front/img/payment-method/maestro.png')}}" alt="">
                        <img src="{{ asset('assets_front/img/payment-method/paypal.png')}}" alt="">
                        <img src="{{ asset('assets_front/img/payment-method/western-union.png')}}" alt="">
                        <img src="{{ asset('assets_front/img/payment-method/discover.png')}}" alt="">
                        <img src="{{ asset('assets_front/img/payment-method/american-express.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Area -->

<!-- jQuery (Necessary for All JavaScript Plugins) -->
<script src="{{ asset('assets_front/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets_front/js/popper.min.js') }}"></script>
<script src="{{ asset('assets_front/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets_front/js/jquery.easing.min.js') }}"></script>
<script src="{{ asset('assets_front/js/classy-nav.min.js') }}"></script>
<script src="{{ asset('assets_front/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets_front/js/scrollup.js') }}"></script>
<script src="{{ asset('assets_front/js/waypoints.min.js') }}"></script>
<script src="{{ asset('assets_front/js/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('assets_front/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('assets_front/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets_front/js/jarallax.min.js') }}"></script>
<script src="{{ asset('assets_front/js/jarallax-video.min.js') }}"></script>
<script src="{{ asset('assets_front/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets_front/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('assets_front/js/wow.min.js') }}"></script>
<script src="{{ asset('assets_front/js/active.js') }}"></script>
<script src="{{ asset('assets_back/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{ asset('assets_back/plugins/toastr/toastr.min.js')}}"></script>
<script src="{{ asset('assets_back/plugins/summernote/summernote-bs4.min.js')}}"></script>

@yield('frontscripts')

<script>
    //  var Toast = Swal.mixin({
    //     toast: true,
    //     position: 'top-end',
    //     showConfirmButton: false,
    //     timer: 3000
    //   });
      
      toastr.options.preventDuplicates = true;
     
  $.ajaxSetup({
    headers:{
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  })

  </script>
</body>

</html>
