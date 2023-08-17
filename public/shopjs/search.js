$(function(){
    $('#search_product').keyup(function(e){
        e.preventDefault();
        let search_term = $(this).val();
        let url = $(this).data('url');
        let _token =  $('meta[name="csrf-token"]').attr('content');
       if(search_term.length < 1){
        $('#showResults').html('');
       }else{
        $.get(url, {search_term:search_term, _token:_token}, function(data){
            $('#showResults').html(data);
        })
       }
       
    })
})