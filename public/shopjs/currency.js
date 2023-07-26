
    function currency_change(code){
        let url = "../currency_load";
        $.ajax({
            url: url,
            method:"get",
            data:{
                code:code
            },
            success:function(data){
                if(data.code == 1){
                    location.reload();
                }else{
                    toSafeInteger.error('Something went wrong!');
                }
            }
        })
    }


