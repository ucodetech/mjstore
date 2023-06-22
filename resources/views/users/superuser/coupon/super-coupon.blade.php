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
                            List of Coupon
                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
                            <table class="table table-striped table-inverse table-hover" id="couponTableID">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Type</th>
                                        <th>Change Type</th>
                                        <th>Value</th>
                                        <th>Status</th>
                                        <th>Created On</th>
                                        <th>Updated On</th>
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
                            Add Coupon
                        </div>
                        <div class="card-body">
                            <form action="{{ route('superuser.super.add.coupon') }}" method="POST" 
                             id="addCouponForm">
                             @csrf
                             @method('POST')
                              
                             <div class="form-group">
                                <label for="code">Code: <sup class="text-danger">*</sup></label>
                                <div class="input-group input-group-md">
                                  <input type="text" name="code" id="code" class="form-control" readonly>
                                  <span class="input-group-append">
                                    <button type="button" id="generateCouponCode" class="btn btn-info btn-flat">Generate</button>
                                  </span>
                                </div>
                                <span class="text-danger text-error code_error"></span>
                              </div>
                              <div class="form-group">
                                <label for="coupon_value">Value</label>
                                <input type="number" name="coupon_value" id="coupon_value" class="form-control">
                                <span class="text-error text-danger coupon_value_error"></span>
                              </div>
                                  <div class="form-group">
                                    <label for="type">Type</label>
                                    <select class="custom-select" name="type" id="type">
                                        <option value="">Select type</option>
                                        <option value="fixed">Fixed</option>
                                        <option value="percent">Percent</option>
                                    </select>
                                    <span class="text-danger text-error type_error"></span>
                                  </div>
                                  <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="custom-select" name="status" id="status">
                                        <option value="">Select status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    <span class="text-danger text-error status_error"></span>
                                  </div>
                                 
                                  <button type="submit" class="btn btn-primary">Add Coupon</button>
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
      

  </script>
@endsection


   

   
