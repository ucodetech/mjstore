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
           
                  <div class="card m-md-auto w-50">
                      <div class="card-header">
                          Add Size
                      </div>
                      <div class="card-body">
                          <form action="{{ route('superuser.super.add.sizes') }}" method="POST"
                           id="addSizeForm">
                           @csrf
                           @method('POST')
                            
                            <div class="form-group">
                                <label for="size">Size</label>
                                <input type="text" name="size" id="size" class="form-control" 
                                aria-describedby="helpId">
                                <span  class="text-danger text-error size_error"></span>
                              </div>
                                <button type="submit" class="btn btn-primary">Add Size</button>
                          </form>
                      </div>
                      
                  </div>
                  <hr>
               
                     <div class="card">
                        <div class="card-header">
                            List of Sizes
                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
                            <table class="table table-striped table-inverse table-hover" id="sizeTable">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>#</th>
                                        <th>Size</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                            </table>
                           </div>
                        </div>
                        
                     </div>
               
                
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection




   

   
