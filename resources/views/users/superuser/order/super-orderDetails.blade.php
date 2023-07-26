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
            {{-- <div class="card" style="background-color:#060913c0;">
                <div class="card-header">
                <h3 class="card-title d-flex flex-grow-1">
                    Order Details
                </h3>

                <div class="card-tools">
                    <a href="{{ route('superuser.super.orders') }}" class="btn btn-tool btn-outline-info btn-sm">
                        Back to Order
                    </a>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
                </div>
                 --}}

       
        <div class="card-body" id="orderItems{{$item->id }}" >
            <div class="row mb-4">
                <div class="col-md-8">
                    <h3 class="lead text-uppercase text-bold">Order Details: Date Ordered: {{ pretty_dates($item->created_at) }}</h3>
                </div>
                <div class="col-md-4 text-right">
                    <a href="{{ route('superuser.super.orders') }}" class="btn  btn-outline-info btn-sm">
                        Back to Order
                    </a>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-md-4">
                    <div class="card rounded-end shadow" style="background-color: #060913c0">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-md-12">
                                
                                <div class="row">
                                    <div class="col-md-8">
                                        Order ID: <span class="text-success">{{ $orderid}}</span>
                                    </div>
                                    <div class="col-md-4">
                                       
                                            @if($item->payment_status == 0)
                                                <span class='text-warning'>Not Paid</span>
                                            @else
                                                <span class='text-success'>Paid</span>
                                            @endif
                                     
                                    </div>
                                </div>
                                </div>
                               <hr>
                                <div class="col-md-12 mt-3">
                                    <div class="form-group">
                                        <label for="updateOrderStatus">Update Order Status</label>
                                        <select class="form-control" name="updateOrderStatus" id="updateOrderStatus" data-url="{{ route('superuser.super.update.order.status') }}" data-order-id="{{ $orderid }}">
                                            <option value="">-- Select Status --</option>
                                            <option value="processing">Processing</option>
                                            <option value="pending">Pending</option>
                                            <option value="delivered">Delivered</option>
                                        </select>
                                        <small class="text-danger">Note: once you select order status the system will update the current Order!</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card rounded-end shadow" style="background-color: #060913c0">
                        <div class="card-body p-3">
                            <div class="d-flex flex-grow-1 justify-content-center align-items-center">
                                 <span class="text-capitalize">
                                   Payment Method:  {{ $item->payment_method }}  
                                 </span>
                            </div>
                          </div>
                    </div>
                    <div class="card rounded-end shadow" style="background-color: #060913c0">
                        <div class="card-body p-3">
                            <div class="d-flex flex-grow-1 justify-content-center align-items-center">
                                    <i class="fa fa-plus-circle fa-5x"></i> &nbsp; Track Order (Coming Soon)
                            </div>
                          </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card shadow" style="background-color: #060913c0">
                        <div class="card-body" id="detailSection">
                    
                        @foreach ($orderitems as $p_item) 
                        @foreach ($p_item->products as $product) 
                            @php
                                $photo = explode(',', $product->photo)
                            @endphp
                        <div class="media d-flex">
                        <a class="d-flex">
                            <img src="{{ asset('storage/uploads/products/'.$photo[0]) }}" alt="{{ $product->name  }}" class="img-thumbnail" width="60">
                        </a>
                        
                        <div class="media-body pl-2">
                            <a class="text-center text-white">
                                {{ $product->title }}
                            </a><br>
                            
                            <span class="text-muted">
                                {{ Naira($product->sales_price)  }}
                            </span>
                            
                        </div>
                        <span class="text-white-50">{{ $p_item->product_qty }}x</span>
                    </div>
                    <hr>
                        @endforeach
                        @endforeach
                        
                    
                    
                        </div>
                        <div class=" p-2 d-flex flex-grow-1 gap-3 justify-content-between" style="background-color: #160913c0">
                            <span>Order Status:&nbsp; <span id="orderStatus"></span> </span>
                            <span>Shipping Fee : {{  Naira($item->delivery_charge) }}</span>
                            <span>Payment Method : {{  $item->payment_method }}</span>
                            <span>Sub Total:  {{  Naira($item->sub_total) }}</span>
                            <span>Total:  {{  Naira($item->total_amount) }}</span>
                        </div>
                 </div>
                 <div class="card rounded-5 shadow" style="background-color:#060913c0">
                    <div class="card-body">
                    
                        <h5 class="text-bold">
                            <i class="fa fa-map-marked-alt fa-lg"></i>
                            {{  $item->fullname  }}
                        </h5>
                        <address>
                            {{  $item->address }} {{ $item->town  }}, {{  $item->state  }} ,
                                {{ $item->postcode }}
                            
                                
                        </address>
                    </div>
                </div>
                </div>
            </div>
                            
 
    
   
        </div>
    </div>

{{-- </div>    --}} <!--/first card-->
                
    </div><!--/. container-fluid -->

</section>
<!-- /.content -->
</div>
  

  
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
  <script>

    

    

    $(function(){


       
    $('body').on('change', '#updateOrderStatus', function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let orderId = $(this).data('order-id');
        let status = $(this).val();

        $.post(url, {orderId:orderId, status:status}, function(data){
                toastr.success(data.msg);
                $('#updateOrderStatus').val('');
               orderStatus(orderId);
        })
    })
    orderStatus("{{ $orderid }}")
    function orderStatus(orderId){
        let url = "{{ route('superuser.super.get.order.status') }}";
        $.post(url, {orderId:orderId}, function(data){
            $('#orderStatus').html(data);
            
        })
    }


    })
  </script>

@endsection

