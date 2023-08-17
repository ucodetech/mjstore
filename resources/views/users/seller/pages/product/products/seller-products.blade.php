@extends('layouts.sellerapp')
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
                <h3 class="card-title">List of Products  <a href="{{ route('seller.vendor.add.product.page') }}"
                    class="btn btn-info">Add Product</a></h3>

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
                        <table class="table table-bordered table-condensed table-hover" id="sellerproductsTable">
                            <thead>
                                <th>#</th>
                                <th>Add Attr</th>
                                <th>Photo</th>
                                <th>Title</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th>Sales Price</th>
                                <th>Discount</th>
                                <th>Size</th>
                                <th>Weights</th>
                                <th>Category</th>
                                <th>Child Category</th>
                                <th>Brand</th>
                                <th>Condition</th>
                                <th>Featured</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Add Image</th>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                @php
                                    $photo = explode(',',$product->photo);
                                @endphp
                                
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <th>
                                        <a class="btn btn-default btn-sm mb-1" href="{{ route('seller.vendor.add.product.attribute',$product->unique_key) }}">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                        <a class="btn btn-info btn-sm" href="{{ route('seller.vendor.product.information',$product->unique_key) }}" title="Add Additional Information">
                                            <i class="fa fa-plus-circle"></i>
                                        </a>
                                    </th>
                                    <td>
                                        <img src="{{ asset('storage/uploads/products').'/'.$photo[0] }}" 
                                        alt="{{ $product->title }}" class="img-fluid product-image-thumb" width="50">
                                    </td>
                                    
                                    <td>{{ wrap2($product->title) }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ Naira($product->price)}}</td>
                                    <td>{{ Naira($product->sales_price) }}</td>
                                    <td>{{ Naira($product->product_discount) }}</td>
                                    <td>{{ $product->size }}</td>
                                    <td>{{ $product->weights }}</td>
                                    <td>{{ App\Models\ProductCategory::where('id', $product->cat_id)->get()->first()->title; }}</td>
                                    <td>
                                        @if($product->child_cat_id != '')
                                        {{ App\Models\ProductCategory::where('id', $product->child_cat_id)->get()->first()->title;}}
                                        @else
                                            <span class="badge badge-pill badge-danger">No Child Cat</span>
                                        @endif
                                    </td>
                                    <td>{{ $product->brand->title }}</td>
                                    <td>
                                    @if ($product->condition === 'new')
                                        <span class="badge badge-info">{{ $product->condition }}</span>
                                    @else
                                    <span class="badge badge-info">{{ $product->condition }}</span>
                                    @endif
                                    </td>
                                    <td>
                                        {{-- <input type="checkbox" 
                                        class="productToggle"
                                        data-id="{{ $product->id }}"
                                        data-url="{{ route('seller.vendor.toggle.status.product') }}"
                                        data-token="{{ csrf_token() }}"
                                        data-toggle="switchbutton"   
                                        data-onlabel="Active" 
                                        data-offlabel="In Active" 
                                        data-onstyle="success" 
                                        data-offstyle="danger"
                                        {{ (($product->status =='active')? ' checked':'') }}> --}}
                                        @if ($product->status == 'active')
                                            {{-- <button type="button" class="btn btn-danger" 
                                            data-id="{{ $product->id }}"
                                            id="deactivateProduct"
                                            data-url="{{ route('seller.vendor.toggle.status.product') }}">
                                            Deactivate
                                            </button> --}}
                                            <form action="{{ route('seller.vendor.toggle.status.product') }}" method="POST">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="mode" id="mode" value="deactivate">
                                                <input type="submit" value="Deactivate" class="btn btn-outline-danger btn-rounded">
                                            </form>
                                        @else
                                        {{-- <button type="button" class="btn btn-success" 
                                        data-id="{{ $product->id }}"
                                        id="activateProduct"
                                        data-url="{{ route('seller.vendor.toggle.status.product') }}">
                                        Activate
                                        </button> --}}
                                        <form action="{{ route('seller.vendor.toggle.status.product') }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="mode" id="mode" value="activate">
                                            <input type="submit" value="Activate" class="btn btn-outline-success btn-rounded">
                                        </form>
                                        @endif
                                        
                                    </td>
                                    <td>
                                        @if ($product->featured == 1)
                                        
                                        <form action="{{ route('seller.vendor.toggle.featured.product') }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="mode" id="mode" value="0">
                                            <input type="submit" value="Unfeature" class="btn btn-outline-danger btn-rounded">
                                        </form>
                                    @else
                                  
                                    <form action="{{ route('seller.vendor.toggle.featured.product') }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="mode" id="mode" value="1">
                                        <input type="submit" value="Feature" class="btn btn-outline-success btn-rounded">
                                    </form>
                                    @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info" id="viewProduct" data-uniquekey="{{ $product->unique_key }}"
                                                data-url="{{ route('seller.vendor.detail.product') }}"
                                                ><i class="fa fa-eye"></i>
                                            </button>
                                            <a class="btn btn-success" href="{{ route('seller.vendor.edit.product', $product->unique_key) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger" id="deleteProduct" data-id="{{ $product->id }}"
                                                data-url="{{ route('seller.vendor.delete.product') }}"
                                                >
                                                <i class="fa fa-trash"></i>
                                            </button>
                                    
                                        </div>
                                    </td>
                                    <td>
                                        <button  id="addMoreimage" data-title="{{ $product->title }}" data-id="{{ $product->id }}" class="btn btn-sm btn-warning" title="Add more images"><i class="fa fa-plus-square"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            
                            </tbody>
                        </table>
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
  <div class="modal fade" id="productDetail">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Product Detail</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="showProductDetails">
          
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  {{-- add more image to product modal --}}
  <!-- Modal -->
  <div class="modal fade" id="addMoreImageModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">Add More Images to <span class="text-info" id="product_title"></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
            <div class="modal-body">
                <div class="container-fluid">
                   <form action="{{ route('seller.vendor.upload.more.images') }}" enctype="multipart/form-data" method="POST" id="addMoreImageForm">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="product_id_use" id="product_id_use">
                    <input type="file" name="product_file" id="product_file">
                    <span class="text-error text-danger product_file_error"></span>
                    <button type="submit" class="btn btn-info btn-block">Upload</button>
                </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
  </div>
  
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
  <script>

    const pond = FilePond.create(inputElement, {
        acceptedFileTypes: ['image/png', 'image/jpeg'],
        maxFileSize: '500KB'
    });

    FilePond.setOptions({
        server:{
            process: 'tmp-upload-product',
            revert: 'tmp-revert-product',
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }
    });

    

    $(function(){
        $('body').on('click', '#addMoreimage', function(e){
            e.preventDefault();
            let product_id = $(this).data('id');
            let product_title = $(this).data('title');
            $('#addMoreImageModal').modal('show');
            $('#product_id_use').val(product_id);
            $('#product_title').html(product_title);
            
        });

     $('#sellerproductsTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#productsTable_wrapper .col-md-6:eq(0)');

   
      //disable for now utill find a better way to empty file after upload
    $('#addMoreImageForm0').on('submit', function(e){
        e.preventDefault();
        let form = this;
        $.ajax({
            url:$(form).attr('action'),
            method:$(form).attr('method'),
            data:new FormData(form),
            contentType:false,
            processData:false,
            dataType: 'json',
            beforeSend:function(){
                $(form).find('span.text-error').text('');
            },
            success:function(data){
                if(data.code == 0){
                    $.each(data.error, function(prefix, val){
                        $(form).find('span.'+prefix+'_error').text(val[0]);
                    })
                }else{
                    $('#product_file').val('');
                    // $('#sellerproductsTable').DataTable().ajax.reload(null, false);
                    toastr.success(data.msg);
                }
            }
        });
    })

    
            
    
    })
  </script>

@endsection

