@extends('layouts.editheadapp')
@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('inc.editbread')
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <!-- Info boxes -->
          <!-- Info boxes -->
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header">
                <h3 class="card-title">Business Information</h3>
    
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
                </div>
                    <div class="card-body">
                      <div class="container">
                        <h4 class="text-left text-muted">Personal Information</h4>
                        <hr>
                            <h5 class="text-muted mb-0">Manager Fullname: {{ $biz->manager_fullname }}</h5>
                            <p class="text-muted mb-0">Manager Phone No: {{ $biz->manager_tel }}</p>
                            <p class="text-muted mb-0">Manager Email: {{ $biz->manager_email }}</p>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-md-4">
                          @if ($biz->email_verified == 0)
                              <span class="badge badge-pill badge-danger">
                                Email Not verified
                              </span>
                          @else
                              <span class="badge badge-pill badge-success">
                                Email  verified
                              </span>
                          @endif
                        </div>
                        <div class="col-md-4">
                          @if ($biz->status == 'inactive')
                              <span class="badge badge-pill badge-danger">
                                Seller is not activated
                              </span>
                          @else
                              <span class="badge badge-pill badge-success">
                                Seller Activated
                              </span>
                          @endif
                        </div>
                        <div class="col-md-4">
                          @if ($biz->can_sell_now == 0)
                            <span class="badge badge-pill badge-danger">
                            Seller Not Approved
                            </span>
                          @else
                              <span class="badge badge-pill badge-success">
                                Seller Approved
                              </span>
                          @endif
                        </div>
                       
                      </div>
                      <hr>
                      <h3 class="text-left lead text-muted">Business Information</h3>
                      <hr>
                      <div class="row">
                       
                        <div class="col-md-6">
                          <h5 class="lead">Shop Name: {{ $biz->shop_name }}</h5>
                        </div>
                        <div class="col-md-6">
                          @if ($biz->business_options == 0)
                            <span class="badge badge-btn badge-danger">
                              Unregistered Business
                            </span>
                          @else
                              <span class="badge badge-btn badge-info">
                                Registered Business
                              </span>
                          @endif
                        </div>

                        {{-- business information --}}
                        @if ($biz->business_information != null)
                            
                        <div class="col-md-12">
                            <address>
                              Address: {{ $biz->business_information->shop_address }} , {{ $biz->business_information->shop_city }},  {{ $biz->business_information->shop_state }}
                            </address>
                          <div class="d-flex flex-column">
                            <p class="text-muted mt-3 mb-1">Bank Details</p>
                              <span>Bank:  {{ $biz->business_information->bank_name }}</span>
                              <span>Account Name:  {{ $biz->business_information->account_name }}</span>
                              <span>Account No:  {{ $biz->business_information->account_number }}</span>

                              <p class="text-muted mt-3 mb-1">Customer Support Details</p>
                              <span>Email:  {{ $biz->business_information->customer_support_email }}</span>
                              <span>Phone Number (Call):  {{ $biz->business_information->customer_support_phone_no }}</span>
                              <span>Whatsapp: <a href="https://wa.me/{{ $biz->business_information->customer_support_whatsapp }}"> 
                                {{ $biz->business_information->customer_support_whatsapp }} </a></span>
                          </div>

                        </div>
                        @else
                          <h6 class="text-center mt-4 text-warning">Seller have not filled business information form yet</h6>
                        @endif
                         {{-- business information --}}
                        
                      </div>
                    </div>
                    <div class="card-footer">
                      @if ($biz->business_information != null)
                        @if($biz->business_information->approved != 1)
                          <button button type="button" id="approveSeller" data-url="{{ route('superuser.super.seller.approve') }}" data-seller-id="{{ $biz->business_information->seller_id }}" class="btn btn-outline-warning">Approve</button>
                        @endif
                      @endif
                    </div>
               </div>   
            </div>

            {{-- biz info logo and cac --}}
            <div class="col-md-4">
              <div class="card">
                <div class="card-header">
                <h3 class="card-title">Logo</h3>
                  
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
                      @if ($biz->business_information != null)
                       <img src="{{ asset('storage/uploads/bizinfo/'.$biz->unique_key.'/'.$biz->business_information->shop_logo) }}" alt="{{ $biz->shop_name }}" class="img-fluid img-rounded img-size-64">
                      @endif
                    </div>
                    
               </div>   
               {{-- if seller has a registered business --}}
               @if ($biz->business_options == 1)
                   
               <div class="card">
                <div class="card-header">
                <h3 class="card-title">CAC</h3>
    
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
                     @if ($biz->business_information != null)
                      <div class="mb-3">
                        <p class="text-muted mb-4">Reg Biz Name: {{ $biz->business_information->registered_biz_name }}</p>
                        <p class="text-muted">CAC No: {{ $biz->business_information->cac_registration_no }} &nbsp; <a href="#" class="btn btn-sm btn-outline-success">Verify</a></p>
                      </div>
                      <img src="{{ asset('storage/uploads/bizinfo/'.$biz->unique_key.'/'.$biz->business_information->cac_certificate) }}" alt="{{ $biz->shop_name }}" class="img-fluid img-rounded" width="408">
                    @endif
                    </div>
               </div>  
               @endif
               {{-- end if   --}}
            </div>
            {{-- end biz info logo and cac --}}

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


// deactivate brand
$('body').on('click','#approveSeller' ,function(e){
    e.preventDefault();
    let url = $(this).data('url');
    let seller_id = $(this).data('seller-id');
    let _token = "{{ csrf_token() }}";
    Swal.fire({
      title:'Are you sure?',
      text: 'Seller will be approved and made visible to the public!',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes approve it!',
      allowOutsideClick:false
    }).then(function(result){
        if(result.value){
          $.post(url, {seller_id:seller_id, _token:_token}, function(data){
              Swal.fire(
                'Seller Approved!',
                 data,
                'success'
              );
            setTimeout(() => {
              location.reload();
            }, 3000);
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



});
</script>





@endsection