
function readURLProd(input){
    if(input.files && input.files[0]){
        let reader = new FileReader();
        reader.onload = function(e){
            $('#productPhoto').html('<label for="product_file"><img src="'+e.target.result+'" alt="product image" class="img-fluid" width="100px" height="100px"></label>');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(function(){
   
    $('#product_summary').summernote();
    $('#product_description').summernote();


    $('#product_file').on('change', function(){
        readURLProd(this);
        
    })

    // $('#product_color').on('change', function(e){
    //   e.preventDefault();
    //   let color = $('#product_color').val();
    //   alert(color)
    // })


    // Initialize Select2 Elements
    $('.select2').select2()
    bsCustomFileInput.init();
    // Initialize Select2 Elements
    // $('.select2bs4').select2({
    //   theme:'bootstrap4'
    // })



    $('#productsTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#productsTable_wrapper .col-md-6:eq(0)');

   




    // deleteBrand
    $('body').on('click','#deleteProduct' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let product_id = $(this).data('id');
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
              $.post(url, {product_id:product_id}, function(data){
                  if(data.code == 0){
                    toastr.error(data.error);
                  }else{
                    Swal.fire(
                        'Product Record deleted!',
                         data.msg,
                        'success'
                      );
                     setTimeout(() => {
                            location.reload();
                     }, 2000);
                      
                  }
                
              });
            }
        });

    })
  

    //view product details
    $('body').on('click', '#viewProduct', function(e){
        e.preventDefault()
        
        let url = $(this).data('url');
        let uniquekey = $(this).data('uniquekey');
        $.post(url, {uniquekey:uniquekey}, function(data){
            $('#productDetail').modal('show');
            $('#showProductDetails').html(data);
        })
    })


    $('#colorTable').DataTable({
        processing: true,
        info:true,
        ajax:'super-colors-list',
        columns: [
            {data:'DT_RowIndex', name:'DT_RowIndex'},
            {data:'color', name:'color'},
            {data:'actions', name:'actions'}
        ]

       

    });

   

    $('#addColorForm').on('submit', function(e){
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
                }else if(data.code == 2){
                    toastr.error(data.error);
                 }else{
                    $('#addColorForm')[0].reset();
                    $('#colorTable').DataTable().ajax.reload(null, false);
                    toastr.success(data.msg);
                }
            }
        });
    })

    
   


    // deleteProductCategory
    $('body').on('click','#deleteColor' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let p_cat_id = $(this).data('id');
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
              $.post(url, {p_cat_id:p_cat_id}, function(data){
                  if(data.code == 0){
                    toastr.error(data.error);
                  }else{
                    Swal.fire(
                        'Category Record deleted!',
                         data,
                        'success'
                      );
                      $('#productCategoryTableID').DataTable().ajax.reload(null,false);
                      setTimeout(() => {
                        location.reload();
                    }, 2000);
                  }
                
              });
            }
        });

    })

    $('#sizeTable').DataTable({
        processing: true,
        info:true,
        ajax:'super-sizes-list',
        columns: [
            {data:'DT_RowIndex', name:'DT_RowIndex'},
            {data:'size', name:'size'},
            {data:'actions', name:'actions'}
        ]

       

    });

   

    $('#addSizeForm').on('submit', function(e){
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
                }else if(data.code == 2){
                    toastr.error(data.error);
                 }else{
                    $('#addSizeForm')[0].reset();
                    $('#sizeTable').DataTable().ajax.reload(null, false);
                    toastr.success(data.msg);
                }
            }
        });
    })


    $('#conditionTable').DataTable({
        processing: true,
        info:true,
        ajax:'super-conditions-list',
        columns: [
            {data:'DT_RowIndex', name:'DT_RowIndex'},
            {data:'condition', name:'condition'},
            {data:'actions', name:'actions'}
        ]

       

    });

   

    $('#addConditionForm').on('submit', function(e){
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
                }else if(data.code == 2){
                    toastr.error(data.error);
                 }else{
                    $('#addConditionForm')[0].reset();
                    $('#conditionTable').DataTable().ajax.reload(null, false);
                    toastr.success(data.msg);
                }
            }
        });
    })




});