<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ (getSettings() !=null) ? getSettings()->meta_description : "#" }}">
    <meta name="keywords" content="{{ (getSettings() !=null) ? getSettings()->meta_keywords : "#" }}">
    <meta name="author" content="Ejekwu Graveth Uzoma">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- title --}}
    @php
        $title = basename($_SERVER['PHP_SELF'], '.blade.php');
        $title = explode('-', $title);
        $title = ucfirst($title[1]);
    @endphp
    <title>{{ config('app.name', 'Laravel') }}| {{ (($title == 'Index.php')? 'Index':$title) }}</title>
    

    <!-- Favicon  -->
   <!-- Favicon  -->
   <link rel="icon" href="{{ (getSettings() != null ? asset('storage/uploads/settings/'.getSettings()->favicon) : asset('assets_front/img/core-img/favicon.ico')) }}">



    <link rel="stylesheet" href="{{ asset('assets_front/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets_front/css/classy-nav.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets_front/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets_front/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{ asset('assets_front/css/animate.css')}}">
    <link rel="stylesheet" href="{{ asset('assets_front/css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets_front/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{ asset('assets_front/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets_front/css/icofont.min.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.4.0/css/all.min.css" integrity="sha512-eBNnVs5xPOVglLWDGXyZnZZ2K2ixXhR/3aECgCpFnW2dGCd/yiqXZ6fcB3BubeA91kM6NX234b6Wrah8RiYAPA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('assets_back/plugins/sweetalert2/sweetalert2.css')}}">
    {{-- <link rel="stylesheet" href="{{ asset('admin-assets_back/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}" --}}
    <link rel="stylesheet" href="{{ asset('assets_back/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets_back/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets_back/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets_back/plugins/toastr/toastr.css')}}">
    <link rel="stylesheet" href="{{ asset('assets_back/plugins/summernote/summernote-bs4.min.css')}}">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets_front/css/style.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Oswald:wght@300;400&family=Passion+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('shopcss/shop.css') }}">
    @vite('resources/js/app.js')

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
        .bigshop-main-menu .tech-mod{
            border-bottom: 3px solid rgba(3, 56, 56, 0.432) !important; border-bottom-left-radius:20px !important;
            border-bottom-right-radius:20px !important;
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
                            data-content="Welcome to Bigshop ecommerce template."><i
                                class="icofont-info-square"></i></span>
                        <span class="text">Welcome to Mummy Joy Store.</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="language-currency-dropdown d-flex align-items-center justify-content-end">
                        
                        @include('inc.currency_header')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Menu -->
    <div class="bigshop-main-menu">
        <div class="container tech-mod">
            <div class="classy-nav-container breakpoint-off">
                <nav class="classy-navbar" id="bigshopNav">

                    <!-- Nav Brand -->
                    <a href="{{ route('home') }}" class="nav-brand"><img src="{{  getSettings() != null ? asset('storage/uploads/settings/'. getSettings()->site_logo): asset('assets_front/img/core-img/logo.png')  }}" alt="logo"></a>

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
                                <li><a href="{{ route('user.customer.dashboard') }}">Dashboard</a> </li>
                                
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

                        <!-- Cart -->
                        @include('inc.cart_area')

                        <!-- Account -->
                        <div class="account-area">
                            @if (Auth::check())
                            <div class="user-thumbnail">
                                <img src="{{ asset('profilePhotos/userProfile') .'/'. auth()->user()->photo }}" alt="{{  auth()->user()->fullname[1]  }}" class="img-fluid img-thumbnail">
                            </div>
                            <ul class="user-meta-dropdown">
                                <li class="user-title"><span>Hello,</span> {{ auth()->user()->fullname }}</li>
                                <li><a href="{{ route('user.customer.dashboard') }}">Dashboard</a></li>
                                <li><a href="{{ route('user.customer.orders') }}">Orders List</a></li>
                                <li><a href="{{ route('user.customer.wishlist') }}">Wishlist</a></li>
                                <li><a href="{{ route('user.customer.logout') }}"><i class="icofont-logout"></i> Logout</a></li>
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
                        <li><span>Address:</span> {{ (getSettings() !=null) ? getSettings()->address : "#" }}</li>
                        <li><span>Phone:</span> 
                            <a href="tel: {{ (getSettings() !=null) ? getSettings()->phone : "#" }}">
                                 {{ (getSettings() !=null) ? getSettings()->phone : "#" }}
                            </a>
                        </li>
                        <li><span>Email:</span> 
                            <a href="mailto:{{ (getSettings() !=null) ? getSettings()->email : "#" }}">
                                {{ (getSettings() !=null) ? getSettings()->email : "#" }}
                            </a>
                        </li>
                    </ul>
                    <div class="footer_social_area mt-15">
                        <a href="{{ (getSettings() !=null) ? getSettings()->facebook_url : "#" }}"><i class="fab fa-facebook" aria-hidden="true"></i></a>
                        <a href="{{ (getSettings() !=null) ? getSettings()->twitter_url : "#" }}"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                        <a href="{{ (getSettings() !=null) ? getSettings()->linkedin_url : "#" }}"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
                        <a href="{{ (getSettings() !=null) ? getSettings()->whatsapp_url : "#" }}"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>
                        <a href="{{ (getSettings() !=null) ? getSettings()->instagram_url : "#" }}"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                        <a href="{{ (getSettings() !=null) ? getSettings()->youtube_url : "#" }}"><i class="fab fa-youtube" aria-hidden="true"></i></a>
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
                        <p>Made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="#">{{ (getSettings() !=null) ? getSettings()->made_with : "Designing word" }}</a></p>
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

<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{ asset('assets_back/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{ asset('assets_back/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{ asset('assets_back/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{ asset('assets_back/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
<script src="{{ asset('assets_back/plugins/datatables/jquery.dataTables.min.js')}}"></script>


<script src="{{ asset('assets_back/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets_back/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('assets_back/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets_back/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('assets_back/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets_back/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{ asset('assets_back/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{ asset('assets_back/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{ asset('assets_back/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('assets_back/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('assets_back/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{ asset('assets_back/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{ asset('assets_back/plugins/toastr/toastr.min.js')}}"></script>
<script src="{{ asset('assets_back/plugins/summernote/summernote-bs4.min.js')}}"></script>
<script src="{{ asset('shopjs/currency.js')}}"></script>

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
