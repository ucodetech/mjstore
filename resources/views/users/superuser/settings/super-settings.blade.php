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
            <form action="{{ route('superuser.super.update.insert.setttings') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method("POST")
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="site_title">Site Title</label>
                            <input type="text" name="site_title" id="site_title" class="form-control" value="{{ ($settings ) ? $settings->site_title: old('site_title') }}">
                        </div>
                     
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" name="phone" id="phone" class="form-control" value="{{ ($settings ) ? $settings->phone: old('phone') }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="text" name="email" id="email" class="form-control" value="{{ ($settings ) ? $settings->email: old('email') }}">
                        </div>
                        <div class="form-group">
                            <label for="made_with">Made With: from ur footer area</label>
                            <input type="text" name="made_with" id="made_with" class="form-control" value="{{ ($settings ) ? $settings->made_with: old('made_with') }}">
                        </div>
                        <div class="form-group">
                            <label for="facebook_url">Facebook Link</label>
                            <input type="text" name="facebook_url" id="facebook_url" class="form-control" value="{{ ($settings ) ? $settings->facebook_url: old('facebook_url') }}">
                        </div>
                        <div class="form-group">
                            <label for="whatsapp_url">Whatsapp Link</label>
                            <input type="text" name="whatsapp_url" id="whatsapp_url" class="form-control" value="{{ ($settings ) ? $settings->whatsapp_url: old('whatsapp_url') }}">
                        </div>
                        <div class="form-group">
                            <label for="instagram_url">Instagram Link</label>
                            <input type="text" name="instagram_url" id="instagram_url" class="form-control" value="{{ ($settings ) ? $settings->instagram_url: old('instagram_url') }}">
                        </div>
                        <div class="form-group">
                            <label for="linkedin_url">Linkedin Link</label>
                            <input type="text" name="linkedin_url" id="linkedin_url" class="form-control" value="{{ ($settings ) ? $settings->linkedin_url: old('linkedin') }}">
                        </div>
                        <div class="form-group">
                            <label for="youtube_url">Youtube Link</label>
                            <input type="text" name="youtube_url" id="youtube_url" class="form-control" value="{{ ($settings ) ? $settings->youtube_url: old('youtube_url') }}">
                        </div>
                        <div class="form-group">
                            <label for="twitter_url">Twitter Link</label>
                            <input type="text" name="twitter_url" id="twitter_url" class="form-control" value="{{ ($settings ) ? $settings->twitter_url: old('twitter_url') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                       <div class="form-group">
                        <label for="meta_description">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="5">{{ (($settings ) ? $settings->meta_description : old('meta_description')) }}</textarea>
                       </div>
                       <div class="form-group">
                        <label for="address">Meta Keywords</label>
                        <textarea name="meta_keywords" class="form-control" rows="5">{{ (($settings ) ? $settings->meta_keywords : old('meta_keywords')) }}</textarea>
                       </div>
                       <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" class="form-control" rows="5">{{ (($settings ) ? $settings->address : old('address')) }}</textarea>
                       </div>
                      <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="site_logo">Site Logo</label>
                                <input type="file" name="site_logo" id="site_logo" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div id="previewLogo">
                                <img src="{{ asset('storage/uploads/settings/'.$settings->site_logo) }}" alt="Site logo" class="img-fluid" width="100">
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="favicon">Site Favicon</label>
                                <input type="file" name="favicon" id="favicon" class="form-control " value="{{ ($settings ) ? $settings->favicon: "" }}">
                                <input type="hidden" name="site_logo_saved" id="site_logo_saved" value="{{ $settings->site_logo }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div id="previewFavicon">
                                <img src="{{ asset('storage/uploads/settings/'.$settings->favicon) }}" alt="Site favicon" class="img-fluid" width="50">
                                <input type="hidden" name="favicon_saved" id="favicon_saved" value="{{ $settings->favicon }}">
                            </div>
                        </div>
                      </div>
                   
                    <div class="row">
                        <div class="form-group">
                            <button class="btn btn-outline-info">submit</button>
                        </div>
                    </div>
                    </div>
                </div>
            </form>
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection

@section('scripts')
  <script>
    function readURL(input,holder){
        if(input.files && input.files[0]){
            let reader = new FileReader();
            reader.onload =  function(e){
                $(holder).html('<label for=""><img src="'+e.target.result+'" alt="site logo" class="img-fluid" width="100px" height="100px"></label>');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(function(){
        $('#site_logo').on('change', function(e){
            e.preventDefault();
            let holder = $('#previewLogo');
            readURL(this, holder);
        });
        $('#favicon').on('change', function(e){
            e.preventDefault();
            let holder = $('#previewFavicon');
            readURL(this, holder);
        })
    })
  </script>
@endsection