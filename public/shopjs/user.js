

$(function(){

                            
    $('#usersTable').DataTable({
        processing: true,
        info:true,
        ajax:'super-cusomters-list',
        columns: [
            {data:'DT_RowIndex', name:'DT_RowIndex'},
            {data:'unique_id', name:'unique_id'},
            {data:'photoCus', name:'photoCus'},
            {data:'fullname', name:'fullname'},
            {data:'username', name:'username'},
            {data:'email', name:'email'},
            {data:'phone_number', name:'phone_number'},
            {data:'cusRole', name:'cusRole'},
            {data:'cusDateJoined', name:'cusDateJoined'},
            {data:'lastLogin', name:'lastLogin'},
            {data:'status', name:'stauts'},
            {data:'actions', name:'actions'}
        ]

       

    });

  
    // deactivate brand
    $('body').on('click','#deactivateCustomer' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let customer_id = $(this).data('id');
        Swal.fire({
          title:'Are you sure?',
          text: 'Customer will be deactivated!',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes deactivate it!',
          allowOutsideClick:false
        }).then(function(result){
            if(result.value){
              $.post(url, {customer_id:customer_id}, function(data){
                  Swal.fire(
                    'Customer deactivated!',
                     data,
                    'success'
                  );
                  $('#usersTable').DataTable().ajax.reload(null,false);
                
              });
            }
        });

    })
    // active brand
    $('body').on('click','#activateCustomer' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let customer_id = $(this).data('id');
        Swal.fire({
          title:'Are you sure?',
          text: 'Customer will activated',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes activate it!',
          allowOutsideClick:false
        }).then(function(result){
            if(result.value){
              $.post(url, {customer_id:customer_id}, function(data){
                  Swal.fire(
                    'Customer Activated!',
                     data,
                    'success'
                  );
                  $('#usersTable').DataTable().ajax.reload(null,false);
                
              });
            }
        });

    })
  
    $('body').on('click', '#userDetail', function(e){
      e.preventDefault();
      let url = $(this).data('url');
      let user_id = $(this).data('id');
      $.post(url, {user_id:user_id}, function(data){
        $("#userDetailModal").modal('show');
        $('#showUserDetails').html(data);
      })
    })

});