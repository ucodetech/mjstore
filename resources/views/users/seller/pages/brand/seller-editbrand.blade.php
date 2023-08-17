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
                    <div class="card justify-content-center w-50 m-md-auto">
                        <div class="card-body" id="showBrandPreview">
                            @if($brand->photo != '')
                                <img src="{{ asset('storage/uploads/brands').'/'.$brand->photo }}" alt="{{ $brand->title }}" class="img-fluid">
                                <hr class="invisible">
                                <form action="{{ route('seller.vendor.delete.brand.image') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="brand_id" id="brand_id" value="{{ $brand->id }}">
                                    <button class="btn btn-danger"><i class="fa fa-trash fa-2x"></i></button>
                                </form>
                                @endif
                        </div>
                    </div>
                
                    <div class="card justify-content-center w-50 m-md-auto">
                        <div class="card-header">
                            Edit Brand
                        </div>
                        <div class="card-body">
                            <form action="{{ route('seller.vendor.update.brand') }}" method="POST" enctype="multipart/form-data"
                                >
                                @csrf
                                @method('POST')
                                <input type="hidden" name="brand_id" id="brand_id" value="{{ $brand->id }}"> 
                                <div class="form-group text-center">
                                    @if($brand->photo != '')
                                    <label for="brand_file">Brand File</label>
                                    <input type="text" name="brand_file" id="brand_file"
                                     value="{{ $brand->photo }}" readonly class="form-control text-center"> 
                                    @else
                                    <input type="file" name="brand_file" id="brand_file">
                                    {{-- <label for="edit_brand_file" class="btn btn-outline-info">Select Image</label> --}}
                                    {{-- <span class="text-danger text-error edit_brand_file_error"></span> --}}
                                    @endif
                                </div> 
                                <div class="form-group">
                                    <label for="edit_brand_title">Title</label>
                                    <input type="text" name="edit_brand_title" id="edit_brand_title" class="form-control" 
                                    value="{{ $brand->title }}">
                                    <span  class="text-danger text-error edit_brand_title_error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="edit_brand_slug_url">Slug Url: <sup class="text-danger">*</sup></label>
                                        <input type="text" name="edit_brand_slug_url" id="edit_brand_slug_url" 
                                        class="form-control" readonly value="{{ $brand->slug }}">
                                    <span class="text-danger text-error edit_brand_slug_url_error"></span>
                                </div>
                                <span class="text-danger">Note: Search for categories that is related to your products and select for the brand!</span>
                                <div class="form-group">
                                  <label for="brand_category_id">Category: 
                                      <sup class="text-danger">*</sup></label>
                                      <select name="brand_category_id[]" id="brand_category_id" 
                                      class="form-control select2 w-100" placeholder="---Select Category---" multiple>
                                      <option value=""></option>
                                      @foreach ($categories as $category)
                                          <option value="{{ $category->id }}" {{ ($brand->category_id == $category->id)? " selected" : ""  }}>{{ $category->title }}</option>
                                      @endforeach
                                  </select>
                              </div>
                            <button type="submit" class="btn btn-primary">Update Brand</button>
                            </form>
                        </div>
                        
                    </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
        <script>
            
            const pond = FilePond.create(inputElement,{
                    maxFileSize: '100KB',
                    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/gif'],
                });

            FilePond.setOptions({
                server:{
                    process:'../tmp-upload-brand',
                    revert:'../tmp-revert-brand',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        
                    }

                }
            });


    //     // function readURL(input){
    //     //   if(input.files && input.files[0]){
    //     //       let reader = new FileReader();
    //     //       reader.onload = function(e){
    //     //           $('#showBrandPreview').html('<label for="edit_brand_file"><img src="'+e.target.result+'" alt="brand" class="img-fluid"></label>');
    //     //       }
    //     //       reader.readAsDataURL(input.files[0]);
    //     //   }
    //     // }
        
         $(function(){
          
          // Initialize Select2 Elements
            $('.select2').select2()
            bsCustomFileInput.init();
        
       
      })

        </script>
@endsection 
   

   

   

   
