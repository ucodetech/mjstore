
$(function(){

                            
    $('#couponTableID').DataTable({
        processing: true,
        info:true,
        ajax:'seller-coupon-list',
        columns: [
            {data:'DT_RowIndex', name:'DT_RowIndex'},
            {data:'codeCus', name:'codeCus'},
            {data:'type', name:'type'},
            {data:'typeCus', name:'typeCus'},
            {data:'value', name:'value'},
            {data:'status', name:'stauts'},
            {data:'created_at', name:'created_at'},
            {data:'updated_at', name:'updated_at'},
            {data:'actions', name:'actions'}
        ]

       

    });

   

    $('#addCouponForm').on('submit', function(e){
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
                    $('#addCouponForm')[0].reset();
                    $('#couponTableID').DataTable().ajax.reload(null, false);
                    toastr.success(data.msg);
                }
            }
        });
    })


    $('#generateCouponCode').on('click', function(e){
        e.preventDefault();
        let url = 'generate-coupon-code';
        $.get(url,function(data){
            if(data.code == 1){
                $('#code').val(data.msg);
            }else{
                toastr.error(data.error);
            }
        });
    })

   



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


    // deleteBrand
    $('body').on('click','#deleteCoupon' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let coupon_id = $(this).data('id');
        Swal.fire({
          title:'Are you sure?',
          text: 'Coupon will be deleted!',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes delete it!',
          allowOutsideClick:false
        }).then(function(result){
            if(result.value){
              $.post(url, {coupon_id:coupon_id}, function(data){
                  if(data.code == 0){
                    toastr.error(data.error);
                  }else{
                    Swal.fire(
                        'Coupon Record deleted!',
                         data,
                        'success'
                      );
                      $('#couponTableID').DataTable().ajax.reload(null,false);
                      
                  }
                
              });
            }
        });

    })
    // deactivate brand
    $('body').on('click','#deactivateCoupon' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let coupon_id = $(this).data('id');
        let mode = 'deactivate';
        Swal.fire({
          title:'Are you sure?',
          text: 'Coupon will be deactivated!',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes deactivate it!',
          allowOutsideClick:false
        }).then(function(result){
            if(result.value){
              $.post(url, {coupon_id:coupon_id, mode:mode}, function(data){
                  Swal.fire(
                    'Coupon deactivated!',
                     data,
                    'success'
                  );
                  $('#couponTableID').DataTable().ajax.reload(null,false);
                
              });
            }
        });

    })
    // active brand
    $('body').on('click','#activateCoupon' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let coupon_id = $(this).data('id');
        let mode = 'activate';
        Swal.fire({
          title:'Are you sure?',
          text: 'Coupon will activated',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes activate it!',
          allowOutsideClick:false
        }).then(function(result){
            if(result.value){
              $.post(url, {coupon_id:coupon_id, mode:mode}, function(data){
                  Swal.fire(
                    'Coupon Activated!',
                     data,
                    'success'
                  );
                  $('#couponTableID').DataTable().ajax.reload(null,false);
                
              });
            }
        });

    })
  

     // change type to fixed
     $('body').on('click','#fixedCoupon' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let coupon_id = $(this).data('id');
        let mode = 'fixed';
        Swal.fire({
          title:'Are you sure?',
          text: 'Coupon will be fixed!',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes proceed!',
          allowOutsideClick:false
        }).then(function(result){
            if(result.value){
              $.post(url, {coupon_id:coupon_id, mode:mode}, function(data){
                  Swal.fire(
                    'Coupon Made Fixed!',
                     data,
                    'success'
                  );
                  $('#couponTableID').DataTable().ajax.reload(null,false);
                
              });
            }
        });

    })
    // change type to percent
    $('body').on('click','#percentCoupon' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let coupon_id = $(this).data('id');
        let mode = 'percent';
        Swal.fire({
          title:'Are you sure?',
          text: 'Coupon will be percent',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes proceed!',
          allowOutsideClick:false
        }).then(function(result){
            if(result.value){
              $.post(url, {coupon_id:coupon_id, mode:mode}, function(data){
                  Swal.fire(
                    'Coupon made percent!',
                     data,
                    'success'
                  );
                  $('#couponTableID').DataTable().ajax.reload(null,false);
                
              });
            }
        });

    })

    $('body').on('click','#deleteCoupon' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let coupon_id = $(this).data('id');
        Swal.fire({
          title:'Are you sure?',
          text: 'Coupon will be deleted!',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes proceed!',
          allowOutsideClick:false
        }).then(function(result){
            if(result.value){
              $.post(url, {coupon_id:coupon_id}, function(data){
                  if(data.code == 0){
                    Swal.fire(
                        'Error!',
                         data.error,
                        'error'
                      );
                  }else{
                    Swal.fire(
                        'Coupon deleted!',
                         data,
                        'success'
                      );
                      $('#couponTableID').DataTable().ajax.reload(null,false);
                  }
                
              });
            }
        });

    })




});