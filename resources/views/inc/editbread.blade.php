@php
  $title = basename($_SERVER['PHP_SELF'], '.blade.php');
  $title = explode('-', $title);
  $title = $title[0]
@endphp
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{ Str::upper($title) }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item" id="goBackBtn"><a href="#"> << Go Back </a></li>
            <li class="breadcrumb-item active">{{ ucfirst($title) }}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
      <div class="row">
        @include('inc.messages')
      </div>
    </div><!-- /.container-fluid -->
  </div>