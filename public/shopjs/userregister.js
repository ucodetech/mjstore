$(function(){

    $('#registerUserForm').on('submit', function(e){
        e.preventDefault();
        let form = this;
        
        $.ajax({
            url:$(form).attr('action'),
            method:$(form).attr('method'),
            data:new FormData(form),
            contentType:false,
            processData:false,
            datatype:'json',
            beforeSend:function(){
                $('#registerBtn').html('<span class="spinner-grow text-warning" role="status" aria-hidden="true"></span> Please Wait...');
                $(form).find('span.text-error').text('');
            },
       
            success:function(data){
                if(data.code == 0){
                    $.each(data.error, function(prefix, val){
                        $(form).find('span.'+prefix+'_error').text(val[0]);
                    })
                }else{
                    $('#registerUserForm')[0].reset();
                    toastr.success(data.msg);
                    $('#registerBtn').html('<span class="spinner-grow text-success" role="status" aria-hidden="true"></span> Redirecting...');
                    setTimeout(() => {
                        window.location = "success-user";
                    }, 2000);
                }
            }
        })
        
    })





})