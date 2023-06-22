@extends('layouts.usersapp')

@section('frontcontent')
@include('inc.bread-user')

   <!-- My Account Area -->
   <section class="my-account-area section_padding_100_50">
    <div class="container">
        <div class="row">
            @include('inc.customerdashboard')
            <div class="col-12 col-lg-9">
                <div class="my-account-content mb-50">
                    <!-- Wishlist Table Area -->
                        <div class="container" id="wishlist_header">
                             {{-- @include('inc.wishlist-page') --}}
                             <div class="row" id="showWishlist">
   
                             </div>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- My Account Area -->
@include('inc.quickviewModal')

@endsection

@section('frontscripts')
<script src="{{ asset('shopjs/wishlist.js') }}"></script>
<script src="{{ asset('shopjs/cart.js') }}"></script>

  <script>
    // let user = '{{ auth()->user()->id }}';

 $(function(){
    $('body').on('click','#quickViewProduct', function(e){
            e.preventDefault();
            let url = $(this).data('url');
            let uniquekey = $(this).data('id');
            $.get(url, {uniquekey:uniquekey}, function(data){
                    $('#quickview').modal('show');
                    $('#showQuickDetails').html(data);
            })
    })

    $('body').on('click', '#deleteWishlistItem', function(e){
        let item_id = $(this).data('id');
        let path = $(this).data('url');
        $.ajax({
            url:path,
            method:'POST',
            dataType:'JSON',
            data: {
                item_id:item_id,
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            },
            success:function(data){
                if(data.code == 1){
                    fetchWishlist();
                    Swal.fire(
                        'Success',
                         data.message,
                        'success',
                    );
                }
            },
            error:function(err){
                console.log(err);
            }
        })
    })

    fetchWishlist();
    function fetchWishlist(){
        let url = "{{ route('user.fetch.user.wishlist') }}";
        $.ajax({
            url:url,
            method:'get',
            cache:false,
            data:{
                grab:'fetchUserWishlist',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            success:function(data){
                $('#showWishlist').html(data);
            }
        })
       
    }


         $('body').on('click', '.add_to_cart', function(e){
                e.preventDefault();
                let product_id = $(this).data('product-id');
                let product_quantity = $('#product_quantity'+product_id).val();
                let product_stock = $(this).data('product_stock');
                let wishlist_id = $('#wishlist_id').val();
               
                // alert(product_quantity);
                let path = "/store-cart-item";
            
                $.ajax({
                    url:path,
                    method:'POST',
                    dataType:'JSON',
                    data: {
                        product_id:product_id,
                        product_quantity:product_quantity,
                        product_stock:product_stock,
                        wishlist_id:wishlist_id,
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
                        if(data.status==true){
                            Swal.fire(
                                'Success',
                                data.message,
                                'success',
                            );
                            $('#quickview').modal('hide');
                            fetchWishlist();
                            $('#cart_quantity').html(data.cart_count);
                            $('#cart_header').html(data.cart_header);
                        }else if(data.status==false){
                            Swal.fire(
                                'Warning',
                                data.message,
                                'warning',
                            )
                        }       
                    },
                        error:function(err){
                            console.log(err);
                        }
             })
            })

            $('body').on('click', '#copyLinkBtn', function(e){
                e.preventDefault();
                let item_id = $(this).data('id');
                let val = $('#product_link'+item_id).val();
                copyToClipboard(item_id, val);
                
            })


            function copyToClipboard(item_id, val) {
            // Get the text field
                // var copyText = $('#product_link').val();
                var copyText = document.getElementById("product_link"+item_id);
                // Select the text field
                copyText.select();
                copyText.setSelectionRange(0, 99999); // For mobile devices

                // Copy the text inside the text field
                navigator.clipboard.writeText(copyText.value);
                // Alert the copied text
                // alert("Copied the text: " + copyText.value);
                toastr.success('Link copied to clipboard!');
                
        }


 })
  

  
  </script>
@endsection