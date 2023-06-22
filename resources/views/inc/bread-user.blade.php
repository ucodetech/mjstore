  <!-- Breadcumb Area -->
  @php
      $title = basename($_SERVER['PHP_SELF'], '.blade.php');
      $title = explode('-', $title);
      $title = ucfirst($title[1]);
  @endphp
  <div class="breadcumb_area">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <h5>{{ $title }}</h5>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.customer.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Breadcumb Area -->