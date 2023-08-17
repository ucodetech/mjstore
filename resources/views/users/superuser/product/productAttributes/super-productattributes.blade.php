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
           
                {{-- <div class="card m-md-auto w-50">
                  <div class="card-header">Preveiw Product Category Image</div>
                  <div class="card-body" id="showProductCategoryPreview"></div>
                </div> --}}
              <div class="row">
                <div class="col-md-6">
                  <div class="card m-md-auto">
                      <div class="card-header">
                          Add Product Attribute
                      </div>
                      <div class="card-body">
                          @include('inc.messages')
                          <hr>
                          <form action="{{ route('superuser.attributes.add') }}" method="POST" 
                           id="addAttributeForm">
                           @csrf
                           @method('POST')
                          <input type="hidden" name="product_id" id="product_id" value="{{ productID($uniquekey) }}">
                          <input type="hidden" name="product_stock" id="product_stock" value="{{ productStock($uniquekey) }}">

                           <div class="content" id="product_attributes" data-mfield-options='{"section": ".group","btnAdd":"#btnAdd","btnRemove":".btnRemove"}'>
                            <div class="form-group">
                              <button type="button" class="btn btn-sm btn-primary" id="btnAdd"><i class="fa fa-plus"></i> Add Row</button>
                            </div>
                            <hr>
                              <div class="row group">
                                <div class="col-md-3 form-group">
                                  <label for="size">Size</label>
                                  <select name="size[]" id="size" class="form-control">
                                    @php 
                                       $sizes = explode(',',$product->size);
                                    @endphp
                                        <option value="">--Select Size--</option>
                                        @foreach ($sizes as $size)
                                           <option value="{{ $size }}">{{ $size }}</option>
                                        @endforeach

                                  </select>
                                  <span  class="text-danger text-error size_error"></span>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="original_price">Price</label>
                                    <input type="number" name="original_price[]" id="original_price" class="form-control" 
                                    aria-describedby="helpId" step=".01" >
                                    <span  class="text-danger text-error original_price_error"></span>
                                  </div>
                                  <div class="col-md-3 form-group">
                                    <label for="offer_price">Offer Price</label>
                                    <input type="number" name="offer_price[]" id="offer_price" class="form-control" 
                                    aria-describedby="helpId" step=".01" placeholder="Eg:1200">
                                    <span  class="text-danger text-error offer_price_error"></span>
                                  </div>
                                 <div class="col-md-3 form-group">
                                    <label for="stock">Stock</label>
                                    <input type="number" name="stock[]" id="stock" class="form-control" 
                                    aria-describedby="helpId" placeholder="Eg:20" min="1" max="{{ productStock($uniquekey) }}">
                                    <span  class="text-danger text-error stock_error"></span>
                                 </div>
                                 <div class="col-md-2 form-group">
                                  <button type="button" class="btn btn-sm btn-danger btnRemove" id="btnRemove"><i class="fa fa-trash-alt"></i></button>
                                </div>
                           </div>
                           </div>
                              <button type="submit" class="btn btn-primary">Add Attribute</button>
                          </form>
                      </div>
                      <div class="card-footer">
                        <div class="d-flex justify-content-between">
                          <span class="text-warning">Product Stock: {{ $product->stock }}</span>
                          <span class="text-success">Product Sales Price: {{ currency_converter($product->sales_price) }}</span>
                        </div>
                      </div>
                      
                  </div>
             </div>
               <div class="col-md-6">
                     <div class="card">
                        <div class="card-header">
                            List of Product Attributes : <span class="text-warning">{{ productTitle($uniquekey) }}</span>
                        </div>
                      
                        <div class="card-body">
                          <small class="text-warning text-center">Note: You can only update Offer price  and stock! To do so click on the column you want to update, make your edit and hit enter.</small>
                          <hr>
                           <div class="table-responsive">
                            <table class="table table-striped table-inverse table-hover" id="productAttributesTable">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>#</th>
                                        <th>Size</th>
                                        <th>Original Price</th>
                                        <th>Offer Price</th>
                                        <th>Stock</th>
                                        <th>Action</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                      @if(count($attributes)>0)
                                        @foreach ($attributes as $key=>$attribute)
                                            <tr>
                                              <td width="5%">{{ $key }}</td>
                                              <td>{{ $attribute->size }}</td>
                                              <td>{{ currency_converter($attribute->original_price) }}</td>
                                              <td width="20%">
                                                <a href="javascript:0" data-url="{{ route('superuser.attributes.edit') }}" class="edit_offer_price" data-id="{{ $attribute->id }}">
                                                   <input type="number" class="form-control w-100 invisibleInput" id="edit_offer_price{{ $attribute->id }}" name="edit_offer_price" value="{{ $attribute->offer_price }}" data-id="{{ $attribute->id }}"  disabled min="1"></a>
                                              </td>
                                              <td width="20%">
                                                <a href="javascript:0" data-url="{{ route('superuser.attributes.edit') }}" class="edit_stock" data-id="{{ $attribute->id }}" data-product_id="{{ $attribute->product_id }}">
                                                  <input type="number" class="form-control invisibleInput edit_stock w-100" id="edit_stock{{ $attribute->id }}" name="edit_stock" value="{{ $attribute->stock }}" data-id="{{ $attribute->id }}" disabled min="1"> 
                                                  </a>
                                              </td>
                                              <td>
                                                <div class="btn-group">
                                                   <button type="button" 
                                                   data-id="{{ $attribute->id }}" 
                                                   data-url="{{ route('superuser.attributes.delete') }}"
                                                   id="deleteProductAttribute" 
                                                   class="btn btn-outline-danger">Delete</button>
                                                </div>
                                              </td>
                                            </tr>
                                        @endforeach
                                      @endif
                                    </tbody>
                            </table>
                           </div>
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
{{-- <script src="{{ asset('shopjs/cus_multifield.js') }}"></script> --}}
<script>
  
        $(function(){
          $('#product_attributes').multifield();

        let pTable =   $('#productAttributesTable').DataTable();

    $('#addAttributeForm').on('submit', function(e){
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
              console.log(data);

                if(data.code == 0){
                  $.each(data.error, function(prefix, val){
                    $(form).find('span.'+prefix+'_error').text(val[0]);
                  })
                }else if(data.code == 2){
                    toastr.error(data.err);
                 }else{
                    $('#addAttributeForm')[0].reset();
                    toastr.success(data.msg);
                    location.reload();
                }
            }
        });
    })


           
        

          //delete attribute 
          $('body').on('click', '#deleteProductAttribute', function(e){
            e.preventDefault();
            let url = $(this).data('url');
            let id = $(this).data('id');
            let _token = "{{ csrf_token() }}";
            Swal.fire({
                title: "Are you sure?",
                text: "This action can't be reverted!",
                showCancelButton: true,
                confirmButtonText: "Yes Delete it!",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                allowOutsideClick:false
             }).then(function(result){
                if(result.value){
                  $.post(url , {id:id, _token:_token}, function(data){
                    Swal.fire(
                      'Deleted',
                      data.msg,
                      'success'
                    );
                    $('#productAttributesTable').DataTable().ajax.reload(null, false);

                  })
                }
             })
          })

          //activate input 
          $('body').on('click', '.edit_offer_price', function(e){
            e.preventDefault();
            let id = $(this).data('id');
            let url = $(this).data('url');
            let fieldToEdit = "offerPrice";
            $('#edit_offer_price'+id).removeAttr('disabled');
            $('#edit_offer_price'+id).change(function(){
              let newValue = $('#edit_offer_price'+id).val();
              // $('#storeKey').val(newValue);
              updateAttribute(url, id, newValue,fieldToEdit);
            })
           
          });
          $('body').on('click', '.edit_stock', function(e){
            e.preventDefault();
            let id = $(this).data('id');
            let url = $(this).data('url');
            let fieldToEdit = "stock";
            let product_id = $(this).data('product_id');
            let productStock = "{{ productStock($uniquekey) }}";
            $('#edit_stock'+id).removeAttr('disabled');
            $('#edit_stock'+id).change(function(){
              let newValue = $('#edit_stock'+id).val();
              // $('#storeKey').val(newValue);
             
              updateAttribute(url, id, newValue,fieldToEdit,product_id,productStock);
            })
           
          });

          //update attribute
          function updateAttribute(url, id, newValue,fieldToEdit,product_id = false, productStock = false){
            let _token = "{{ csrf_token() }}";
              $.post(url, {id:id, newValue:newValue,fieldToEdit:fieldToEdit,product_id:product_id,productStock:productStock,_token:_token}, function(data){
                if(data.code == "false"){
                  Swal.fire(
                  'Error',
                  data.error,
                  'error'
                 )
                 
                }else if(data.code == "true"){
                
                 Swal.fire(
                  'Success',
                  data.msg,
                  'info'
                 )
                 setTimeout(() => {
                  location.reload();
                 }, 3000);
                }

              })
          }

        })
 
</script>

@endsection
   

   
