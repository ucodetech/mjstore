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
                            List of Brands
                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
                            <table class="table table-striped table-inverse table-hover" id="brandTableID">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>#</th>
                                        <th>Brand</th>
                                        <th>Title</th>
                                        <th>Brand Slug</th>
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
                    <div class="card-header">Preveiw Brand</div>
                    <div class="card-body" id="showBrandPreview"></div>
                  </div>
                    <div class="card">
                        <div class="card-header">
                            Add Brand
                        </div>
                        <div class="card-body">
                            <form action="{{ route('superuser.super.add.brand') }}" method="POST" enctype="multipart/form-data"
                             id="addBrandForm">
                             @csrf
                             @method('POST')
                              <div class="form-group text-center">
                                <input type="file" name="brand_file" id="brand_file" style="display:none">
                                <label for="brand_file" class="btn btn-outline-info">Select Image</label>
                                <hr>
                                <span class="text-danger text-error brand_file_error"></span>
                              </div> 
                              <div class="form-group">
                                  <label for="brand_title">Title</label>
                                  <input type="text" name="brand_title" id="brand_title" class="form-control" 
                                  aria-describedby="helpId">
                                  <span  class="text-danger text-error brand_title_error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="slug_url">Slug Url: <sup class="text-danger">*</sup></label>
                                    <div class="input-group input-group-md">
                                      <input type="text" name="brand_slug_url" id="brand_slug_url" class="form-control" readonly>
                                      <span class="input-group-append">
                                        <button type="button" id="generateBrandSlugurl" class="btn btn-info btn-flat">Generate</button>
                                      </span>
                                    </div>
                                    <span class="text-danger text-error brand_slug_url_error"></span>
                                  </div>
                                  
                                  <div class="form-group">
                                    <label for="brand_status">Status</label>
                                    <select class="custom-select" name="brand_status" id="brand_status">
                                        <option value="">Select status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    <span class="text-danger text-error brand_status_error"></span>
                                  </div>
                                 
                                  <button type="submit" class="btn btn-primary">Add Brand</button>
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



   

   
