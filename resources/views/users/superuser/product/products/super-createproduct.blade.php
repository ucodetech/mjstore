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
               <div class="card">
                <div class="card-header">
                <h3 class="card-title">Add Product</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
               </div>
                <div class="card-body table-responsive">
                   
                   <form action="{{ route('superuser.super.process.product.create') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="product_title">Product Title: 
                                <sup class="text-danger"></sup></label>
                                <input type="text" name="product_title" 
                                id="product_title" class="form-control" value="{{ old('product_title') }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="product_stock">Product Stock: 
                                <sup class="text-danger"></sup></label>
                                <input type="number" name="product_stock" 
                                id="product_stock" class="form-control" value="{{ old('product_stock') }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="product_weights">Product Weights: 
                                <sup class="text-danger"></sup></label>
                                <input type="number" name="product_weights" 
                                id="product_weights" class="form-control" value="{{ old('product_weights') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="product_price">Product Price: 
                                <sup class="text-danger"></sup></label>
                                <input type="number" name="product_price" 
                                id="product_price" class="form-control" value="{{ old('product_price') }}" step=".01">
                        </div>
                       
                        <div class="form-group col-md-4">
                            <label for="product_discount">Product Discount: 
                                <sup class="text-danger"></sup></label>
                                <input type="number" name="product_discount" 
                                id="product_discount" class="form-control"   value="{{ old('product_discount') }}" step=".01">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Size</label>
                            <select class="select2" name="product_size[]" id="product_size" multiple="multiple" data-placeholder="Select a Size" style="width: 100%;">
                              @foreach ($sizes as $size)
                                    <option class="bg-info" value="{{ $size->size }}">{{ $size->size }}</option>                                  
                              @endforeach
                            </select>
                          </div>
                        
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="product_brand">Product Brand: 
                                <sup class="text-danger"></sup></label>
                                <select name="product_brand" id="product_brand" 
                                class="form-control">
                                <option value="">---Select Brand---</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="product_category">Product Category: 
                                <sup class="text-danger"></sup></label>
                                <select name="product_category" id="product_category" 
                                class="form-control">
                                <option value="">---Select Category---</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="product_child_category">Product Child Category: 
                                <sup class="text-danger"></sup></label>
                                <select name="product_child_category" id="product_child_category" 
                                class="form-control">
                            
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="product_condition">Product Condition: 
                                <sup class="text-danger"></sup></label>
                                <select name="product_condition" id="product_condition" 
                                class="form-control">
                                <option value="">---Select Condition---</option>
                                @foreach ($conditions as $condition)
                                    <option value="{{ strtolower($condition->condition)}}">{{ $condition->condition }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="product_status">Product Status: 
                                <sup class="text-danger"></sup></label>
                                <select name="product_status" id="product_status" 
                                class="form-control">
                                <option value="">---Select Status---</option>
                                @php
                                    $status = ['active', 'inactive'];
                                @endphp
                                @foreach ($status as $statu)
                                    <option value="{{ $statu}}">{{ $statu }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                          
                                <label>Product Color</label>
                                <select class="select2" name="product_color[]" id="product_color" multiple="multiple" data-placeholder="Select a Color(s)" style="width: 100%;">
                                  @foreach ($colors as $color)
                                        <option class="bg-info" value="{{ $color->color }}">{{ $color->color }}</option>                                  
                                  @endforeach
                                </select>
                            </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="product_summary">Product Summary <sup class="text-danger">*</sup></label>
                            <textarea name="product_summary" id="product_summary"  rows="10">{{ old('product_summary') }}</textarea> 
                        </div>
                        <div class="form-group col-md-6">
                            <label for="product_description">Product Descriptions <sup class="text-danger">*</sup></label>
                            <textarea name="product_description" id="product_description"  rows="10">{{ old('product_description') }}</textarea>
                        </div>
                    </div>
                     <!-- /.row -->
                    <div class="row">
                        <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                            <h3 class="card-title">Upload Product Image</small></h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="product_file">Product File</label>
                                    <input type="file" name="product_file" id="product_file" class="">
                                </div>
                                {{-- <div class="input-group">
                                    <span class="input-group-btn">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                        <i class="fa fa-picture-o"></i> Choose
                                    </a>
                                    </span>
                                    <input id="thumbnail" class="form-control" type="text" name="product_file">
                                </div>
                                <div id="holder" style="margin-top:15px;max-height:100px;"> </div> --}}
            
                                
                            </div>
                            
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div id="productPhoto"></div>
                            
                            </div>
                        </div>
                        <!-- /.card -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-outline-info">Add Product</button>
                        </div>
                    </div>
                    <!-- /.row -->
                    </form>
                        
                            </div>
                            <div class="card-footer text-muted">
                                <button class="btn text-light">
                                    Total Products Added  <span class="badge badge-info">{{ $product_count }}</span>
                                </button>
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
            process: "{{ route('superuser.tmp.product.upload') }}",
            revert: "{{ route('superuser.super.delete.temp.files') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          }
            }
        });

    $(function(){
            // fetch child category when parent category is selected
            $('#product_category').on('change', function(e){
                e.preventDefault()
                let parent_cat = $(this).val();
                let url = 'super-get-child-cat';
                let html_option='<option value="">---Select Child Category----</option>';
                $.post(url, {parent_cat:parent_cat}, function(response){
                    if(response.status == true){
                        $.each(response.data, function(id, title){
                            html_option+='<option value="'+id+'">'+title+'</option>';
                            $('#product_child_category').html(html_option);
                        })
                    }else{
                        toastr.error(response.msg);
                        $('#product_child_category').html('');
                    }
                   
                });
                    
                
        });
                   
       
     
        
    });
 
  </script>
@endsection

