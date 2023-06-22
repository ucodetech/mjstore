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
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">List of Orders </h3>

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
                        <table class="table table-bordered table-condensed table-hover" id="productsTable">
                            <thead>
                                <th>#</th>
                                <th>Order ID</th>
                                <th>User</th>
                                <th>Sub Total</th>
                                <th>Total Pay</th>
                                <th>Delivery Charge</th>
                                <th>Shipping Method</th>
                                <th>Quantity</th>
                                <th>Payment Method</th>
                                <th>Payment Status</th>
                                <th>Order Status</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                @foreach ($orders as $order)
                                
                                
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <th><span class="badge badge-pill badge-info">{{ $order->unique_key }}</span></th>
                                    <td>
                                        <img src="{{ asset('storage/uploads/products').'/'.$photo[0] }}" 
                                        alt="{{ $order->title }}" class="img-fluid product-image-thumb" width="50">
                                    </td>
                                    <td>
                                        @if ($order->vendor == '')
                                            <span class="badge badge-pill badge-danger">Home Shop</span>
                                        @else
                                            <span class="badge badge-pill badge-info">{{ $order->vendor }}</span>

                                        @endif
                                    </td>
                                    <td>{{ wrap2($order->title) }}</td>
                                    <td>{{ $order->stock }}</td>
                                    <td>{{ Naira($order->price)}}</td>
                                    <td>{{ Naira($order->sales_price) }}</td>
                                    <td>{{ Naira($order->product_discount) }}</td>
                                    <td>{{ $order->size }}</td>
                                    <td>{{ $order->weights }}</td>
                                    <td>{{ App\Models\ProductCategory::where('id', $order->cat_id)->get()->first()->title; }}</td>
                                    <td>
                                        @if($order->child_cat_id != '')
                                        {{ App\Models\ProductCategory::where('id', $order->child_cat_id)->get()->first()->title;}}
                                        @else
                                            <span class="badge badge-pill badge-danger">No Child Cat</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->brand->title }}</td>
                                    <td>
                                    @if ($order->condition === 'new')
                                        <span class="badge badge-info">{{ $order->condition }}</span>
                                    @else
                                    <span class="badge badge-info">{{ $order->condition }}</span>
                                    @endif
                                    </td>
                                      
                                    <td>
                                    </td>
                                  
                                  
                                   
                                </tr>
                                @endforeach
                            
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-muted">
                        <button class="btn text-light">
                    Total Orders   <span class="badge badge-info">{{ $order_count }}</span>
                        </button>
                    </div>
               </div>   
                
            </div><!--/. container-fluid -->
  
        </section>
    <!-- /.content -->
  </div>
  <div class="modal fade" id="productDetail">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Product Detail</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="showProductDetails">
          
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  {{-- add more image to product modal --}}
  <!-- Modal -->
  <div class="modal fade" id="addMoreImageModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">Add More Images to <span class="text-info" id="product_title"></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
            <div class="modal-body">
                <div class="container-fluid">
                   <form action="{{ route('superuser.super.upload.more.images') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="product_id_use" id="product_id_use">
                    <input type="file" name="product_file" id="product_file">

                    <button type="submit" class="btn btn-info btn-block">Upload</button>
                </form>
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

    const pond = FilePond.create(inputElement, {
        acceptedFileTypes: ['image/png', 'image/jpeg'],
        maxFileSize: '100KB'
    });

    FilePond.setOptions({
        server:{
            process: 'tmp-upload-product',
            revert: 'tmp-revert-product',
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }
    });

    

    $(function(){
        $('body').on('click', '#addMoreimage', function(e){
            e.preventDefault();
            let product_id = $(this).data('id');
            let product_title = $(this).data('title');
            $('#addMoreImageModal').modal('show');
            $('#product_id_use').val(product_id);
            $('#product_title').html(product_title);
            
        })
        // //toggle product status
        // $('#deactivateProduct').on('click', function(e){
        //     e.preventDefault();
        //     let mode = 'deactivate';
        //     let product_id = $(this).data('id');
        //     let url = $(this).data('url');
        //     $.post(url, { product_id:product_id,mode:mode}, function(data){
        //         if(data.code==1){
        //             toastr.info(data.msg);
        //             setTimeout(() => {
        //                 location.reload();
        //             }, 1000);
        //         }else{
        //             toastr.error('Please try again');
        //         }
        //     })

        //     })
        //     $('#activateProduct').on('click', function(e){
        //         e.preventDefault();
        //         let mode = 'activate';
        //         let product_id = $(this).data('id');
        //         let url = $(this).data('url');
        //         $.post(url, { product_id:product_id,mode:mode}, function(data){
        //             if(data.code==1){
        //                 toastr.info(data.msg);
        //                 setTimeout(() => {
        //                     location.reload();
        //                 }, 1000);
        //             }else{
        //                 toastr.error('Please try again');
        //             }
        //         })
    
        //         })
            
    
    })
  </script>

@endsection

