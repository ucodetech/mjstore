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
                   
                   <form action="{{ route('superuser.super.update.product') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="product_title">Product Title: 
                                <sup class="text-danger"></sup></label>
                                <input type="text" name="product_title" 
                                id="product_title" class="form-control" value="{{ $product->title }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="product_stock">Product Stock: 
                                <sup class="text-danger"></sup></label>
                                <input type="number" name="product_stock" 
                                id="product_stock" class="form-control" value="{{ $product->stock }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="product_weights">Product Weights: 
                                <sup class="text-danger"></sup></label>
                                <input type="number" name="product_weights" 
                                id="product_weights" class="form-control" value="{{ $product->weights }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="product_price">Product Price: 
                                <sup class="text-danger"></sup></label>
                                <input type="number" name="product_price" 
                                id="product_price" class="form-control" value="{{ $product->price }}" step=".01">
                        </div>
                       
                        <div class="form-group col-md-4">
                            <label for="product_discount">Product Discount: 
                                <sup class="text-danger"></sup></label>
                                <input type="number" name="product_discount" 
                                id="product_discount" class="form-control"   value="{{ $product->product_discount }}" step=".01">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Size</label>
                            <input type="text" id="product_size" name="product_size" class="form-control" value="{{ $product->size }}">
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
                                    <option value="{{ $brand->id }}" {{ (($product->brand_id == $brand->id)? ' selected':'') }}>{{ $brand->title }}</option>
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
                                    <option value="{{ $category->id }}" {{ (($product->cat_id == $category->id)? ' selected':'') }}>{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="child_cat" id="child_cat" value="{{ $product->child_cat_id }}">
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
                                    <option value="{{ $condition->condition}}" {{ (($product->condition == $condition->condition)? ' selected':'') }}>{{ $condition->condition }}</option>
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
                                    <option value="{{ $statu}}" {{ (($product->status == $statu)? ' selected':'') }}>{{ $statu }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                          
                                <label>Product Color</label>
                                <input type="text" name="product_color" id="product_color" class="form-control" value="{{ $product->color }}">
                                
                            </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="product_summary">Product Summary <sup class="text-danger">*</sup></label>
                            <textarea name="product_summary" id="product_summary"  rows="10">{{ $product->summary }}</textarea> 
                        </div>
                        <div class="form-group col-md-6">
                            <label for="product_description">Product Descriptions <sup class="text-danger">*</sup></label>
                            <textarea name="product_description" id="product_description"  rows="10">{{ $product->description }}</textarea>
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
                        @if($product->photo != '')
                        <input type="text" readonly name="product_file_saved" id="product_file_saved" class="form-control" value="{{ $product->photo }}">
                        @else
                        
                        <input type="file" class="" name="product_file" id="product_file">
                          
                          {{-- <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                          </div> --}}
                        </div>
                        @endif
                      </div>
                
                      
                </div>
                
                <!-- /.card-body -->
                <div class="card-footer">
                    <div id="productPhoto"> </div>
                   
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-12">
              <button type="submit" class="btn btn-outline-info">Update Product</button>
            </div>
          </div>
          <!-- /.row -->
          </form>
          <hr>
          <div class="card">
            <div class="card-header">
                Product Image
            </div>
            <div class="card-body">
               
                @if($product->photo != '')
                @php
                    $photos  = explode(',',$product->photo);
                @endphp
                <div class="row">
                @foreach ($photos as $photo)
                    <div class="col-md-3">
                        <img src="{{ asset('storage/uploads/products') .'/'.$photo }}" alt="" class="img-fuild product-image-thumb">
                    <hr class="invisible">
                    <form action="{{ route('superuser.super.delete.product.image') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="photo" id="photo" value="{{ $photo }}">
                        <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                        <button class="btn btn-outline-danger"><i class="fa fa-trash"></i></button>
                    </form>
                    </div>
                @endforeach
             </div>
                    
                 @endif
            </div>
            
          </div>
          
               
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
           
// function readURLProd(input){
//     if(input.files && input.files[0]){
//         let reader = new FileReader();
//         reader.onload = function(e){
//             $('#productPhoto').html('<label for="product_file"><img src="'+e.target.result+'" alt="product image" class="img-fluid" width="100px" height="100px"></label>');
//         }
//         reader.readAsDataURL(input.files[0]);
//     }
// }
  // Create the FilePond instance
  const pond = FilePond.create(inputElement, {
                maxFileSize: '100KB',
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/gif'],
                

            });

        FilePond.setOptions({
        server:{
            process: '../tmp-upload-product',
            revert: '../tmp-revert-product',
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }
        });

    $(function(){
            // fetch child category when parent category is selected
           
        //     $('#product_category').on('change', function(e){
        //         e.preventDefault()
        //         let parent_cat = $(this).val();
        //         let url = '../super-get-child-cat';
        //         let html_option='<option value="">---Select Child Category----</option>';
        //         $.post(url, {parent_cat:parent_cat}, function(response){
        //             if(response.status == true){
        //                 $.each(response.data, function(id, title){
        //                     html_option+='<option value="'+id+'" '+product_child_category==id? ' selected':''+'>'+title+'</option>';
        //                     $('#product_child_category').html(html_option);
        //                 })
        //             }else{
        //                 toastr.error(response.msg);
        //                 $('#product_child_category').html('');
        //             }
                   
        //         })
                    
                
        // })
        let product_child_category = $('#child_cat').val();
        getchildCategory(product_child_category);

        function getchildCategory(selected){
            if(typeof selected === 'undefined'){
               let selected = '';
            }
                let url = "{{ route('superuser.get.product.child.cat') }}";
                let token = "{{ csrf_token() }}";
                let parent_id = $('#product_category').val();
                console.log(selected)
                $.ajax({
                    url:url,
                    method:'get',
                    data:{
                        selected:selected,
                        parent_id:parent_id,
                        token:token
                    },
                    success:function(data){
                        $('#product_child_category').html(data);
                    }
                })
            
        }
           
            $('#product_category').on('change', function(e){
                e.preventDefault();
                getchildCategory();
            });
            


   
    $('#product_summary').summernote();
    $('#product_description').summernote();


    // $('#product_file').on('change', function(){
    //     readURLProd(this);
        
    // })
  // Initialize Select2 Elements
    $('.select2').select2()
    //  bsCustomFileInput.init();
    // Initialize Select2 Elements
    // $('.select2bs4').select2({
    //   theme:'bootstrap4'
    // })

      
        
    })
  </script>
@endsection

