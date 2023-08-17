@extends('layouts.usersapp')

@section('frontcontent')
{{-- @include('inc.bread-user') --}}

   <!-- My Account Area -->
   <section class="my-account-area section_padding_100_50 pt-3">
    <div class="container">
        <div class="row">
            @include('inc.customerdashboard')
            <div class="col-12 col-lg-9">
                <div class="my-account-content mb-50">
                      {{-- contents --}}
                      <div class="card">
                       <div class="card-body">
                            <a class="text-bold">My Orders</a> ({{ count($orders) }})
                       </div>
                      </div>
                      <hr class="invisible">
                    @if (count($orders)>0)
                    @foreach ($orders as $item)
                        @php
                            switch ($item->order_status) {
                                case 'pending':
                                    $color = 'text-warning';
                                    break;
                                case 'processing':
                                    $color = 'text-warning';
                                    break;
                                case 'delivered':
                                    $color = 'text-warning';
                                    break;
                                case 'canceled':
                                    $color = 'text-warning';
                                    break;
                                
                                default:
                                    $color = 'text-warning';
                                    break;
                            }
                        @endphp
                            <div class="card">
                                <div class="card-header d-inline-flex gap-3 justify-content-between">
                                    <a style="cursor:pointer" class="toggleOrderItems" data-id="{{ $item->id }}"><span class="text-primary">Order No:  #{{ $item->order_number }}</span></a>
                                    
                                    <small>Order Date:  {{ pretty_date($item->created_at) }}</small>
                                    
                                </div>
                                <div class="card-body" id="orderItems{{ $item->id }}" style="display:none">
                                    <div class="card">
                                        <div class="card-body">
                                            
                                            @foreach ($item->orderitems as $p_item)
                                                @foreach ($p_item->products as $product)
                                                @php
                                                    $photo = explode(',', $product->photo);
                                                    
                                                @endphp
                                                <div class="media d-flex">
                
                                                    <a class="d-flex">
                                                        <img src="{{ asset('storage/uploads/products/'.$photo[0])}}" alt="{{ $product->name }}" class="img-thumbnail" width="60">
                                                    </a>
                                                    
                                                    <div class="media-body pl-2">
                                                        <a class="text-center">
                                                           {{wrap50($product->title)}}
                                                        </a><br>
                                                        
                                                        <span class="text-muted">
                                                            {{ Naira($product->sales_price) }}
                                                        </span>
                                                        <div class="d-flex flex-grow-1 text-muted p-1">

                                                            @php
                                                                $color = $p_item->product_color != "" ? $p_item->product_color :"";
                                                                $size = $p_item->product_size != "" ? $p_item->product_size : "";
                                                            @endphp
                                                            @if ($color != "")
                                                                <span class="d-inline-flex text-sm">
                                                                    <span class="colortext">Item Color:</span>
                                                                    <span class="rounded-circle colorid shadow"
                                                                        style="background-color:{{ $color }}; border:1px solid #ddd">
                                                                    </span>
                    
                                                                </span>
                                                            @endif
                                                            @if ($size != "")
                                                          
                                                                <span class="d-inline-flex text-sm ml-2">
                                                                    <span class="text-bold">Item Size:</span>
                                                                    <span class="text-bold text-sm text-dark">
                                                                        {{ $size }}
                                                                    </span>
                                                                </span>
                                                            @endif
                    
                    
                                                        </div>
                                                      
                                                    </div>
                                                    <span class="text-muted">{{ $p_item->product_qty }}x</span>
                                                </div><hr>
                                                @endforeach
                                                
                                            @endforeach
                                           
                                        </div>
                                        <div class=" p-2 d-lg-inline-flex gap-3 justify-content-between">
                                            <span>Order Status:  <span class="{{ $color }}">{{ $item->order_status }}</span></span>
                                            <span>Shipping Fee : {{ Naira($item->delivery_charge) }}</span>
                                            <span>Sub Total:  {{ Naira($item->sub_total) }}</span>
                                            <span>Total:  {{ Naira($item->total_amount) }}</span>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                           
                                            <h5 class="text-bold">
                                                <i class="fa fa-map-marked-alt fa-lg"></i>
                                                 {{ $item->fullname }}
                                            </h5>
                                            <address>
                                                {{ $item->address }}, {{ $item->town }}, {{ $item->state }}, {{ $item->postcode ? $item->postcode : ''}}
                                            </address>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                    @endforeach
                
                        @else
                            <span class="text-center">No order yet</span>
                        @endif
                          
                        <div class="d-flex justify-content-center">
                            {!! $orders->links('pagination::bootstrap-4') !!}
                        </div>
                </div>
            </div>
           
        </div>
      
    </div>
    
</section>
<!-- My Account Area -->
{{-- order items  --}}
    <!-- Button trigger modal -->
    <!-- Modal -->
    {{-- <div class="modal fade" id="orderItemsModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">Order Items</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid" id="showOrderItems">
                      
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
     --}}
{{-- end of order items  --}}
@endsection

@section('frontscripts')
  <script>
   $(function(){

    $('body').on('click','.toggleOrderItems', function(e){
        e.preventDefault();
        let id = $(this).data('id');
        $('#orderItems'+id).toggle();
    })
        
       

   })
  
  </script>
@endsection