<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\OrderItems;

class CustomerController extends Controller
{
   

    public function userRegisterProcess(Request $request){
        $validator = Validator::make($request->all(), [
                'fullname' => 'required|min:3',
                'phone_number' => 'required|unique:users,phone_number',
                'username' => 'required|unique:users,username',
                'email' => 'required|email:rcf,dns|unique:users,email',
                // 'role' => 'required',
                'password' =>'required|min:10',
                'comfirm_password' => 'required|same:password',
        ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0, 'error'=>$validator->errors()->toArray()]);
        }else{
            
            $uniqueid = Str::random(10);
            
            $create = User::create([
                
                'fullname' => $request->fullname,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
                'photo' => 'user.png',
                'status' => 'inactive',
                'role' => 'customer',
                'unique_id' => $uniqueid,
            ]);


            if($create){
                $user = User::where('email', $request->email)->get()->first();
                $token = $user->id.hash('sha256', Str::random(120));
                $verifyUrl = route('user.customer.email.verify', ['token'=>$token, 'service'=> 'Email Service']);

                VerifyUser::create([
                    'user_id' => $user->id,
                    'token' => $token
                ]);

                $message = 'Hi, ' . $user->fullname .'<br/>';
                $message .= ' You have successfully registered on mjstore, thank you for trusting us, please do well to click on the button below to verify your email address! Thanks.';

                $mail_data = [
                    'recipient' => $request->email,
                    'fromEmail' => $request->email,
                    'fromName' => $request->fullname,
                    'subject' => 'Email Verification',
                    'body' => $message,
                    'actionLink' => $verifyUrl
                
                ];

                Mail::send('inc.email-template', $mail_data, function ($message) use ($mail_data) {
                    $message->to($mail_data['fromEmail'],$mail_data['fromName'])
                            ->from($mail_data['fromEmail'])
                            ->subject($mail_data['subject']);
                  
                });
                return response()->json(['code'=>1, 'msg'=>'You have successfully registered!']);
                
            }
        }
    }



public function VerifyEmail(Request $request){
    $token = $request->token;
    $checkToken = VerifyUser::where('token', $token)->get()->first();

    if(!is_null($checkToken)){
        $user = User::where('id', $checkToken->user_id)->get()->first();
        if($user->email_verified == 1){
            return redirect()->route('user.user.login')
            ->with('info', 'Your email have been verified already! please login')
            ->withInput();
        }else{
            User::where('id', $checkToken->user_id)
                        ->update([
                            'email_verified' => 1,
                            'status' => 'active'
                        ]);
             return redirect()->route('user.user.login')
                        ->with('success', 'Your email have been verified! please login')
                        ->withInput();

        }
    }else{
        return redirect()->route('user.user.invalidtoken')
        ->with('success', 'Your token is invalid enter your email to get a fresh token')
        ->withInput();
    }
}


public function userRegisterSuccess(Request $request){
    return view('users.user.auth.success-page');
}

public function customerDashboard(Request $request){
    return view('users.user.user-dashboard');
}



public function userLoginProcess(Request $request){
    $validator = Validator::make($request->all(),[
                'login' => 'required',
                'password' => 'required'
    ]);

    if(!$validator->passes()){
        return redirect()->back()->withErrors($validator)->withInput();
    }else{
        
        $login = $request->login;
        $password = $request->password;
        
        if(filter_var($login, FILTER_VALIDATE_EMAIL)){
            Auth::guard('web')->attempt(['email' => $login, 'password' => $password]);
            if(count(User::where('email', $login)->get())< 1){
                return redirect()->back()->withErrors('Email does not exist!')->withInput();
            }
        }else{
            Auth::guard('web')->attempt(['username' => $login, 'password' => $password]);
            if(count(User::where('username', $login)->get())< 1){
                return redirect()->back()->withErrors('Username does not exist!')->withInput();
            }
        }

        if(Auth::guard('web')->check()){
            $user =  auth()->user();
            if($user->status == 'inactive' && $user->email_verified == 1){
                Auth::guard('web')->logout();
                return redirect()->back()->withErrors('Error! You have  been suspended from the site! contact the site administrator ')->withInput();
            }

            if($user->status == 'inactive' && $user->email_verified == 0){
                $token = $user->id.hash('sha256', Str::random(120));
                $verifyUrl = route('user.customer.email.verify', ['token'=>$token, 'service'=> 'Email Service']);
                $checkToken = VerifyUser::where('user_id', $user->id)->get()->first();
                if($checkToken->count()){
                    VerifyUser::where('user_id', $user->id)->delete();
                }
                VerifyUser::create([
                    'user_id' => $user->id,
                    'token' => $token
                ]);

                $message = 'Hi, ' . $user->fullname;
                $message .= ' Please click on the link below to verify your email.';

                $mail_data = [
                    'recipient' => $user->email,
                    'fromEmail' => $user->email,
                    'fromName' => $user->fullname,
                    'subject' => 'Email Verification',
                    'body' => $message,
                    'actionLink' => $verifyUrl
                
                ];

              
              Mail::send('inc.email-template', $mail_data, function ($message) use ($mail_data) {
                    $message->to($mail_data['fromEmail'],$mail_data['fromName'])
                            ->from($mail_data['fromEmail'])
                            ->subject($mail_data['subject']);
                  
                });
                Auth::guard('web')->logout();
                return redirect()->back()->withErrors('Please verify your account! check your email for verification link')->withInput();
                  
            }else{
                if(Session::get('url.intended')){
                    return redirect()->to(Session::get('url.intended'));    
                }else{
                 return redirect()->route('user.customer.dashboard')->with('success', 'You have successfully logged in!');
                }
            }
        }else{
            return redirect()->back()->withErrors('There was an error logging you in! check your password')->withInput();
        }
    }
}

public function userLogout(){
    Auth::guard('web')->logout();
    return redirect()->route('user.user.login')->withErrors('You have logged out of the system!');
}

// check if logged in user is active and email verified
//this is prevent inactive use to login without been activated as a result network failure
public function checkUserStatus(Request $requset){
    $user = auth()->user();
    if($user->email_verified == 0){
        Auth::guard('web')->logout();
        // return redirect()->route('user.user.login')->withErrors('An Error occured please relogin!');
    }

}



 public function userProfile(Request $request){
    //code
    return view('users.user.user-profile');
 }

 public function userOrders(Request $request){
    //code
    $orders = Order::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->paginate(5);
    return view('users.user.user-orders', ['orders'=>$orders]);
 }

 public function OrderItems($orderId){
    $items = OrderItems::with('products')->where('u_order_id', $orderId)->get();
    return view('users.user.order-details', ['items'=>$items]);
    
 }

 public function userAddresses(Request $request){
    //code
    $countries = Country::orderBy('country', 'asc')->get();
    return view('users.user.users-addresses', ['countries'=> $countries]);
 }

 public function updateBillingAddress(Request $request){
    $validator = Validator::make($request->all(), [
                    'address' => 'required',
                    'country' => 'required',
                    'state' => 'required',
                    'town' => 'required',
                    'postcode' => 'required'
    ]);
    if(!$validator->passes()){
        return response()->json(['code'=>0, 'error'=>$validator->errors()->toArray()]);
    }else{
        $user = auth()->user()->id;
        User::where('id', $user)->update([
            'address' => $request->address, 
            'country' => $request->country, 
            'state' => $request->state, 
            'town_city' => $request->town,
            'postcode_zip' => $request->postcode, 
            'apartment_suite_unit' => $request->apartment,
            'updated_at' => Carbon::now()
        ]);
        return response()->json(['code'=>1, 'msg'=>'Billing Address Updated Successfully!']);
    }
 }

 public function fetchBillingAddress(Request $request){
    if($request->data == 'fetchBillingAddress'){
        $userdata = User::where('id', auth()->user()->id)->get()->first();
        $output = '';
        if($userdata->apartment_suite_unit != ''){
            $apartment = $userdata->apartment_suite_unit;
        }else{
            $apartment = '';
        }
        $output.=' <h6 class="mb-3">Billing Address</h6>
                <address>
                    '.$apartment.'<br>
                    '.$userdata->postcode_zip.' <br>
                    '.$userdata->address.' <br>
                    '.$userdata->town_city.'<br>
                    '.$userdata->state.' <br>
                    '.$userdata->country.' <br>
                    
                </address>';
        return $output;
    }
 }


 public function updateShippingAddress(Request $request){
    $validator = Validator::make($request->all(), [
                    'ship_address' => 'required',
                    'ship_country' => 'required',
                    'ship_state' => 'required',
                    'ship_town' => 'required',
                    'ship_postcode' => 'required'
    ]);
    if(!$validator->passes()){
        return response()->json(['code'=>0, 'error'=>$validator->errors()->toArray()]);
    }else{
        $user = auth()->user()->id;
        User::where('id', $user)->update([
            'ship_to_address' => $request->ship_address, 
            'ship_to_country' => $request->ship_country, 
            'ship_to_state' => $request->ship_state, 
            'ship_to_city_town' => $request->ship_town,
            'ship_to_postcode_zip' => $request->ship_postcode, 
            'ship_to_apartment_suite_unit' => $request->ship_apartment,
            'updated_at' => Carbon::now()
        ]);
        return response()->json(['code'=>1, 'msg'=>'Shipping Address Updated Successfully!']);
    }
 }

 public function fetchShippingAddress(Request $request){
    if($request->data == 'fetchShippingAddress'){
        $userdata = User::where('id', auth()->user()->id)->get()->first();
        $output = '';
        if($userdata->ship_to_apartment_suite_unit != ''){
            $apartment = $userdata->ship_to_apartment_suite_unit;
        }else{
            $apartment = '';
        }
        $output.=' <h6 class="mb-3">Shipping Address</h6>
                <address>
                    '.$apartment.'<br>
                    '.$userdata->ship_to_postcode_zip.' <br>
                    '.$userdata->ship_to_address.' <br>
                    '.$userdata->ship_to_city_town.'<br>
                    '.$userdata->ship_to_state.' <br>
                    '.$userdata->ship_to_country.' <br>
                    
                </address>';
        return $output;
    }
 }

 public function userDownloads(Request $request){
    //code
    return view('users.user.users-downloads');
 }



//update profile photo
public function updateProfilePhoto(Request $request){
    $validator = Validator::make($request->all(),[
                    'profile_photo' => 'required|mimes:png,jpeg|max:5080',
    ]);

    if(!$validator->passes()){
        return response()->json(['code'=>0, 'error'=>$validator->errors()->toArray()]);
    }else{
        if($request->hasFile('profile_photo')){
            $folder = 'profilePhotos/userProfile/';
            $fullname = explode(' ', auth()->user()->fullname);
            $name = $fullname[0];
            $newname = $name . auth()->user()->unique_id . '.' . $request->profile_photo->extension();
            if($request->profile_photo->move(public_path($folder), $newname)){
                User::where('id', auth()->user()->id)->update([
                    'photo' => $newname,
                    'updated_at' => Carbon::now()
                ]);
                return response()->json(['code'=>2, 'msg'=>'Profile Photo updated!']);

            }else{
                return response()->json(['code'=>3, 'uperror'=>'An error occured! try again']);

            }
        }
    }
}


public function updateCustomerPassword(Request $request){
    $validator = Validator::make($request->all(), [
        'currentPass' => 'required',
        'newPass' => 'required|min:10',
        'confirmPass' => 'required|same:newPass',
       
       ]);

    if(!$validator->passes()){
            return  response()->json(['code'=>0, 'error'=>$validator->errors()->toArray()]);
        }else{
            $current = $request->currentPass;
            $old_password = auth()->user()->password;
           
            if(Hash::check($current, $old_password)){
                if(Hash::check($request->newPass, $old_password)){
                    return  response()->json(['code'=>4, 'cerror'=>'New password can not be same with exisitng password!']);
                }

                User::where('id', auth()->user()->id)->update([
                    'password' => Hash::make($request->newPass)
                ]);

                Auth::guard('web')->logout();
                return  response()->json(['code'=>1, 'msg'=>'Password changed you will be logged out of the system!']);
               
            }else{
                return  response()->json(['code'=>3, 'cerror'=>'Current Password is incorrect!']);
            }

    }
}

public function updateDetails(Request $request){
    $validator = Validator::make($request->all(),[
            'fullname' => 'required|string',
            'phone_number' => 'required|unique:users,phone_number,'.auth()->user()->id,
    ]);

    if(!$validator->passes()){
        return response()->json(['code'=>0, 'error'=>$validator->errors()->toArray()]);
    }else{
        if($request->phone_no_2 != ''){
            if($request->phone_no_2 == $request->phone_number){
                return response()->json(['code'=> 3, 'perror'=>'Your second phone number can not be same with your primary phone number!']);
            }
            $phoneNo = $request->phone_number .','.$request->phone_no_2;
        }else{
            $phoneNo = $request->phone_number;
        }
        User::where('id', auth()->user()->id)->update([
                'fullname' => $request->fullname,
                'phone_number' => $phoneNo,
                'updated_at' => Carbon::now(),
                
        ]);
         return response()->json(['code'=> 1, 'msg'=>'Details Upated Successfully!']);
    }
}


}// end of class
