
function readURL(input){
    if(input.files && input.files[0]){
        let reader = new FileReader();
        reader.onload = function(e){
            $('#showBannerPreview').html('<label for="banner_file"><img src="'+e.target.result+'" alt="banner" class="img-fluid"></label>');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(function(){

                            
    $('#bannerTableID').DataTable({
        processing: true,
        info:true,
        ajax:'super-banners-list',
        columns: [
            {data:'DT_RowIndex', name:'DT_RowIndex'},
            {data:'photoCus', name:'photoCus'},
            {data:'title', name:'title'},
            {data:'status', name:'stauts'},
            {data:'condition', name:'condition'},
            {data:'actions', name:'actions'}
        ]

       

    });

    $('#addBannerForm').on('submit', function(e){
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
                    $('#addBannerForm')[0].reset();
                    $('#showBannerPreview').html('');
                    $('#bannerTableID').DataTable().ajax.reload(null, false);
                    toastr.success(data.msg);
                }
            }
        });
    })

    $('#banner_file').on('change', function(){
        readURL(this);
    })

    $('#generateBannerSlugurl').on('click', function(e){
        e.preventDefault();
        let banner_slug = $('#banner_title').val();
        let url = 'generate-banner-slugurl';
        $.get(url, {banner_slug:banner_slug}, function(data){
            if(data.code === 1){
                $('#banner_slug_url').val(data.msg);
            }else{
                toastr.error(data.error);
            }
        });
    })

    $('#banner_description').summernote();
    $('#edit_banner_description').summernote();

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


    // deleteBanner
    $('body').on('click','#deleteBanner' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let banner_id = $(this).data('id');
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
              $.post(url, {banner_id:banner_id}, function(data){
                  Swal.fire(
                    'Banner Record deleted!',
                     data,
                    'success'
                  );
                  $('#bannerTableID').DataTable().ajax.reload(null,false);
                
              });
            }
        });

    })
    // inactiveBanner
    $('body').on('click','#inactiveBanner' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let banner_id = $(this).data('id');
        Swal.fire({
          title:'Are you sure?',
          text: 'Banner will be in active!',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes deactivate it!',
          allowOutsideClick:false
        }).then(function(result){
            if(result.value){
              $.post(url, {banner_id:banner_id}, function(data){
                  Swal.fire(
                    'Banner deactivated!',
                     data,
                    'success'
                  );
                  $('#bannerTableID').DataTable().ajax.reload(null,false);
                
              });
            }
        });

    })
    // activeBanner
    $('body').on('click','#activeBanner' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let banner_id = $(this).data('id');
        Swal.fire({
          title:'Are you sure?',
          text: 'Banner will activated',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes activate it!',
          allowOutsideClick:false
        }).then(function(result){
            if(result.value){
              $.post(url, {banner_id:banner_id}, function(data){
                  Swal.fire(
                    'Banner Activated!',
                     data,
                    'success'
                  );
                  $('#bannerTableID').DataTable().ajax.reload(null,false);
                
              });
            }
        });

    })
    // bannerBanner
    $('body').on('click','#bannerBanner' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let banner_id = $(this).data('id');
        Swal.fire({
          title:'Are you sure?',
          text: 'Banner will bet set to ordinary banner',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes set it!',
          allowOutsideClick:false
        }).then(function(result){
            if(result.value){
              $.post(url, {banner_id:banner_id}, function(data){
                  Swal.fire(
                    'Banner is set to ordinary banner!',
                     data,
                    'success'
                  );
                  $('#bannerTableID').DataTable().ajax.reload(null,false);
                
              });
            }
        });

    })
    // promoBanner
    $('body').on('click','#promoBanner' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let banner_id = $(this).data('id');
        Swal.fire({
          title:'Are you sure?',
          text: 'Banner will set to promotional banner',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes set it!',
          allowOutsideClick:false
        }).then(function(result){
            if(result.value){
              $.post(url, {banner_id:banner_id}, function(data){
                  Swal.fire(
                    'Banner set to promotion banner!',
                     data,
                    'success'
                  );
                  $('#bannerTableID').DataTable().ajax.reload(null,false);
                
              });
            }
        });

    })

    // $('#RegenerateBannerSlugurl').on('click', function(e){
    //     e.preventDefault();
    //     let banner_slug = $('#edit_banner_title').val();
    //     let url = 'generate-banner-slugurl';
    //     $.get(url, {banner_slug:banner_slug}, function(data){
    //         if(data.code === 1){
    //             $('#edit_banner_slug_url').val(data.msg);
    //         }else{
    //             toastr.error(data.error);
    //         }
    //     });
    // })


});