@extends('layouts.sellerapp')
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
                <div class="col-md-4">
                  <div class="card m-md-auto w-100">
                      <div class="card-header">
                          Add Color
                      </div>
                      <div class="card-body">
                          <form action="{{ route('seller.vendor.add.colors') }}" method="POST"
                           id="addColorForm">
                           @csrf
                           @method('POST')
                            
                            <div class="form-group">
                                <label for="color">Color</label>
                                <input type="text" name="color" id="color" class="form-control" 
                                aria-describedby="helpId">
                                <span  class="text-danger text-error color_error"></span>
                              </div>
                                <button type="submit" class="btn btn-primary">Add Color</button>
                          </form>
                      </div>
                      
                  </div>
                </div>
                  <div class="col-md-8">
                     <div class="card">
                        <div class="card-header">
                            List of Colors
                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
                            <table class="table table-striped table-inverse table-hover" id="colorTable">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>#</th>
                                        <th>Color</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                            </table>
                           </div>
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




   

   
