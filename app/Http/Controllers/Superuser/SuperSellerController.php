<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seller;
use App\Models\SellerBusinessInformation;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Mail;


class SuperSellerController extends Controller
{
    
    public function listSellers(){
       
        $user = Seller::orderby('id', 'desc')->get();
        return Datatables::of($user)
                        ->addIndexColumn()
                        ->addColumn('bizOption', function($row){
                                if($row->business_options == 0){
                                    return '<span class="badge badge-pill badge-warning">Unregistered Business</span>';
                                }else{
                                    return '<span class="badge badge-pill badge-primary">Registered Business</span>';
                                }
                        })
                        ->addColumn('actions', function($row){
                            //send user a link with token to make advance update on there dashboard
                            //deactivate a customer if the do something wrong or if the dnt visit
                            //there dashboard for long time
                            //send cusomter an email when the are deactivated
                            //shop link takes us to all the products the vendor have, for us to perform some operations on it
                            $cansell =  $row->can_sell_now == 0 ? "<span class='badge badge-btn badge-danger'>New</span>":"";
                            return '
                            <div class="btn-group">
                                 <a class="btn btn-info" 
                                 data-id="'.$row->id.'" href="'.route('superuser.super.seller.detail', $row->unique_key).'">Details</a>
                                '.$cansell.'
                            </div>
                                    ';
                        })
                        ->addColumn('status', function($row){
                            
                            if($row->status === 'active'){
                                return ' <button type="button" 
                                data-id="'.$row->id.'" 
                                data-url="'.route('superuser.super.deactivate.seller').'"
                                id="deactivateSeller" 
                                class="btn btn-outline-warning" title="Deactivate Seller">Deactivate</button>';
                            }else{
                                return '<button type="button" 
                                data-id="'.$row->id.'" 
                                data-url="'.route('superuser.super.activate.seller').'"
                                id="activateSeller" 
                                class="btn btn-outline-success" title="Activate Seller">Activate</button>';
                            }
                                    
                        })
                       
                        ->addColumn('photoCus', function($row){
                            return '<img class="img-fluid img-circle" src="'.asset('profilePhotos/sellerProfile/'.$row->manager_profile_photo).'" width="50">';
                        })
                        ->addColumn('unique_id', function($row){
                            return '<span class="badge badge-pill badge-primary">'.$row->unique_key.'</span>';
                        })
                       
                        ->addColumn('cusDateJoined', function($row){
                            return pretty_dates($row->manager_date_added);
                        })
                        ->addColumn('lastLogin', function($row){
                            return timeAgo($row->manager_last_login);
                        })
                        ->rawColumns(['bizOption','actions', 'status','photoCus', 'unique_id','cusDateJoined', 'lastLogin'])
                        ->make(true);
    }


    public function activateSeller(Request $request){
        $seller_id = $request->seller_id;
        Seller::where('id', $seller_id)->update([
            'status' => 'active'
        ]);
            return 'Seller profile is activated';
    }   

    public function deactivateSeller(Request $request){
        $seller_id = $request->seller_id;
        Seller::where('id', $seller_id)->update([
            'status' => 'inactive'
        ]);
            return 'Seller profile is deactivated';
    }



public function SellerDetail($uniquekey){
    $biz = Seller::with('business_information')->where('unique_key', $uniquekey)->first();
    return view('users.superuser.sellers.super-sellerdetails', ['biz'=>$biz]);
    
}

public function sellerApprove(Request $request){
    if($request->seller_id)
        SellerBusinessInformation::where('seller_id', $request->seller_id)->update([
                    'approved' => 1,
                    'Date_Approved' => Carbon::now()
        ]);

        Seller::where('id', $request->seller_id)->update([
            'can_sell_now' => 1
        ]);
        $seller = Seller::GetSellerByID($request->seller_id);
        $url = route('seller.vendor.dashboard');
        $message = 'Hi, ' .$seller->manager_fullname .'<br>';
        $message .= "Your account have been successfully approved! You Can start creating products! 
        <br> Click the button below to access your dashboard <br><br>";
        $message .= " Thank You for choosing us";
        $actionLink = $url;
        $actionLinkText = "Dashboard";
        $data = [
            'mailFrom' => 'noreply.mjstore.account@mjstore.com',
            'mailFromName' => 'MJStore Account',
            'mailTo' => $seller->manager_email,
            'mailToName' => $seller->manager_fullname,
            'subject' => 'Account Approval',
            'body' => $message,
            'actionLink' => $actionLink,
            'actionLinkText' => $actionLinkText
        ];

        Mail::send('inc.email-template', $data, function ($message) use ($data) {
            $message->from($data['mailFrom'], $data['mailFromName'])
                ->sender($data['mailFrom'])
                ->to($data['mailTo'], $data['mailToName'])
                ->cc('mjstore.account@mjstore.com', 'Account')
                ->subject($data['subject']);
            // $message->priority(3);
            // $message->attach('pathToFile');
        });

        return response()->json(['Seller have been approved, and can now sell!']);
    return false;
}




}
