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
                        <div class="card-header">
                            Add Banner
                        </div>
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data" id="addBannerForm">
                                <div class="form-group">
                                  <label for="banner-title">Title</label>
                                  <input type="text" name="banner_title" id="banner_title" class="form-control" 
                                  aria-describedby="helpId">
                                  <small id="helpId" class="text-danger text-error banner_title_error"></small>
                                </div>
                                <div class="form-group">
                                    <label for="slug_url">Slug Url: <sup class="text-danger">*</sup></label>
                                    <div class="input-group input-group-md">
                                      <input type="text" name="slug_url" id="slug_url" class="form-control" readonly>
                                      <span class="input-group-append">
                                        <button type="button" id="generateSlugurl" class="btn btn-info btn-flat">Generate</button>
                                      </span>
                                    </div>
                                    <span class="text-danger text-error slug_url_error"></span>
                                  </div>
                                  <div class="form-group">
                                    <label for=""></label>
                                    <textarea class="form-control" 
                                    name="description" id="banner_description" rows="3"></textarea>
                                  </div>
                                  <div class="form-group">
                                    <label for="Status">Status</label>
                                    <select class="custom-select" name="status" id="status">
                                        <option>Select status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="Status">Condition</label>
                                    <select class="custom-select" name="condition" id="condition">
                                        <option>Select condition</option>
                                        <option value="promo">Promo</option>
                                        <option value="banner">Banner</option>
                                    </select>
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



   

   
