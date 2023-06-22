  <!-- Breadcumb Area -->
  @php
      $title = basename($_SERVER['PHP_SELF'], '.blade.php');
      $title = explode('-', $title);
      $title1 = ucfirst($title[0]);
      $title2 = ucfirst($title[1]);
  @endphp
  <div class="breadcumb_area">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <h5>{{ $title1 . ' ' . $title2 }}</h5>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">{{$title1 . ' ' . $title2  }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Breadcumb Area -->