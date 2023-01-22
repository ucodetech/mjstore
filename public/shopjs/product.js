
function readURL(input){
    if(input.files && input.files[0]){
        let reader = new FileReader();
        reader.onload = function(e){
            $('#showBrandPreview').html('<label for="brand_fil.e"><img src="'+e.target.result+'" alt="brand image" class="img-fluid"></label>');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(function(){

        //toggle product status
        $('.productToggle').on('change', function(e){
            e.preventDefault();
            let mode = $(this).prop('checked');
            let product_id = $(this).data('id');
            let url = $(this).data('url');
            let token = $(this).data('token');
            
            $.ajax({
                url:url,
                method:'POST',
                data:{
                    _token:token,
                    mode:mode,
                    product_id:product_id,
                },
                success:function(data){ 
                   if(data.code==1){
                    toastr.info(data.msg);
                   }else{
                    toastr.error('Please try again');
                   }
                }
            })
        })


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

   

    $('#addBrandForm').on('submit', function(e){
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
                if(data.code === 0){
                    $.each(data.error, function(prefix, val){
                        $(form).find('span.'+prefix+'_error').text(val[0]);
                    })
                }else{
                    $('#addBrandForm')[0].reset();
                    $('#showBrandPreview').html('');
                    $('#brandTableID').DataTable().ajax.reload(null, false);
                    toastr.success(data.msg);
                }
            }
        });
    })

    $('#brand_file').on('change', function(){
        readURL(this);
    })

    $('#generateBrandSlugurl').on('click', function(e){
        e.preventDefault();
        let brand_title = $('#brand_title').val();
        let url = 'generate-brand-slugurl';
        $.get(url, {brand_title:brand_title}, function(data){
            if(data.code === 1){
                $('#brand_slug_url').val(data.msg);
            }else{
                toastr.error(data.error);
            }
        });
    })



    // deleteBrand
    $('body').on('click','#deleteBrand' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let brand_id = $(this).data('id');
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
              $.post(url, {brand_id:brand_id}, function(data){
                  if(data.code == 0){
                    toastr.error(data.error);
                  }else{
                    Swal.fire(
                        'Brand Record deleted!',
                         data,
                        'success'
                      );
                      $('#brandTableID').DataTable().ajax.reload(null,false);
                      
                  }
                
              });
            }
        });

    })
    // deactivate brand
    $('body').on('click','#deactivateBrand' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let brand_id = $(this).data('id');
        Swal.fire({
          title:'Are you sure?',
          text: 'Brand will be deactivated!',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes deactivate it!',
          allowOutsideClick:false
        }).then(function(result){
            if(result.value){
              $.post(url, {brand_id:brand_id}, function(data){
                  Swal.fire(
                    'Brand deactivated!',
                     data,
                    'success'
                  );
                  $('#brandTableID').DataTable().ajax.reload(null,false);
                
              });
            }
        });

    })
    // active brand
    $('body').on('click','#activateBrand' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let brand_id = $(this).data('id');
        Swal.fire({
          title:'Are you sure?',
          text: 'Brand will activated',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes activate it!',
          allowOutsideClick:false
        }).then(function(result){
            if(result.value){
              $.post(url, {brand_id:brand_id}, function(data){
                  Swal.fire(
                    'Brand Activated!',
                     data,
                    'success'
                  );
                  $('#brandTableID').DataTable().ajax.reload(null,false);
                
              });
            }
        });

    })
  


});