@extends('layouts.editheadapp')
@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('inc.editbread')
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <!-- Info boxes -->
          
        </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('scripts')
      <script>

      function readURL(input){
        if(input.files && input.files[0]){
            let reader = new FileReader();
            reader.onload = function(e){
                $('#showBrandPreview').html('<label for="edit_brand_file"><img src="'+e.target.result+'" alt="brand" class="img-fluid"></label>');
            }
            reader.readAsDataURL(input.files[0]);
        }
      }
      
       $(function(){
        
        $('#edit_brand_file').on('change', function(){
            readURL(this);
        })

      
     
  })

      </script>
@endsection 
 

 

 