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
                <div class="col-md-12 mb-4">
                  <div class="card m-md-auto">
                      <div class="card-header">
                          Add Product Information  : <span class="text-warning text-sm">{{ productTitle($uniquekey)  }}</span>
                      </div>
                      <div class="card-body p-1">
                          <form action="{{ route('superuser.information.add') }}" method="POST" 
                           id="addInformationForm">
                           @csrf
                           @method('POST')
                          <input type="hidden" name="product_id" id="product_id" value="{{ productID($uniquekey) }}">
                            <div class="row">
                              <div class="col-md-6 form-group">
                                <label for="return_policy">Return Policy</label>
                                <textarea name="return_policy" id="return_policy" class="form-control" rows="5"></textarea>
                                <span class="text-error text-danger return_policy_error"></span>
                              </div>
                              <div class="col-md-6 form-group">
                                <label for="additional_info">Additional Info</label>
                                <textarea name="additional_info" id="additional_info" class="form-control" rows="5"></textarea>
                                <span class="text-error text-danger additional_info_error"></span>
                              </div>
                            </div>
                             
                             <div class="form-group col-md-6 text-center">
                              <button type="submit" class="btn btn-primary btn-block">Add Info</button>
                             </div>
                          </form>
                      </div>
                      
                  </div>
             </div>
               <div class="col-md-12">
                <div class="card">
                  <div class="card-header p-2">
                    <ul class="nav nav-pills">
                      <li class="nav-item"><a class="nav-link active" href="#returnPolicy" data-toggle="tab">Return Policy</a></li>
                      <li class="nav-item"><a class="nav-link" href="#additionalInfo" data-toggle="tab">Additional Information</a></li>
                    </ul>
                  </div><!-- /.card-header -->
                  <div class="card-body">
                    <div class="tab-content">
                      <div class="active tab-pane" id="returnPolicy">
                        <!-- return policy -->
                        <div class="card bg-white with-3d-shadow">
                          <div class="card-header justify-content-center align-items-center">
                            <h3 class="card-title lead">
                                Return Policy
                            </h3>
                          </div>
                          <div class="card-body">
                            @if ($information)
                            <div id="policytextarea">
                                <p>
                                  {!! removeTag($information->return_policy) !!}
                                </p>
                                <div class="d-flex justify-content-between mt-5">
                                  <button class="btn btn-success" id="editPolicy">
                                      <i class="fa fa-edit"></i>
                                    </button>
                                 
                                </div>
                            </div>
                            <div id="policyformarea" class="d-none">
                          <form action="{{ route('superuser.information.edit') }}" method="POST" 
                           id="editInformationForm">
                           @csrf
                           @method('POST')
                          
                           <input type="hidden" name="policy_id" id="policy_id" value="{{ $information->id }}">
                           <input type="hidden" name="product_id" id="product_id" value="{{ $information->product_id }}">

                            <div class="row">
                              <div class="col-md-12 form-group">
                                <label for="edit_return_policy">Edit Return Policy</label>
                                <textarea name="edit_return_policy" id="edit_return_policy" class="form-control" rows="5">{{ $information->return_policy }}</textarea>
                                <span class="text-error text-danger return_policy_error"></span>
                              </div>
                            </div>
                             
                             <div class="form-group col-md-6 text-center">
                              <button type="submit" class="btn btn-primary btn-block">Update</button>
                             </div>
                          </form>
                            </div>
                            @else
                              <h3 class="text-center text-muted lead">No information added yet</h3>
                                
                            @endif
                          </div>
                         
                        </div>
                        <!-- /.policy -->
    
                    
                      
                      </div>
                      <!-- /.tab-pane -->
                      <div class="tab-pane" id="additionalInfo">
                        <!-- The additional info -->
                        <div class="card bg-white with-3d-shadow">
                          <div class="card-header justify-content-center align-items-center">
                            <h3 class="card-title lead">
                              Additional Information
                            </h3>
                          </div>
                          <div class="card-body">
                            @if ($information)
                            <div id="infoarea">
                            <p>
                            {!! removeTag($information->additionalInformation) !!}
                            </p>
                            <div class="d-flex justify-content-between mt-5">
                              <button class="btn btn-success" id="editAddInfo">
                                  <i class="fa fa-edit"></i>
                                </button>
                               
                            </div>
                            </div>
                            <div id="infoformarea" class="d-none">
                              <form action="{{ route('superuser.information.edit') }}" method="POST" 
                              id="editAddInformationForm">
                              @csrf
                              @method('POST')
                             
                              <input type="hidden" name="policy_id" id="policy_id" value="{{ $information->id }}">
                              <input type="hidden" name="product_id" id="product_id" value="{{ $information->product_id }}">
   
                               <div class="row">
                                 <div class="col-md-12 form-group">
                                   <label for="edit_additional_info">Edit Additional Info</label>
                                   <textarea name="edit_additional_info" id="edit_additional_info" class="form-control" rows="5">{{ $information->additionalInformation }}</textarea>
                                 </div>
                               </div>
                                
                                <div class="form-group col-md-6 text-center">
                                 <button type="submit" class="btn btn-primary btn-block">Update</button>
                                </div>
                             </form>
                            </div>
                            @else
                              <h3 class="text-center text-muted lead">No information added yet</h3>
                                
                            @endif
                          </div>
                         
                        </div>
                      </div>
                      <!-- /.tab-pane -->
  
                    </div>
                    <!-- /.tab-content -->
                  </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
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
        
          $('#return_policy').summernote();
          $('#edit_return_policy').summernote();

          $('#additional_info').summernote();
          $('#edit_additional_info').summernote();

          $('#editPolicy').on('click', function(e){
            e.preventDefault();
            $('#policytextarea').addClass('d-none');
            $('#policyformarea').removeClass('d-none');
          })

          $('#editAddInfo').on('click', function(e){
            e.preventDefault();
            $('#infoarea').addClass('d-none');
            $('#infoformarea').removeClass('d-none');
          })
        
    $('#addInformationForm').on('submit', function(e){
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
                    $('#addInformationForm')[0].reset();
                    toastr.success(data.msg);
                    location.reload();
                }
            }
        });
    })

    //update policy
    $('#editInformationForm').on('submit', function(e){
        e.preventDefault();
        let form = this;
        $.ajax({
            url:$(form).attr('action'),
            method:$(form).attr('method'),
            data:new FormData(form),
            contentType:false,
            processData:false,
            dataType: 'json',
            
            success:function(data){
              console.log(data);
                if(data.code == 0){
                  toastr.success(data.error)
                }else{
                    toastr.success(data.msg);
                    setTimeout(() => {
                      location.reload();
                    }, 1000);
                  
                }
            }
        });
    })

    //  //update policy
    //  $('#editAddInformationForm').on('submit', function(e){
    //     e.preventDefault();
    //     let form = this;
    //     $.ajax({
    //         url:$(form).attr('action'),
    //         method:$(form).attr('method'),
    //         data:new FormData(form),
    //         contentType:false,
    //         processData:false,
    //         dataType: 'json',
            
    //         success:function(data){
    //           console.log(data);
    //             if(data.code == 0){
    //               toastr.success(data.error)
    //             }else{
    //                 toastr.success(data.msg);
    //                 setTimeout(() => {
    //                   location.reload();
    //                 }, 1000);
                  
    //             }
    //         }
    //     });
    // })


           
        

         

        
        })
 
</script>

@endsection
   

   
