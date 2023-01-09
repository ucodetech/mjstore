@extends('layouts.superuserapp')
@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('inc.bread')
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <!-- Info boxes -->
            <div class="row">
                <div class="col-md-8">
                     <div class="card">
                        <div class="card-header">
                            List of Banners
                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
                            <table class="table table-striped table-inverse table-hover" id="bannerTable">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Condition</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                            </table>
                           </div>
                        </div>
                        
                     </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Add Banner
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Title</h4>
                            <p class="card-text">Text</p>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection



   

   
