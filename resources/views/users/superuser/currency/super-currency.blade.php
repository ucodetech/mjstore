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
           
                {{-- <div class="card m-md-auto w-50">
                  <div class="card-header">Preveiw Product Category Image</div>
                  <div class="card-body" id="showProductCategoryPreview"></div>
                </div> --}}
                <div class="row">
                    <div class="col-md-4">
                        <div class="card m-md-auto w-100" style="background-color: #070c1fce">
                            <div class="card-header">
                                Add Currency
                            </div>
                            <div class="card-body">
                                <form action="{{ route('superuser.super.add.currency') }}" method="POST"
                                id="addCurrencyForm">
                                @csrf
                                @method('POST')
                                    <div class="form-group">
                                        <label for="currency_name">Currency: <span class="text-danger">*</span></label>
                                        <input type="text" name="currency_name" id="currency_name" class="form-control" 
                                        aria-describedby="helpId">
                                        <span  class="text-danger text-error currency_name_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="currency_symbol">Symbol: <span class="text-danger">*</span></label>
                                        <input type="text" name="currency_symbol" id="currency_symbol" class="form-control" 
                                        aria-describedby="helpId">
                                        <span  class="text-danger text-error currency_symbol_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="code">Code: <span class="text-danger">*</span></label>
                                        <input type="text" name="code" id="code" class="form-control" 
                                        aria-describedby="helpId">
                                        <span  class="text-danger text-error code_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="currency_rate">Exchange Rate: <span class="text-danger">*</span></label>
                                        <input type="text" name="currency_rate" id="currency_rate" class="form-control" 
                                        aria-describedby="helpId">
                                        <span  class="text-danger text-error currency_rate_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="currency_status">Currency: <span class="text-danger">*</span></label>
                                        <select name="currency_status" id="currency_status" class="form-control">
                                            <option value="">--Select Status--</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                        <span  class="text-danger text-error currency_status_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-sm btn-primary">Add Currency</button>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button type="reset" class="btn btn-sm btn-warning">Clear</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-8">
                     <div class="card" style="background-color: #070c1fce">
                        <div class="card-header">
                            List of Currencies
                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
                            <table class="table table-striped table-inverse table-hover" id="currencyTable">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>#</th>
                                        <th>Currency</th>
                                        <th>Symbol</th>
                                        <th>Code</th>
                                        <th>Exchange Rate</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
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

<script>
    $(function(){
       
        $('#currencyTable').DataTable({
            processing:true,
            info: true,
            ajax: "{{ route('superuser.super.list.currency') }}",
            columns: [
                {data:"DT_RowIndex"},
                {data:"name"},
                {data:"symbol"},
                {data:"code"},
                {data:"exchange_rate"},
                {data:"status"},
                {data:"action"}
            ]
        })
        //exeecute updateCurrency function on button click
        $('body').on('click', '#deactivateCurrency', function(e){
            e.preventDefault();
            let url = $(this).data('url');
            let cur_id = $(this).data('id');
            let mode = "deactivate";
            updateStatus(url, cur_id, mode);
        })
          //exeecute updateCurrency function on button click
          $('body').on('click', '#activateCurrency', function(e){
            e.preventDefault();
            let url = $(this).data('url');
            let cur_id = $(this).data('id');
            let mode = "activate";
            updateStatus(url, cur_id, mode);
        })
        //update currency status
        function updateStatus(url,cur_id, mode){
            $.ajax({
                url:url,
                method:"post",
                data: {
                    cur_id : cur_id,
                    mode : mode
                },
                success:function(data){
                    if(data.code == 0){
                        toastr.error(data.error);
                        
                    }else{
                        toastr.success(data.msg);
                        $('#currencyTable').DataTable().ajax.reload(null,false);
                    }
                }
            })
        }


        //delete currency
        $('body').on('click','#deleteCurrency' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let cur_id = $(this).data('id');
        Swal.fire({
          title:'Are you sure?',
          text: 'File will be deleted!',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes delete it!',
          allowOutsideClick:false
        }).then(function(result){
            if(result.value){
              $.post(url, {cur_id:cur_id}, function(data){
                  if(data.code == 0){
                    toastr.error(data.error);
                  }else{
                    Swal.fire(
                        'Deleted!',
                         data.msg,
                        'success'
                      );
                      $('#currencyTable').DataTable().ajax.reload(null,false);
                      
                  }
                
              });
            }
        });

    });

    //add currency
    $('#addCurrencyForm').on('submit', function(e){
        e.preventDefault();
        let form = this;
        $.ajax({
            url:$(form).attr('action'),
            method:$(form).attr('method'),
            data: new FormData(form),
            contentType:false,
            processData:false,
            dataType:'json',
            beforeSend:function(){
                $(form).find('span.text-error').text('');
            },
            success:function(data){
                if(data.code == 0){
                    $.each(data.error, function(prefix, val){
                        $(form).find('span.'+prefix+'_error').text(val[0]);
                    })
                }else{
                    toastr.success(data.msg);
                    $('#addCurrencyForm')[0].reset();
                    $('#currencyTable').DataTable().ajax.reload(null,false);
                }
            }
        })
    })


    })
  
</script>

@endsection
   

   
