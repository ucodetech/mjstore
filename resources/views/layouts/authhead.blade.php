<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $title = basename($_SERVER['PHP_SELF'], '.blade.php');
        $title = explode('-', $title);
        $title = ucfirst($title[1]);
    @endphp
  <title> {{ config('app.name') }} | {{ $title }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('assets_back/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('assets_back/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets_back/dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets_backplugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">

  <link rel="stylesheet" href="{{ asset('assets_back/plugins/sweetalert2/sweetalert2.css')}}">
  {{-- <link rel="stylesheet" href="{{ asset('admin-assets_back/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}" --}}
  <link rel="stylesheet" href="{{ asset('assets_back/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets_back/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets_back/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets_back/plugins/toastr/toastr.css')}}">
  <link rel="stylesheet" href="{{ asset('assets_back/plugins/summernote/summernote-bs4.min.css')}}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Oswald:wght@300;400&family=Passion+One&display=swap" rel="stylesheet">
</head>
<style>
  *{
    /* /* font-family: 'Fredoka One', cursive; */
    font-family: 'Oswald', sans-serif;
    /* font-family: 'Passion One', cursive;  */
  }
  /* html{
    font-family: 'Fredoka One', cursive;
    font-family: 'Oswald', sans-serif; 
    font-family: 'Passion One', cursive;
  } */
</style>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
 

  @yield('auth')

  <!-- Main Footer -->
  <footer class="">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('assets_back/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{ asset('assets_back/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('assets_back/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets_back/dist/js/adminlte.js')}}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{ asset('assets_back/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{ asset('assets_back/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{ asset('assets_back/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{ asset('assets_back/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{ asset('assets_back/plugins/chart.js/Chart.min.js')}}"></script>

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
  $(function(){
    $('#summernote').summernote()
  
  })
  </script>

</body>
</html>