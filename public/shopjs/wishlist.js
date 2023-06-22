$(function(){
    $('body').on('click', '.add_to_wishlist', function(e){
        e.preventDefault();
        let product_id = $(this).data('product-id');
        let path = $(this).data('url');
        $.ajax({
            url:path,
            method:'POST',
            dataType:'JSON',
            data: {
                product_id:product_id,
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            },
            beforeSend:function(){
                $('#add_to_wishlist'+product_id).html('<i class="fa fa-spinner fa-spin"></i>');
            },
            complete:function(){
                $('#add_to_wishlist'+product_id).html('<i class="icofont-heart"></i>');
            },
            success:function(data){
                if(data.code==0){
                    Swal.fire(
                        'Warning',
                         data.error,
                        'warning',
                    )
                }
                else if(data.code == 2){
                    Swal.fire(
                        'Warning',
                        data.error,
                        'warning',
                    )
                }else{
                    Swal.fire(
                        'Success',
                        data.message,
                        'success',
                    )
                }
            },
            error:function(err){
                console.log(err);
            }
        })
    })

})

