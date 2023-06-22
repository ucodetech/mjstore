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
                        <div class="card-body" id="showBannerPreview">
                            @if($banner->photo != '')
                                <img src="{{ asset('uploads/banners').'/'.$banner->photo }}" alt="{{ $banner->title }}" class="img-fluid">
                                <hr class="invisible">
                                <form action="{{ route('superuser.super.delete.banner.image') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="banner_id" id="banner_id" value="{{ $banner->id }}">
                                    <button class="btn btn-danger"><i class="fa fa-trash fa-2x"></i></button>
                                </form>
                                @endif
                        </div>
                    </div>
                     <div class="card justify-content-center w-50 m-md-auto">
                        <div class="card-header">
                            Edit Banner
                        </div>
                        <div class="card-body">

                            <form action="{{ route('superuser.super.update.banner') }}" method="POST" enctype="multipart/form-data"
                                     id="updateBannerForm">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="banner_id" id="banner_id" value="{{ $banner->id }}">
                            @if($banner->photo == '')
                            <div class="form-group text-center">
                                <input type="file" name="banner_file" id="banner_file">
                                {{-- <label for="banner_file" class="btn btn-outline-info">Select Image</label> --}}
                            <hr>
                            <span class="text-danger text-error banner_file_error"></span>
                            </div> 
                            @else
                            <div class="form-group">
                                <label for="banner_file">Banne file</label>
                                <input type="text" name="banner_file" id="banner_file" class="form-control" value="{{ $banner->photo }}">
                            </div> 
                            @endif

                            <div class="form-group">
                                <label for="banner-title">Title</label>
                                <input type="text" name="edit_banner_title" id="edit_banner_title" class="form-control" 
                                value="{{ $banner->title }}">
                                <span  class="text-danger text-error edit_banner_title_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="edit_banner_slug_url">Slug Url: <sup class="text-danger">*</sup></label>
                                    <input type="text" name="edit_banner_slug_url" id="edit_banner_slug_url" 
                                    class="form-control" value="{{ $banner->slug }}" readonly>
                                     <span class="text-danger text-error edit_banner_slug_url_error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="edit_price_description">Price Description</label>
                                    <input type="text" name="edit_price_description" id="edit_price_description" class="form-control" value="{{ $banner->price_description }}"
                                    aria-describedby="helpId">
                                  </div>
                                  <div class="form-group">
                                    <label for="edit_link">Link</label>
                                    <input type="text" name="edit_link" id="edit_link" class="form-control" value="{{ $banner->link }}"
                                    aria-describedby="helpId">
                                  </div>
                                  <div class="form-group">
                                    <label for="edit_link_descriptions">Link Description</label>
                                    <input type="text" name="edit_link_descriptions" id="edit_link_descriptions" class="form-control" value="{{ $banner->link_descriptions }}"
                                    aria-describedby="helpId">
                                  </div>
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea class="form-control" 
                                    name="edit_banner_description" id="edit_banner_description" rows="3">{{ $banner->description }}</textarea>
                                    <span class="text-danger text-error edit_banner_description_error"></span>
                                </div>
                                   <button type="submit" class="btn btn-primary">Edit Banner</button>
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

// function readURLBanner(input){
//     if(input.files && input.files[0]){
//         let reader = new FileReader();
//         reader.onload = function(e){
//             $('#showBannerPreview').html('<label for="banner_file"><img src="'+e.target.result+'" alt="banner" class="img-fluid"></label>');
//         }
//         reader.readAsDataURL(input.files[0]);
//     }
// }

//    $(function(){
//         $('#banner_file').on('change', function(){
//             readURLBanner(this);
//         })
//    })

    const pond = FilePond.create(inputElement,{
                    maxFileSize: '100KB',
                    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/gif'],
                });

    FilePond.setOptions({
        server:{
            process:'../tmp-upload-banner',
            revert:'../tmp-revert-banner',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                
            }

        }
    });



    $(function(){
    $('#edit_banner_description').summernote()

    // function readURL(input){
    //     if(input.files && input.files[0]){
    //         let reader = new FileReader();
    //         reader.onload = function(e){
    //             $('#editbannerPreview').html('<label for="banner_file"><img src="'+e.target.result+'" alt="banner" class="img-fluid"></label>');
    //         }
    //         reader.readAsDataURL(input.files[0]);
    //     }
    // }

    // $('#edit_banner_file').on('change', function(){
    //         readURL(this);
    //     })
    
    
  })

  </script>
@endsection
   

   
