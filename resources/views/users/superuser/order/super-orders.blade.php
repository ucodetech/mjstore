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
                                {{-- <th>Delivery Charge</th>
                                <th>Shipping Method</th> --}}
                                <th>Quantity</th>
                                {{-- <th>Payment Method</th> --}}
                                <th>Payment Status</th>
                                <th>Order Status</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                @foreach ($orders as $order)
                                    
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('superuser.super.order.items', $order->order_number ) }}" style="cursor:pointer">
                                        <span class="badge badge-pill badge-info">{{ $order->order_number }}</span>
                                        </a>
                                    </td>
                                    
                                    <td>
                                        
                                    <a href="//will link user details"><span class="badge badge-pill badge-info">{{ $order->user->email }}</span></a>

                                    </td>
                                    <td>{{ Naira($order->sub_total) }}</td>
                                    <td>{{ Naira($order->total_amount) }}</td>
                                    {{-- <td>{{ Naira($order->delivery_charge)}}</td> --}}
                                    {{-- <td>{{ getShippingMethod($order->shipping_method)->shipping_method }}&nbsp; 
                                        <a class="text-warning" data-toggle="tooltip" data-placement="top" title="Delivery Time : {{ getShippingMethod($order->shipping_method)->delivery_time }}">
                                            <i class="fa fa-question-circle fa-xs" style="cursor: pointer;"></i>
                                        </a>
                                        
                                    </td> --}}
                                    <td>{{ $order->quantity }}</td>
                                    {{-- <td>{{ $order->payment_method }}</td> --}}
                                    <td>
                                     
                                        @if ($order->payment_method == "cash on delivery" && $order->payment_status != 1)
                                            <span class="badge badge-btn badge-warning">Cash On Delivery</span>
                                        @else
                                        <span class="badge badge-btn {{ $order->payment_status == 0 ? 'badge-danger' : 'badge-success' }}">
                                         {{ (($order->payment_status == 0)?  'Not Paid':  'Paid') }}
                                        </span>
                                        @endif
                                      
                                   
                                  </td>
                                    <td>
                                      <span class="badge badge-btn {{ formattedOrderStatus($order->order_status) }}">
                                        {{ Str::ucfirst($order->order_status) }}
                                      </span>
                                    </td>
                                    
                                   <td>
                                   <div class="btn-group">
                                    <a href="{{ route('superuser.super.order.items', $order->order_number ) }}" class="btn btn-outline-info btn-sm"><i class="fa fa-eye"></i></a> &nbsp;
                                    
                                    @if ($order->order_status == "pending")
                                      <button data-id="{{ $order->id }}" data-url="{{ route('superuser.super.delete.order') }}" id="deleteOrderBtn" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    @endif
                                    
                                   </div>
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
  
  <div class="modal fade" id="orderDetailsModal">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Order Detail</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="orderItemsData"></div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
 
  
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
  <script>

    

    

    $(function(){


      

    $('body').on('click', '#getOrderItems', function(e){
      e.preventDefault();
      let url = $(this).data('url');
      let order_id = $(this).data('order-id');
      $.post(url, {order_id:order_id}, function(data){
        $("#orderDetailsModal").modal('show');
        $('#orderItemsData').html(data);
      })
    })
       
    $('body').on('change', '#updateOrderStatus', function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let orderId = $(this).data('order-id');
        let status = $(this).val();

        $.post(url, {orderId:orderId, status:status}, function(data){
                toastr.success(data);
        })
    })

    $('body').on('click', '#deleteOrderBtn', function(e){
        let url = $(this).data('url');
        let order_id = $(this).data('id');
       
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this action!",
          icon : 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if(result.isConfirmed){
            $.ajax({
              url: url,
              method: "post",
              dataType: 'json',
              data: {
                order_id:order_id,
                header: {
                  token: "{{ csrf_token() }}"
                }
              },
              success:function(data){
                if(data.code == 0){
                  toastr.error(data.error)
                }else if(data.code == 1){
                  Swal.fire(
                  'Deleted!',
                   data.msg,
                  'success'
                )
                setTimeout(() => {
                  location.reload();
                }, 2000);
                }else{
                  toastr.info(data.msg)
                }
              }
            })
          }
        })
    })
    
    })
  </script>

@endsection

