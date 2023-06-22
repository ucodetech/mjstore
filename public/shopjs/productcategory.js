
function readURLCat(input){
    if(input.files && input.files[0]){
        let reader = new FileReader();
        reader.onload = function(e){
            $('#showProductCategoryPreview').html('<label for="product_category_file"><img src="'+e.target.result+'" alt="product category" class="img-fluid"></label>');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(function(){

                            
    $('#productCategoryTableID').DataTable({
        processing: true,
        info:true,
        ajax:'super-pcategory-list',
        columns: [
            {data:'DT_RowIndex', name:'DT_RowIndex'},
            {data:'photoCus', name:'photoCus'},
            {data:'title', name:'title'},
            {data:'id', name:'id'},
            {data:'isParent', name:'isParent'},
            {data:'parent_category', name:'parent_category'},
            {data:'status', name:'stauts'},
            {data:'is_top', name:'is_top'},
            {data:'actions', name:'actions'}
        ]

       

    });

    $('#is_parent').on('change', function(e){
        e.preventDefault();
        let is_checked = $('#is_parent').prop('checked');
        if(is_checked){
            $('#parentCategoryBtn').addClass('d-none');
        }else{
            $('#parentCategoryBtn').removeClass('d-none');
            $('#parent_id').val('');
        }
    })

    $('#addProductCategoryForm').on('submit', function(e){
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
                    $('#addProductCategoryForm')[0].reset();
                    $('#showProductCategoryPreview').html('');
                    $('#productCategoryTableID').DataTable().ajax.reload(null, false);
                    $('#parentCategoryBtn').addClass('d-none');

                    toastr.success(data.msg);

                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
            }
        });
    })

    $('#product_category_file').on('change', function(){
        readURLCat(this);
    })

    $('#generateProductCategorySlugurl').on('click', function(e){
        e.preventDefault();
        let product_category_slug = $('#product_category_title').val();
        let url = 'generate-pcategory-slugurl';
        $.get(url, {product_category_slug:product_category_slug}, function(data){
            if(data.code === 1){
                $('#product_category_slug_url').val(data.msg);
            }else{
                toastr.error(data.error);
            }
        });
    })

    $('#product_category_summary').summernote();
    $('#edit_product_category_summary').summernote();

    // $('#bannerTable').DataTable({
    //     "paging": true,
    //     "lengthChange": false,
    //     "searching": true,
    //     "ordering": true,
    //     "info": true,
    //     "autoWidth": false,
    //     "responsive": true,
    //     "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    //   }).buttons().container().appendTo('#bannerTable_wrapper .col-md-6:eq(0)');


    // deleteProductCategory
    $('body').on('click','#deleteProductCategory' ,function(e){
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
    // inactivePCategory
    $('body').on('click','#inactivePCategory' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let p_cate_id = $(this).data('id');
        Swal.fire({
          title:'Are you sure?',
          text: 'Category will be in active!',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes deactivate it!',
          allowOutsideClick:false
        }).then(function(result){
            if(result.value){
              $.post(url, {p_cate_id:p_cate_id}, function(data){
                  Swal.fire(
                    'Category deactivated!',
                     data,
                    'success'
                  );
                  $('#productCategoryTableID').DataTable().ajax.reload(null,false);
                
              });
            }
        });

    })
    // activePCategory
    $('body').on('click','#activePCategory' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let p_cate_id = $(this).data('id');
        Swal.fire({
          title:'Are you sure?',
          text: 'Category will activated',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes activate it!',
          allowOutsideClick:false
        }).then(function(result){
            if(result.value){
              $.post(url, {p_cate_id:p_cate_id}, function(data){
                  Swal.fire(
                    'Category Activated!',
                     data,
                    'success'
                  );
                  $('#productCategoryTableID').DataTable().ajax.reload(null,false);
                
              });
            }
        });

    })
  


  // make category a regular category
  $('body').on('click','#regularPCategory' ,function(e){
    e.preventDefault();
    let url = $(this).data('url');
    let p_cate_id = $(this).data('id');
    Swal.fire({
      title:'Are you sure?',
      text: 'Category will be a regular category!',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes proceed!',
      allowOutsideClick:false
    }).then(function(result){
        if(result.value){
          $.post(url, {p_cate_id:p_cate_id}, function(data){
              Swal.fire(
                'Category made regular!',
                 data,
                'success'
              );
              $('#productCategoryTableID').DataTable().ajax.reload(null,false);
            
          });
        }
    });

})
// make category a top category
$('body').on('click','#topPCategory' ,function(e){
    e.preventDefault();
    let url = $(this).data('url');
    let p_cate_id = $(this).data('id');
    Swal.fire({
      title:'Are you sure?',
      text: 'Category will be a top category',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes proceed!',
      allowOutsideClick:false
    }).then(function(result){
        if(result.value){
          $.post(url, {p_cate_id:p_cate_id}, function(data){
              Swal.fire(
                'Category made a top category!',
                 data,
                'success'
              );
              $('#productCategoryTableID').DataTable().ajax.reload(null,false);
            
          });
        }
    });

})







});