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
                                <input type="file" name="banner_file" id="banner_file" style="display:none">
                                <label for="banner_file" class="btn btn-outline-info">Select Image</label>
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



   

   
