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
           
                {{-- <div class="card m-md-auto w-50">
                  <div class="card-header">Preveiw Product Category Image</div>
                  <div class="card-body" id="showProductCategoryPreview"></div>
                </div> --}}
                  <div class="card m-md-auto w-50">
                      <div class="card-header d-flex justify-content-between">
                          <h4>Add Product Category</h4>
                          <button id="toggleForm" class="btn btn-sm btn-info">Toggle Form</button>
                      </div>
                      <div class="card-body" id="showForm">
                          <form action="{{ route('seller.vendor.add.product.category') }}" method="POST" enctype="multipart/form-data"
                           id="addProductCategoryForm">
                           @csrf
                           @method('POST')
                            <div class="form-group text-center">
                              <input type="file" name="product_category_file" id="product_category_file">
                              {{-- <label for="product_category_file" class="btn btn-outline-info">Select Image</label> --}}
                              <hr>
                              {{-- <span class="text-danger text-error product_category_file_error"></span> --}}
                            </div> 
                            <div class="form-group">
                                <label for="product_category_title">Title</label>
                                <input type="text" name="product_category_title" id="product_category_title" class="form-control" 
                                aria-describedby="helpId">
                                <span  class="text-danger text-error product_category_title_error"></span>
                              </div>
                              <div class="form-group">
                                  <label for="product_category_slug_url">Slug Url: <sup class="text-danger">*</sup></label>
                                  <div class="input-group input-group-md">
                                    <input type="text" name="product_category_slug_url" id="product_category_slug_url" class="form-control" readonly>
                                    <span class="input-group-append">
                                      <button type="button" id="generateProductCategorySlugurl" class="btn btn-info btn-flat">Generate</button>
                                    </span>
                                  </div>
                                  <span class="text-danger text-error product_category_slug_url_error"></span>
                                </div>
                                <div class="form-group">
                                  <label for="product_category_summary">Summary</label>
                                  <textarea class="form-control" 
                                  name="product_category_summary" id="product_category_summary" rows="3"></textarea>
                                  <span class="text-danger text-error product_category_summary_error"></span>
                                </div>
                                <div class="form-group">
                                  <label for="product_category_status">Status</label>
                                  <select class="custom-select" name="product_category_status" id="product_category_status">
                                      <option value="">Select status</option>
                                      <option value="active">Active</option>
                                      <option value="inactive">Inactive</option>
                                  </select>
                                  <span class="text-danger text-error product_category_status_error"></span>
                                </div>
                                <div class="form-group">
                                  <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                      <input class="form-check-input" type="checkbox"  name="is_parent" id="is_parent" value="1" checked> Is Parent
                                    </label>
                                  </div>
                                  <span class="text-danger text-error is_parent_error"></span>
                                </div>
                                <div class="form-group d-none" id="parentCategoryBtn">
                                  <label for="parent_id">Parent Category</label>
                                  <select class="custom-select" name="parent_id" id="parent_id">
                                      <option value="">Select Parent Category</option>
                                      @foreach ($product_category as $p_cate)
                                          <option value="{{ $p_cate->id }}">{{ $p_cate->title }} - {{ $p_cate->id }} {{ $p_cate->is_parent == 1 ? ' --Parent--':'' }}</option>
                                      @endforeach
                                  </select>
                                  <span class="text-danger text-error parent_id_error"></span>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Add Category</button>
                          </form>
                      </div>
                      
                  </div>
                  <hr>
               
                     <div class="card">
                        <div class="card-header">
                            List of Product Categories
                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
                            <table class="table table-striped table-inverse table-hover" id="productCategoryTableID">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>#</th>
                                        <th>Photo</th>
                                        <th>Category</th>
                                        <th>Category ID</th>
                                        <th>Is Parent</th>
                                        <th>Parent</th>
                                        <th>Status</th>
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

@section('scripts')

<script>
  const pond = FilePond.create(inputElement, {
              maxFileSize: '500KB',
              acceptedFileTypes: ['image/png', 'image/jpeg']
  });

  FilePond.setOptions({
        server:{
          process:'tmp-upload-category',
          revert: 'tmp-revert-category',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          }
        }
  });


  $(function(){

    $('#toggleForm').on('click', function(e){
      e.preventDefault();
      $('#addProductCategoryForm').toggle('slow', 'swing');
    })

  })

</script>

@endsection
   

   
