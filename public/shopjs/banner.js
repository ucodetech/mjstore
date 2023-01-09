$(function(){

                            
    $('#bannerTableID').DataTable({
        processing: true,
        info:true,
        ajax:'super-banners-list',
        columns: [
            {data:'DT_RowIndex', name:'DT_RowIndex'},
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
            action:$(form).attr('action'),
            method:$(form).attr('method'),
            data:new FormData(form),
            contentType:false,
            dataType: 'json',
            beforeSend:function(){
                $(form).find('span.text-error').text('');
            },
            success:function(data){
                if(data.code === 0){
                    $.each(data.error, function(prefix, val){
                        $(form).find('span.'+prefix+'_error').text([0]);
                    })
                }else{
                    toastr.success(data.msg);
                }
            }
        });
    })

    $('#banner_description').summernote();
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


});