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
                            List of Banners
                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
                            <table class="table table-striped table-inverse table-hover" id="bannerTableID">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>#</th>
                                        <th>Banner</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Condition</th>
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
                    <div class="card-header">Preveiw Banner</div>
                    <div class="card-body" id="showBannerPreview"></div>
                  </div>
                    <div class="card">
                        <div class="card-header">
                            Add Banner
                        </div>
                        <div class="card-body">
                            <form action="{{ route('superuser.super.add.banner') }}" method="POST" enctype="multipart/form-data"
                             id="addBannerForm">
                             @csrf
                             @method('POST')
                              <div class="form-group text-center">
                                <input type="file" name="banner_file" id="banner_file">
                                {{-- <label for="banner_file" class="btn btn-outline-info">Select Image</label> --}}
                                {{-- <hr> --}}
                                {{-- <span class="text-danger text-error banner_file_error"></span> --}}
                              </div> 
                              <div class="form-group">
                                  <label for="banner-title">Title</label>
                                  <input type="text" name="banner_title" id="banner_title" class="form-control" 
                                  aria-describedby="helpId">
                                  <span  class="text-danger text-error banner_title_error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="slug_url">Slug Url: <sup class="text-danger">*</sup></label>
                                    <div class="input-group input-group-md">
                                      <input type="text" name="banner_slug_url" id="banner_slug_url" class="form-control" readonly>
                                      <span class="input-group-append">
                                        <button type="button" id="generateBannerSlugurl" class="btn btn-info btn-flat">Generate</button>
                                      </span>
                                    </div>
                                    <span class="text-danger text-error banner_slug_url_error"></span>
                                  </div>
                                  <div class="form-group">
                                    <label for="price_description">Price Description</label>
                                    <input type="text" name="price_description" id="price_description" class="form-control" 
                                    aria-describedby="helpId">
                                  </div>
                                  <div class="form-group">
                                    <label for="link">Link</label>
                                    <input type="text" name="link" id="link" class="form-control" 
                                    aria-describedby="helpId">
                                  </div>
                                  <div class="form-group">
                                    <label for="link_descriptions">Link Description</label>
                                    <input type="text" name="link_descriptions" id="link_descriptions" class="form-control" 
                                    aria-describedby="helpId">
                                  </div>
                                  <div class="form-group">
                                    <label for="banner_description">Description</label>
                                    <textarea class="form-control" 
                                    name="banner_description" id="banner_description" rows="3"></textarea>
                                    <span class="text-danger text-error banner_description_error"></span>
                                  </div>
                                  <div class="form-group">
                                    <label for="banner_status">Status</label>
                                    <select class="custom-select" name="banner_status" id="banner_status">
                                        <option value="">Select status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    <span class="text-danger text-error banner_status_error"></span>
                                  </div>
                                  <div class="form-group">
                                    <label for="banner_condition">Condition</label>
                                    <select class="custom-select" name="banner_condition" id="banner_condition">
                                        <option value="">Select condition</option>
                                        <option value="promo">Promo</option>
                                        <option value="banner">Banner</option>
                                    </select>
                                    <span class="text-danger text-error banner_condition_error"></span>
                                  </div>
                                  <button type="submit" class="btn btn-primary">Add Banner</button>
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

@section('scripts')

<script>
  // Create the FilePond instance
  const pond = FilePond.create(inputElement, {
                maxFileSize: '100KB',
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/gif'],
                

            });

        FilePond.setOptions({
        server:{
            process: 'tmp-upload-banner',
            revert: 'tmp-revert-banner',
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }
        });
</script>

@endsection

   

   
