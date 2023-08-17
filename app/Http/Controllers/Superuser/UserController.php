<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use App\Models\Superuser;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;


class UserController extends Controller
{

    public function listCustomers(){
       
        $user = User::orderby('role', 'asc')->get();
        return Datatables::of($user)
                        ->addIndexColumn()
                        ->addColumn('actions', function($row){
                            //send user a link with token to make advance update on there dashboard
                            //deactivate a customer if the do something wrong or if the dnt visit
                            //there dashboard for long time
                            //send cusomter an email when the are deactivated
                            //shop link takes us to all the products the vendor have, for us to perform some operations on it
                            return '
                            
                            <div class="btn-group">
                            <button class="btn btn-info" id="userDetail"
                            data-id="'.$row->id.'" data-url="'.route('superuser.super.customer.detail').'">Details</button>
                            <a href="" 
                            class="btn btn-outline-success" title="Send link to perform update">Update</a>
                            '.(($row->role == 'vendor')? ' <a href="" 
                            class="btn btn-primary" title="View Shop">Shop</a>':'').'
                        </div>
                                    ';
                        })
                        ->addColumn('status', function($row){
                            
                            if($row->status === 'active'){
                                return ' <button type="button" 
                                data-id="'.$row->id.'" 
                                data-url="'.route('superuser.super.deactivate.customer').'"
                                id="deactivateCustomer" 
                                class="btn btn-outline-warning" title="Make Cusmoter Inactive">Deactivate</button>';
                            }else{
                                return '<button type="button" 
                                data-id="'.$row->id.'" 
                                data-url="'.route('superuser.super.activate.customer').'"
                                id="activateCustomer" 
                                class="btn btn-outline-success" title="Make Customer Active">Activate</button>';
                            }
                                    
                        })
                       
                        ->addColumn('photoCus', function($row){
                            return '<img class="img-fluid img-circle" src="'.asset('profilePhotos/userProfile/'.$row->photo ).'" width="50" height="50">';
                        })
                        ->addColumn('unique_id', function($row){
                            return '<span class="badge badge-pill badge-primary">'.$row->unique_id.'</span>';
                        })
                        ->addColumn('cusRole', function($row){
                            return '<span class="badge badge-pill badge-info">'.$row->role.'</span>';
                        })
                        ->addColumn('cusDateJoined', function($row){
                            return pretty_dates($row->created_at);
                        })
                        ->addColumn('lastLogin', function($row){
                            return timeAgo($row->last_login);
                        })
                        ->rawColumns(['actions', 'status','photoCus', 'unique_id','cusRole','cusDateJoined', 'lastLogin'])
                        ->make(true);
    }


    public function activateCustomer(Request $request){
        $customer_id = $request->customer_id;
        User::where('id', $customer_id)->update([
            'status' => 'active'
        ]);
            return 'User profile is active now';
    }   

    public function deactivateCustomer(Request $request){
        $customer_id = $request->customer_id;
        User::where('id', $customer_id)->update([
            'status' => 'inactive'
        ]);
            return 'User profile is inactive now';
    }



public function CustomerDetail(Request $request){
    $userid = $request->user_id;
    $user = User::find($userid);
    $output = '';
    $output .='
                <div class="row">
                <div class="col-md-6">
                    <img src="'.asset('profilePhotos/userProfile').'/'.$user->photo.'" alt="'.$user->fullname.'" class="img-circle" width="150">
                </div>
                <div class="col-md-6">
                    <h3 class="text-center">'.$user->fullname.'</h3>
                </div>
            </div>
            <hr>
            <div class="row p-2 mb-2">
                <div class="col-md-6">
                    Fullname:
                    <span class="text-muted">'.$user->fullname.'</span>
                </div>
                <div class="col-md-6">
                    Email:
                    <span class="text-muted"><a href="mailto:'.$user->email.'">'.$user->email.'</a></span>
                </div>
            
            </div>
            <div class="row p-2 mb-2">
                <div class="col-md-6">
                    Phone Number:
                    <span class="text-muted"><a href="tel:'.$user->phone_number.'">'.$user->phone_number.'</a></span>
                </div>
                <div class="col-md-3">
                    <div class="col-md-3">
                        Username:
                        <span class="badge badge-primary">'.$user->username.'</span>
                    </div>
                </div>
                <div class="col-md-3">
                    Unique ID:
                        <span class="badge badge-info">'.$user->unique_id.'</span>
                </div>

            </div>
            <div class="row p-2">
                <div class="col-md-4">
                    User Status:
                    <span class="btn btn-outline-'.(($user->status=='active')?'success':'warning').'">'.(($user->status == 'active')? 'Active':'Inactive').'</span>
                </div>
                <div class="col-md-4">
                    Role:
                    <span class="btn btn-outline-light">'.$user->role.'</span>
                </div>
                <div class="col-md-4">
                    Email Status:
                    <span class="btn btn-'.(($user->email_verified == 1)? 'success':'danger').'">'.(( $user->email_verified == 1 )? 'Verified':'Not Verified').'</span>
                </div>
                
            </div>
            <div class="row p-2">
                <div class="col-md-3">
                    Date Joined:
                    <span class="btn btn-outline-warning">'.pretty_dates($user->created_at).'</span>
                </div>
                <div class="col-md-3">
                    Last Login:
                    <span class="btn btn-outline-light">'.timeAgo($user->last_login).'</span>
                </div>
                <div class="col-md-6">
                    Address:
                    <p class="text-muted text-center">
                    '.$user->address.'
                    </p>
                </div>
                
            </div>
            ';
    return $output;
}


//superusers
public function listSuperusers(){
       
    $superuser = Superuser::orderby('role', 'asc')->get();
    return Datatables::of($superuser)
                    ->addIndexColumn()
                    ->addColumn('actions', function($row){
                        
                        return '
                        
                        <div class="btn-group">
                        <button class="btn btn-info" id="superuserDetail"
                        data-id="'.$row->super_uniqueid.'" data-url="'.route('superuser.super.superuser.detail').'">Details</button>
                        <a href="'.url('superuser/super-edit').'/'.$row->super_uniqueid.'" 
                        class="btn btn-outline-success">Edit</a>

                        
                    </div>
                                ';
                    })
                    ->addColumn('status', function($row){
                        
                        if($row->status === 'active'){
                            return ' <button type="button" 
                            data-id="'.$row->id.'" 
                            data-url="'.route('superuser.super.deactivate.superuser').'"
                            id="deactivateSuperuser" 
                            class="btn btn-outline-warning" title="Make Superuser Inactive">Deactivate</button>';
                        }else{
                            return '<button type="button" 
                            data-id="'.$row->id.'" 
                            data-url="'.route('superuser.super.activate.superuser').'"
                            id="activateSuperuser" 
                            class="btn btn-outline-success" title="Make Superuser Active">Activate</button>';
                        }
                                
                    })
                   
                    ->addColumn('photoCus', function($row){
                        return '<img class="img-fluid img-circle" src="'.asset('profilePhotos/superProfile').'/'.$row->super_profile_photo.'">';
                    })
                    ->addColumn('unique_id', function($row){
                        return '<span class="badge badge-pill badge-primary">'.$row->super_uniqueid.'</span>';
                    })
                    ->addColumn('cusRole', function($row){
                        return '<span class="badge badge-pill badge-info">'.$row->role.'</span>';
                    })
                    ->addColumn('cusDateJoined', function($row){
                        return pretty_dates($row->super_date_added);
                    })
                    ->addColumn('lastLogin', function($row){
                        return timeAgo($row->super_last_login);
                    })
                    ->rawColumns(['actions', 'status','photoCus', 'unique_id','cusRole','cusDateJoined', 'lastLogin'])
                    ->make(true);
}



public function activateSuperuser(Request $request){
    $superuser_id = $request->superuser_id;
    Superuser::where('id', $superuser_id)->update([
        'status' => 'active'
    ]);
        return 'Superuser profile is active now';
}   

public function deactivateSuperuser(Request $request){
    $superuser_id = $request->superuser_id;
    Superuser::where('id', $superuser_id)->update([
        'status' => 'inactive'
    ]);
        return 'Superuser profile is inactive now';
}



public function SuperuserDetail(Request $request){
        $super_uniqueid = $request->super_uniqueid;
        $user = Superuser::where('super_uniqueid', $super_uniqueid)->get()->first();
        $output = '';
        $output .='
            <div class="row">
            <div class="col-md-6">
                <img src="'.asset('profilePhotos/superProfile').'/'.$user->super_profile_photo.'" alt="'.$user->super_fullname.'" class="img-circle" width="150">
            </div>
            <div class="col-md-6">
                <h3 class="text-center">'.$user->super_fullname.'</h3>
            </div>
        </div>
        <hr>
        <div class="row p-2 mb-2">
            <div class="col-md-6">
                Fullname:
                <span class="text-muted">'.$user->super_fullname.'</span>
            </div>
            <div class="col-md-6">
                Email:
                <span class="text-muted"><a href="mailto:'.$user->super_email.'">'.$user->super_email.'</a></span>
            </div>
        
        </div>
        <div class="row p-2 mb-2">
            <div class="col-md-6">
                Phone Number:
                <span class="text-muted"><a href="tel:'.$user->super_phone_no.'">'.$user->super_phone_no.'</a></span>
            </div>
            <div class="col-md-3">
                <div class="col-md-3">
                    Username:
                    <span class="badge badge-primary">'.$user->username.'</span>
                </div>
            </div>
            <div class="col-md-3">
                Unique ID:
                    <span class="badge badge-info">'.$user->super_uniqueid.'</span>
            </div>

        </div>
        <div class="row p-2">
            <div class="col-md-4">
                User Status:
                <span class="btn btn-outline-'.(($user->status=='active')?'success':'warning').'">'.(($user->status == 'active')? 'Active':'Inactive').'</span>
            </div>
            <div class="col-md-4">
                Role:
                <span class="btn btn-outline-light">'.$user->role.'</span>
            </div>
            <div class="col-md-4">
                Email Status:
                <span class="btn btn-'.(($user->super_email_verified == 1)? 'success':'danger').'">'.(( $user->super_email_verified == 1 )? 'Verified':'Not Verified').'</span>
            </div>
            
        </div>
        <div class="row p-2">
            <div class="col-md-6">
                Date Joined:
                <span class="btn btn-outline-warning">'.pretty_dates($user->super_date_added).'</span>
            </div>
            <div class="col-md-6">
                Last Login:
                <span class="btn btn-outline-light">'.timeAgo($user->super_last_login).'</span>
            </div>
           
        </div>
        ';
return $output;
}

}//end of class
