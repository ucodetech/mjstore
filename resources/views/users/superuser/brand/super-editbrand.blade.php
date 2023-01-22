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
                                <img src="{{ asset('uploads/brands').'/'.$brand->photo }}" alt="{{ $brand->title }}" class="img-fluid">
                                <hr class="invisible">
                                <form action="{{ route('superuser.super.delete.brand.image') }}" method="post" enctype="multipart/form-data">
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
                            <form action="{{ route('superuser.super.update.brand') }}" method="POST" enctype="multipart/form-data"
                                >
                                @csrf
                                @method('POST')
                                <input type="hidden" name="brand_id" id="brand_id" value="{{ $brand->id }}"> 
                                <div class="form-group text-center">
                                    @if($brand->photo != '')
                                    <label for="edit_brand_file">Brand File</label>
                                    <input type="text" name="edit_brand_file" id="edit_brand_file"
                                     value="{{ $brand->photo }}" readonly class="form-control text-center"> 
                                    @else
                                    <input type="file" name="edit_brand_file" id="edit_brand_file" style="display:none">
                                    <label for="edit_brand_file" class="btn btn-outline-info">Select Image</label>
                                    <span class="text-danger text-error edit_brand_file_error"></span>
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

        function readURL(input){
          if(input.files && input.files[0]){
              let reader = new FileReader();
              reader.onload = function(e){
                  $('#showBrandPreview').html('<label for="edit_brand_file"><img src="'+e.target.result+'" alt="brand" class="img-fluid"></label>');
              }
              reader.readAsDataURL(input.files[0]);
          }
        }
        
         $(function(){
          
          $('#edit_brand_file').on('change', function(){
              readURL(this);
          })

        
       
    })

        </script>
@endsection 
   

   

   

   
