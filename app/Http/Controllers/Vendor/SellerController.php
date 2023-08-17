<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\RegisteredShop;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\VerifySeller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    //
    public function sellerRegister(){
        return view('users.seller.auth.register');
    }

    public function sellerRegisterProcess(Request $request){
        //
        $validator = Validator::make($request->all(), [
                        'shop_name' => 'required|unique:sellers,shop_name',
                        'business_options' => 'required',
                        'manager_fullname' => 'required|string|min:5|max:150',
                        'manager_tel' => 'required|numeric|min:11|unique:sellers,manager_tel',
                        'manager_email' => 'required|email|unique:sellers,manager_email',
                        'manager_profile_photo' => 'required|mimes:png,jpeg,jpg|max:5080',
                        'password' => 'required|min:10',
                        'verify_password' => 'required|same:password'
                        
        ]);
        if(!$validator->passes()){
            return response()->json(['code'=>0, 'error'=>$validator->errors()->toArray()]);
        }else{
            $shopname  = ucwords($request->shop_name);
            if($request->hasFile('manager_profile_photo')){
                $file = $request->file('manager_profile_photo');
                $fileNewName = Str::random(10) . '.' . $file->extension();
                $path = "profilePhotos/sellerProfile/";
                $request->manager_profile_photo->move(public_path($path), $fileNewName);
            }
            $key = Str::random(10);
            $register = Seller::create([
                        'unique_key' => $key,
                        'shop_name' =>$shopname,
                        'business_options' =>$request->business_options,
                        'manager_fullname' =>$request->manager_fullname,
                        'manager_tel' =>$request->manager_tel,
                        'manager_email' =>$request->manager_email,
                        'role' => 'seller',
                        'password' => Hash::make($request->password),
                        'manager_profile_photo' => $fileNewName
                        
            ]);

            if($register){
                $user = Seller::where('manager_email', $request->manager_email)->get()->first();
                $token = $user->id.hash('sha256', Str::random(120));
                $verifyUrl = route('seller.vendor.email.verify', ['token'=>$token, 'service'=> 'Email Service']);
                $actionLinkText = "";
                VerifySeller::create([
                    'seller_id' => $user->id,
                    'token' => $token
                ]);
                RegisteredShop::create([
                        'shop_name' => $user->shop_name,
                        'seller_id' => $user->id
                ]);

                $message = 'Hi, ' . $user->manager_fullname .'<br/>';
                $message .= ' You have successfully created a seller account on MJStore, thank you for trusting us, please do well to click on the button below to verify your email address! Thanks.';
                $data = [
                    'mailFrom' => 'mjstore.account@mjstore.com',
                    'mailSender' => 'mjstore.account@mjstore.com',
                    'mailTo' => $request->manager_email,
                    'mailToName' => $user->manager_fullname,
                    'subject' => 'Account Creation',
                    'body' => $message,
                    'actionLink' => $verifyUrl,
                    'actionLinkText' => 'Verify Email'

                ];
                Mail::send('inc.email-template', $data, function ($message) use ($data) {
                    $message->from($data['mailFrom'], 'MJStore Account')
                            ->sender($data['mailSender'], 'MJStore Account')
                            ->to($data['mailTo'], 'mailToName')
                            ->subject($data['subject']);
                   
                });
                return response()->json(['code'=>1, 'msg'=>'You have successfully registered! check your mail box for email verification link']);
            }
        }
    }

    public function sellerRegisterSuccess(){
        return view('users.seller.auth.seller-success');
    }

    public function sellerLogin(){
        return view('users.seller.auth.login');
    }

    public function sellerLoginProcess(Request $request){
        $validator = Validator::make($request->all(),[
            'manager_email' => 'required|email|exists:sellers,manager_email',
            'password' => 'required'
        ], [
            'manager_email.exists' => 'Seller not found!'
        ]);

        if(!$validator->passes()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            
            $email = $request->manager_email;
            $password = $request->password;
            
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                Auth::guard('seller')->attempt(['manager_email' => $email, 'password' => $password]);
                if(count(Seller::where('manager_email', $email)->get())< 1){
                    return redirect()->back()->withErrors('Seller Not Found!')->withInput();
                }
                
            }
           

            if(Auth::guard('seller')->check()){
                $user =  Auth::guard('seller')->user();
                if($user->status == 'inactive' && $user->email_verified == 1){
                    Auth::guard('seller')->logout();
                    return redirect()->back()->withErrors('Error! You have  been suspended from the site! contact the site administrator ')->withInput();
                }

                if($user->status == 'inactive' && $user->email_verified == 0){
                    $token = $user->id.hash('sha256', Str::random(120));
                    $verifyUrl = route('seller.vendor.email.verify', ['token'=>$token, 'service'=> 'Email Service']);
                    $checkToken = VerifySeller::where('seller_id', $user->id)->get()->first();
                    if($checkToken->count()){
                        VerifySeller::where('seller_id', $user->id)->delete();
                    }
                    VerifySeller::create([
                        'seller_id' => $user->id,
                        'token' => $token
                    ]);

                    $message = 'Hi, ' . $user->manager_fullname;
                    $message .= ' Please click on the link below to verify your email.';

                    $mail_data = [
                        'recipient' => $user->manager_email,
                        'fromEmail' => 'mjstore.account@mjstore.com',
                        'fromName' =>"MJStore Account",
                        'subject' => 'Email Verification',
                        'body' => $message,
                        'actionLink' => $verifyUrl,
                        'actionLinkText' => 'Verify Email'
                    
                    ];

                
                Mail::send('inc.email-template', $mail_data, function ($message) use ($mail_data) {
                        $message->to($mail_data['recipient'],$mail_data['fromName'])
                                ->from($mail_data['fromEmail'], $mail_data['fromName'])
                                ->subject($mail_data['subject']);
                    
                    });
                    Auth::guard('seller')->logout();
                    return redirect()->back()->withErrors('Please verify your account! check your email for verification link')->withInput();
                    
                }else{
                    if(Session::get('url.intended')){
                        return redirect()->to(Session::get('url.intended'));    
                    }else{
                    Seller::where('id', $user->id)->update([
                        'manager_last_login' => Carbon::now()
                    ]);
                    return redirect()->route('seller.vendor.dashboard')->with('success', 'You have successfully logged in!');
                    }
                }
            }else{
                return redirect()->back()->withErrors('There was an error logging you in! check your password')->withInput();
            }
        }
    }

    public function checkShopName(Request $req){
        $name = $req->shopname;
        $getname = RegisteredShop::where('shop_name', $name)->get();
        if(count($getname)>0){
            return response()->json(['code'=>0, 'error'=>$name.' Has been taken already! choose another name!']);
        }else{
            return response()->json(['code'=>1, 'msg'=>$name.' Accepted Proceed!']);
        }
    }

    public function VerifyEmail(Request $request){
        $token = $request->token;
        $checkToken = VerifySeller::where('token', $token)->get()->first();
    
        if(!is_null($checkToken)){
            $user = Seller::where('id', $checkToken->seller_id)->get()->first();
            if($user->email_verified == 1){
                return redirect()->route('seller.vendor.login')
                ->with('info', 'Your email have been verified already! please login')
                ->withInput();
            }else{
                Seller::where('id', $checkToken->seller_id)
                            ->update([
                                'email_verified' => 1,
                                'status' => 'active'
                            ]);
                 return redirect()->route('seller.vendor.login')
                            ->with('success', 'Your email have been verified! please login')
                            ->withInput();
    
            }
        }else{
            return redirect()->route('seller.vendor.invalidtoken')
            ->with('success', 'Your token is invalid enter your email to get a fresh token')
            ->withInput();
        }
    }
    
    public function sellerLogout(){
        Auth::guard('seller')->logout();
        return redirect()->route('seller.vendor.login')->withErrors('You have logged out of the system!');
    }

    public function sellerProfile(){
        $seller = Seller::where('id', auth('seller')->user()->id)->get()->first();
        return view('users.seller.auth.seller-profile', ['seller'=>$seller]);
    }

    public function updateSeller(Request $request){
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|min:3',
            'manager_email' => 'required|unique:sellers,manager_email,'.auth('seller')->user()->id,
            'manager_tel' => 'required|unique:sellers,manager_tel,'.auth('seller')->user()->id,
           
        ]);
    
        if(!$validator->passes()){
            return  redirect()->back()->withErrors($validator)->withInput();
        }else{
        
            if($request->manager_email != auth('seller')->user()->manager_email){
                $email_changed = 1;
            }else{
                $email_changed = 0;
            }
    
            Seller::where('id', auth('seller')->user()->id)->update([
                'manager_fullname' => $request->fullname,
                'manager_email' => $request->manager_email,
                'manager_tel' => $request->manager_tel,
                'email_changed' => $email_changed
                
            ]);
    
    
        if(auth('seller')->user()->email_changed == 1){
            Seller::where('id', auth()->user()->id)->update([
                'email_verified' => 0,
                'status' => 'inactive'
                
            ]);
            $user = auth('seller')->user();
            $token = $user->id.hash('sha256', Str::random(120));
            $verifyUrl = route('seller.vendor.email.verify', ['token'=>$token, 'service'=> 'Email Service']);
            VerifySeller::where('seller_id', $user->id)->delete();
            VerifySeller::create([
                'seller_id' => $user->id,
                'token' => $token
            ]);
    
            $message = 'Hi, ' . $user->manager_fullname;
            $message .= 'You made an update on your profile and your email was changed please click on the verification button below to verify your new email address!.
            .';
    
            $mail_data = [
                'recipient' => $request->manager_email,
                'fromEmail' => $request->manager_email,
                'fromName' => $request->manager_fullname,
                'subject' => 'Email Verification',
                'body' => $message,
                'actionLink' => $verifyUrl,
                'actionLinkText' => 'Verify Email'
            
            ];
    
            Mail::send('inc.email-template', $mail_data, function ($message) use ($mail_data) {
                $message->to($mail_data['fromEmail'],$mail_data['fromName'])
                        ->from($mail_data['fromEmail'])
                        ->subject($mail_data['subject']);
              
            });
            Auth::guard('seller')->logout();
            return redirect()->route('seller.vendor.login')->withErrors('You have logged out of the system!');;
            // return redirect()->route('Seller.super.Seller.page')->with('success','Seller Added Successfully and Needs Verification')->withInput();
        }else{
             return redirect()->route('seller.vendor.profile')->with('success','You have successfully updated your details')->withInput();
        }
        }
    }
    
    public function updateSellerPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required',
            'confirm_new_password' => 'required|same:new_password',
                
            ]);
    
        if(!$validator->passes()){
                return  redirect()->back()->withErrors($validator)->withInput();
            }else{
                $current = $request->current_password;
                $old_password = auth('seller')->user()->password;
              
                if(Hash::check($current, $old_password)){
                    Seller::where('id', auth('seller')->user()->id)->update([
                        'password' => Hash::make($request->new_password)
                    ]);
    
                    Auth::guard('seller')->logout();
                    return redirect()->route('seller.vendor.login')->withErrors('You have been logged out of the system because you changed your password please re-login with your new password!');
                }else{
                    return  redirect()->back()->withErrors('Current Password is incorrect!')->withInput();
                }
    
    }
    }
    
    
    public function updateSellerPhoto(Request $request){
        $validator = Validator::make($request->all(), [
                        'manager_profile_photo' => 'required|mimes:jpg,jpeg,png|max:5080'
        ]);
        if(!$validator->passes()){
            return  redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $newname = auth('seller')->user()->manager_fullname[1] . auth('seller')->user()->unique_key. '.'.$request->profile_photo->extension();
            if($request->profile_photo->move(public_path('profilePhotos/sellerProfile'), $newname)){
                Seller::where('id', auth('seller')->user()->id)->update([
                    'manager_profile_photo' => $newname
                ]);
                return  redirect()->route('seller.vendor.profile')->with('info', 'Profile Photo Updated Successfully!');
            }else{
                return  redirect()->route('seller.vendor.profile')->with('fail', 'Error Updating Profile Photo!');
            }
        }
       
    }


}// end of class









