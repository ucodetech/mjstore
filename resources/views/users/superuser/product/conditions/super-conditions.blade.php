@extends('layouts.superuserapp')
@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('inc.bread')
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <!-- Info boxes -->
           
                  <div class="card m-md-auto w-50">
                      <div class="card-header">
                          Add Condition
                      </div>
                      <div class="card-body">
                          <form action="{{ route('superuser.super.add.conditions') }}" method="POST"
                           id="addConditionForm">
                           @csrf
                           @method('POST')
                            
                            <div class="form-group">
                                <label for="condition">Condition</label>
                                <input type="text" name="condition" id="condition" class="form-control" 
                                aria-describedby="helpId">
                                <span  class="text-danger text-error condition_error"></span>
                              </div>
                                <button type="submit" class="btn btn-primary">Add Condition</button>
                          </form>
                      </div>
                      
                  </div>
                  <hr>
               
                     <div class="card">
                        <div class="card-header">
                            List of Conditions
                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
                            <table class="table table-striped table-inverse table-hover" id="conditionTable">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>#</th>
                                        <th>Condition</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                            </table>
                           </div>
                        </div>
                        
                     </div>
               
                
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection




   

   
