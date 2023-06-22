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
           
                {{-- <div class="card m-md-auto w-50">
                  <div class="card-header">Preveiw Product Category Image</div>
                  <div class="card-body" id="editshowProductCategoryPreview"></div>
                </div> --}}
                  <div class="card m-md-auto w-50">
                      <div class="card-header">
                          Edit <span class="text-warning">{{ $category->title }}</span> Category
                      </div>
                      <div class="card-body">
                        @if ($category->photo != '')
                          <img src="{{ asset('storage/uploads/products/category').'/'.$category->photo }}" alt="{{ $category->title }}" class="img-fluid">
                          <hr class="invisible">  
                          <form action="{{ route('superuser.super.delete.product.category.image') }}" method="post">
                            @csrf
                            @method('POST')  
                            <input type="hidden" name="category_id" id="category_id" value="{{ $category->id }}">
                              <button type="submit" class="btn btn-outline-danger"> <i class="fa fa-trash fa-lg"></i> </button>
                            </form>
                          @endif
                          <form action="{{ route('superuser.super.update.product.category') }}" method="POST" enctype="multipart/form-data"
                           >
                           @csrf
                           @method('POST')
                           <input type="hidden" name="category_id" id="category_id" value="{{ $category->id }}">

                            <div class="form-group text-center">
                                @if ($category->photo != '')
                                  <label for="edit_product_category_file">Photo</label>
                                  <input type="text" name="product_category_file" id="product_category_file"
                                  class="form-control" value="{{ $category->photo }}">
                                @else
                                  <input type="file" name="product_category_file" id="product_category_file">
                                  {{-- <label for="eproduct_category_file" class="btn btn-outline-info">Select Image</label> --}}
                                  <hr>
                                  {{-- <span class="text-danger text-error edit_product_category_file_error"></span> --}}
                              @endif
                            </div> 
                            <div class="form-group">
                                <label for="edit_product_category_title">Title</label>
                                <input type="text" name="edit_product_category_title" id="edit_product_category_title" class="form-control" 
                                aria-describedby="helpId" value="{{ $category->title }}">
                                <span  class="text-danger text-error edit_product_category_title_error"></span>
                              </div>
                              <div class="form-group">
                                  <label for="edit_product_category_slug_url">Slug Url: <sup class="text-danger">*</sup></label>
                                   <input type="text" name="edit_product_category_slug_url" id="edit_product_category_slug_url" class="form-control" readonly
                                    value="{{ $category->slug }}">
                                  <span class="text-danger text-error edit_product_category_slug_url_error"></span>
                                </div>
                                <div class="form-group">
                                  <label for="edit_product_category_summary">Summary</label>
                                  <textarea class="form-control" 
                                  name="edit_product_category_summary" id="edit_product_category_summary" rows="3">{{ $category->summary }}</textarea>
                                  <span class="text-danger text-error edit_product_category_summary_error"></span>
                                </div>
                               
                                <div class="form-group">
                                  <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                      <input class="form-check-input" type="checkbox"  name="edit_is_parent" id="edit_is_parent" value="1"
                                      {{ (($category->is_parent == 1)? ' checked':'') }}> Is Parent
                                    </label>
                                  </div>
                                  <span class="text-danger text-error edit_is_parent_error"></span>
                                </div>
                                <div class="form-group {{ (($category->is_parent == 1)? 'd-none':'') }}" id="editparentCategoryBtn">
                                  <label for="edit_parent_id">Parent Category</label>
                                  <select class="custom-select" name="edit_parent_id" id="edit_parent_id">
                                      <option value="">Select Parent Category</option>
                                        @foreach ($p_category as $p_cate)
                                            <option value="{{ $p_cate->id }}">{{ $p_cate->title }} - {{ $p_cate->id }}</option>
                                        @endforeach
                                  </select>
                                  <span class="text-danger text-error edit_parent_id_error"></span>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Update Category</button>
                          </form>
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
                      maxFileSize: '100KB',
                      acceptedFileTypes: ['image/png', 'image/jpeg']
          });

          FilePond.setOptions({
            server:{
                process:'../tmp-upload-category',
                revert:'../tmp-revert-category',
                headers:{
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            }
          });
        // function readURL(input){
        //   if(input.files && input.files[0]){
        //       let reader = new FileReader();
        //       reader.onload = function(e){
        //           $('#editshowProductCategoryPreview').html('<label for="edit_product_category_file"><img src="'+e.target.result+'" alt="product category" class="img-fluid"></label>');
        //       }
        //       reader.readAsDataURL(input.files[0]);
        //   }
        // }
        
         $(function(){
          
          // $('#edit_product_category_file').on('change', function(){
          //     readURL(this);
          // })
          $('#edit_product_category_summary').summernote();

        
          $('#edit_is_parent').on('change', function(e){
            e.preventDefault();
            let is_checked = $('#edit_is_parent').prop('checked');
          if(is_checked){
              $('#editparentCategoryBtn').addClass('d-none');
          }else{
              $('#editparentCategoryBtn').removeClass('d-none');
              $('#edit_parent_id').val('');
            }
        })


         })

        </script>
@endsection 
   

   
