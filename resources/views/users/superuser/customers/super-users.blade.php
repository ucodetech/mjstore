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
          <!-- Info boxes -->
          <div class="card">
            <div class="card-header">
            <h3 class="card-title">List of Users </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
                </button>
            </div>
            </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-condensed table-hover" id="usersTable">
                        <thead>
                            <th>#</th>
                            <th>Unique ID</th>
                            <th>Photo</th>
                            <th>Fullname</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Tel</th>
                            <th>Role</th>
                            <th>Date Joined</th>
                            <th>Last Login</th>
                            <th>Status</th>
                            <th>Action</th>
                            
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="card-footer text-muted">
                    <button class="btn text-light">
                Total Users  <span class="badge badge-info">{{ $user_count }}</span>
                    </button>
                </div>
           </div>   
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- Modal -->
  <div class="modal fade" id="userDetailModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog model-dialog-scrollable" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">User Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
            <div class="modal-body">
                <div class="container-fluid" id="showUserDetails">
                   
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
  </div>
  
  
  <!-- /.content-wrapper -->

@endsection