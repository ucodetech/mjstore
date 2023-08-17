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
                    <table class="table table-bordered table-condensed table-hover" id="sellersTable">
                        <thead>
                            <th>#</th>
                            <th>Unique ID</th>
                            <th>Photo</th>
                            <th>Fullname</th>
                            <th>Email</th>
                            <th>Tel</th>
                            <th>Shop Name</th>
                            <th>Biz Option</th>
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
                         Total Sellers  <span class="badge badge-info">{{ $seller_count }}</span>
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
@section('scripts')

<script>


$(function(){

                            
$('#sellersTable').DataTable({
    processing: true,
    info:true,
    ajax:'super-sellers-list',
    columns: [
        {data:'DT_RowIndex', name:'DT_RowIndex'},
        {data:'unique_id', name:'unique_id'},
        {data:'photoCus', name:'photoCus'},
        {data:'manager_fullname', name:'manager_fullname'},
        {data:'manager_email', name:'manager_email'},
        {data:'manager_tel', name:'manager_tel'},
        {data:'shop_name', name:'shop_name'},
        {data:'bizOption', name:'bizOption'},
        {data:'cusDateJoined', name:'cusDateJoined'},
        {data:'lastLogin', name:'lastLogin'},
        {data:'status', name:'stauts'},
        {data:'actions', name:'actions'}
    ]

   

});


// deactivate brand
$('body').on('click','#deactivateSeller' ,function(e){
    e.preventDefault();
    let url = $(this).data('url');
    let seller_id = $(this).data('id');
    let _token = "{{ csrf_token() }}";
    Swal.fire({
      title:'Are you sure?',
      text: 'Seller will be deactivated!',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes deactivate it!',
      allowOutsideClick:false
    }).then(function(result){
        if(result.value){
          $.post(url, {seller_id:seller_id, _token:_token}, function(data){
              Swal.fire(
                'Seller deactivated!',
                 data,
                'success'
              );
              $('#sellersTable').DataTable().ajax.reload(null,false);
            
          });
        }
    });

})
// active brand
$('body').on('click','#activateSeller' ,function(e){
    e.preventDefault();
    let url = $(this).data('url');
    let seller_id = $(this).data('id');
    let _token = "{{ csrf_token() }}";
    Swal.fire({
      title:'Are you sure?',
      text: 'Seller will activated',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes activate it!',
      allowOutsideClick:false
    }).then(function(result){
        if(result.value){
          $.post(url, {seller_id:seller_id}, function(data){
              Swal.fire(
                'Seller Activated!',
                 data,
                'success'
              );
              $('#sellersTable').DataTable().ajax.reload(null,false);
            
          });
        }
    });

})

// $('body').on('click', '#userDetail', function(e){
//   e.preventDefault();
//   let url = $(this).data('url');
//   let user_id = $(this).data('id');
//   $.post(url, {user_id:user_id}, function(data){
//     $("#userDetailModal").modal('show');
//     $('#showUserDetails').html(data);
//   })
// })

});
</script>





@endsection