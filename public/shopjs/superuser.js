function readURLProfile(input){
  if(input.files && input.files[0]){
    let reader = new FileReader();
    reader.onload = function(e){
      $('#profilePhoto').html('<label style="cursor:pointer" for="profile_photo"><img src="'+e.target.result+'" alt="profile photo" class="profile-user-img img-fluid img-circle"></label>');
    }
    reader.readAsDataURL(input.files[0]);
  }
}

$(function(){

  $('#profile_photo').on('change', function(e){
    readURLProfile(this);
  })
                            
    $('#superusersTable').DataTable({
        processing: true,
        info:true,
        ajax:'super-superusers-list',
        columns: [
            {data:'DT_RowIndex', name:'DT_RowIndex'},
            {data:'unique_id', name:'unique_id'},
            {data:'photoCus', name:'photoCus'},
            {data:'super_fullname', name:'super_fullname'},
            {data:'username', name:'username'},
            {data:'super_email', name:'super_email'},
            {data:'super_phone_no', name:'super_phone_no'},
            {data:'cusRole', name:'cusRole'},
            {data:'cusDateJoined', name:'cusDateJoined'},
            {data:'lastLogin', name:'lastLogin'},
            {data:'status', name:'stauts'},
            {data:'actions', name:'actions'}
        ]

       

    });

  
    // deactivate brand
    $('body').on('click','#deactivateSuperuser' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let superuser_id = $(this).data('id');
        Swal.fire({
          title:'Are you sure?',
          text: 'Superuser will be deactivated!',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes deactivate it!',
          allowOutsideClick:false
        }).then(function(result){
            if(result.value){
              $.post(url, {superuser_id:superuser_id}, function(data){
                  Swal.fire(
                    'Superuser deactivated!',
                     data,
                    'success'
                  );
                  $('#superusersTable').DataTable().ajax.reload(null,false);
                
              });
            }
        });

    })
    // active brand
    $('body').on('click','#activateSuperuser' ,function(e){
        e.preventDefault();
        let url = $(this).data('url');
        let superuser_id = $(this).data('id');
        Swal.fire({
          title:'Are you sure?',
          text: 'Superuser will activated',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes activate it!',
          allowOutsideClick:false
        }).then(function(result){
            if(result.value){
              $.post(url, {superuser_id:superuser_id}, function(data){
                  Swal.fire(
                    'Superuser Activated!',
                     data,
                    'success'
                  );
                  $('#superusersTable').DataTable().ajax.reload(null,false);
                
              });
            }
        });

    })
  
    $('body').on('click', '#superuserDetail', function(e){
      e.preventDefault();
      let url = $(this).data('url');
      let super_uniqueid = $(this).data('id');
      $.post(url, {super_uniqueid:super_uniqueid}, function(data){
        $("#superuserDetailModal").modal('show');
        $('#showSuperUserDetails').html(data);
      })
    })

});