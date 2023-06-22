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
                            List of Shipping Method
                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
                            <table class="table table-striped table-inverse table-hover" id="shippingMethodTableID">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>#</th>
                                        <th>Shipping Method</th>
                                        <th>Delivery Time</th>
                                        <th>Delivery Charges</th>
                                        <th>Status</th>
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
                            Add Shipping Method
                        </div>
                        <div class="card-body">
                            <form action="{{ route('superuser.super.process.method') }}" method="POST" enctype="multipart/form-data"
                             id="addShippingMethodForm">
                             @csrf
                             @method('POST')
                             
                              <div class="form-group">
                                  <label for="shipping_method">Shipping Method</label>
                                  <input type="text" name="shipping_method" id="shipping_method" class="form-control" 
                                  aria-describedby="helpId">
                                  <span  class="text-danger text-error shipping_method_error"></span>
                                </div>
                                <div class="form-group">
                                  <label for="shipping_delivery_time">Delivery Time</label>
                                  <input type="text" name="shipping_delivery_time" id="shipping_delivery_time" class="form-control" 
                                  aria-describedby="helpId">
                                  <span  class="text-danger text-error shipping_method_error"></span>
                                </div>
                                <div class="form-group">
                                  <label for="shipping_delivery_charge">Delivery Charge</label>
                                  <input type="money" name="shipping_delivery_charge" id="shipping_delivery_charge" class="form-control" 
                                  aria-describedby="helpId">
                                  <span  class="text-danger text-error shipping_delivery_charge_error"></span>
                                </div>
                                <div class="form-group">
                                  <textarea  id="delivery_description" name="delivery_description"
                                  rows="10" class="form-control"></textarea>
                                </div>
                                  <div class="form-group">
                                    <label for="shipping_method_status">Status</label>
                                    <select class="custom-select" name="shipping_method_status" id="shipping_method_status">
                                        <option value="">Select status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    <span class="text-danger text-error shipping_method_status_error"></span>
                                  </div>
                                 
                                  <button type="submit" class="btn btn-primary">Add Method</button>
                            </form>
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
@section('scripts')
  <script>
       $(function(){
        $('#delivery_description').summernote();
        // shippingMethodTableID
      
        $('#shippingMethodTableID').DataTable({
        processing: true,
        info:true,
        ajax:"{{ route('superuser.super.list.shipping.method') }}",
        columns: [
            {data:'DT_RowIndex', name:'DT_RowIndex'},
            {data:'shipping_method', name:'shipping_method'},
            {data:'delivery_time', name:'delivery_time'},
            {data:'delivery_charge', name:'delivery_charge'},
            {data:'status', name:'stauts'},
            {data:'actions', name:'actions'}
        ]

    });

  $('#addShippingMethodForm').on('submit', function(e){
    e.preventDefault();
    let form = this;
    $.ajax({
        url:$(form).attr('action'),
        method:$(form).attr('method'),
        data:new FormData(form),
        cache:false,
        contentType:false,
        processData:false,
        beforeSend:function(){
          $(form).find('span.text-error').text('');
        },
        success:function(data){
          if(data.code == 0){
            $.each(data.error, function(prefix, val){
              $(form).find('span.'+prefix+'_error').text(val[0]);
            })
          }else{
            $('#addShippingMethodForm')[0].reset();
            $('#delivery_description').html('');
            $('#shippingMethodTableID').DataTable().ajax.reload(null, false);
            toastr.success(data.msg);
          }
        }
    })
  })



       })

  </script>
@endsection


   

   
