$(function(){
            $('body').on('click', '.add_to_cart', function(e){
                e.preventDefault();
                let product_id = $(this).data('product-id');
                let product_quantity = $(this).data('quantity');
                let product_quantity2 = $('#product_quantity'+product_id).val();
                let product_stock = $(this).data('stock');
                let product_stock2 = $(this).data('product_stock');
                let path = $(this).data('url-cart');
            
                $.ajax({
                    url:path,
                    method:'POST',
                    dataType:'JSON',
                    data: {
                        product_id:product_id,
                        product_quantity:product_quantity,
                        product_quantity2:product_quantity2,
                        product_stock:product_stock,
                        product_stock2:product_stock2,
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
            
                    },
                    beforeSend:function(){
                        $('#add_to_cart'+product_id).html('<i class="fa fa-spinner fa-spin"></i> loading...');
                    },
                    complete:function(){
                        $('#add_to_cart'+product_id).html('Add to Cart');
                    },
                    success:function(data){
                        if(data.status=true){
                            Swal.fire(
                                'Success',
                                data.message,
                                'success',
                            )
                            $('#cart_quantity').html(data.cart_count);
                            $('#cart_header').html(data.cart_header);
                        }
                    },
                    error:function(err){
                        console.log(err);
                    }
                })
            })


        $('body').on('click', '#deleteCart', function(e){
            let cart_id = $(this).data('id');
            let = path = $(this).data('url');
            // let path = "delete-cart-item";
            $.ajax({
                url:path,
                method:'POST',
                dataType:'JSON',
                data: {
                    cart_id:cart_id,
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }

                },
            
                success:function(data){
                    if(data.status){
                        Swal.fire(
                            'Success',
                            data.message,
                            'success',
                        )
                        clearCouponSession();
                        $('#cart_quantity').html(data.cart_count);
                        $('#cart_header').html(data.cart_header);
                        $('#cart_page_render').html(data.cart_page_render);
                        
                    }
                },
                error:function(err){
                    console.log(err);
                }
            })
        })

        // setInterval(() => {
        //     clearCouponSession();
        // }, 1000);
        clearCouponSession();
        function clearCouponSession(){
            let url = '/clear-coupon-session';
            $.post(url, function(){
                return true;
            })
        }

        $('body').on('click', '.DecQty', function(e){
            e.preventDefault();
            let cart_id = $(this).data('id');
            let input_val = $('#r_quantity'+cart_id).val();
            if(input_val < 1){
                alert('Cart quantity can not be less than 1');
                return false;
            }else{
                let product_quantity = $("#update-cart-"+cart_id).data('product-quantity');
                let product_cart_quantity = +($('#r_quantity'+cart_id).val())-1;
                $('#r_quantity'+cart_id).val(product_cart_quantity);
                updateCart(cart_id, product_quantity,product_cart_quantity)
                
            }
        })
        $('body').on('click', '.IncQty', function(e){
            e.preventDefault();
            let cart_id = $(this).data('id');
            let product_quantity = $("#update-cart-"+cart_id).data('product-quantity');
            let product_cart_quantity = +($('#r_quantity'+cart_id).val())+1;
            $('#r_quantity'+cart_id).val(product_cart_quantity);
           
            updateCart(cart_id, product_quantity,product_cart_quantity);
                
            
        })

        //this function updates the cart 
        function updateCart(cart_id, productQuantityStock,product_cart_quantity){
            // productQuantityStock this represents the stock quantity
            // product_cart_quantity this represents the current quantity coming from the input value each time u add or minus from cart
                let path = 'update-cart';
                $.ajax({
                    url:path,
                    method:'POST',
                    dataType:'JSON',
                    data:{
                        cart_id:cart_id,
                        productQuantityStock:productQuantityStock,
                        product_cart_quantity: product_cart_quantity,
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                    },
                    beforeSend:function(){
                        $('#quantity_show').html('<i class="fa fa-spinner fa-spin"></i>');
                    },
                    success:function(data){
                        console.log(data);
                        if(data.status == true){
                            $('#cart_quantity').html(data.cart_count);
                            $('#cart_header').html(data.cart_header);
                            $('#cart_page_render').html(data.cart_page_render);
                            toastr.success(data.msg);   
                        }else{
                            toastr.error(data.msg);
                            $('#cart_quantity').html(data.cart_count);
                            $('#cart_header').html(data.cart_header);
                            $('#cart_page_render').html(data.cart_page_render);
                        }
                    },
                    error:function(err){
                        console.log(err);
                    }
                })
        }   

        //apply coupon
        $('#applyCouponForm').on('submit', function(e){
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
                    $('#couponBtn').html('<i class="fa fa-spinner fa-spin"></i>Applying');
                },
                success:function(data){
                    console.log(data);
                    if(data.code == 0){
                        $.each(data.error, function(prefix, val){
                           $(form).find('span.'+prefix+'_error').text(val[0]);
                        })
                    }else if(data.code == 2){
                        toastr.error(data.error);
                    }else{
                        toastr.success(data.msg);
                        $('#cart_header').html(data.cart_header);
                        $('#cart_page_render').html(data.cart_page_render); 
                    }
                },
                complete:function(){
                    $('#couponBtn').html('Apply Coupon');

                }
            });
        })



})

