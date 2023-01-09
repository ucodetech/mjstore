<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Superuser;
use App\Models\VerifySuperuser;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SuperuserController extends Controller
{
    public function showRegisterPage(Request $request){
        return view('users.superuser.auth.register');
    }

    public function showLogin(){
        return view('users.superuser.auth.login');
    }

    public function processRegister(Request $request){
        $validator = Validator::make($request->all(), [
                'fullname' => 'required|min:3',
                'super_email' => 'required|unique:superusers,super_email',
                'super_phone_no' => 'required|unique:superusers,super_phone_no',
                'role' => 'required',
                'password' =>'required|min:10',
                'verify_password' => 'required|same:password',
        ]);

        if(!$validator->passes()){
            return  redirect()->back()->withErrors($validator)->withInput();
        }else{
            $username = explode(' ', $request->fullname);
            $username = $username[1];
            $username = strtolower($username).rand(1111,9999);
            $uniqueid = Str::random(10);
            
            $create = Superuser::create([
                'super_fullname' => $request->fullname,
                'super_email' => $request->super_email,
                'super_phone_no' => $request->super_phone_no,
                'super_uniqueid' => $uniqueid,
                'username' => $username,
                'role' => $request->role,
                'password' => Hash::make($request->password),
                'status' => 'active'
            ]);


            if($create){
                $user = Superuser::where('super_email', $request->super_email)->get()->first();
                $token = $user->id.hash('sha256', Str::random(120));
                $verifyUrl = route('superuser.super.email.verify', ['token'=>$token, 'service'=> 'Email Service']);

                VerifySuperuser::create([
                    'user_id' => $user->id,
                    'token' => $token
                ]);

                $message = 'Hi, ' . $user->fullname;
                $message .= 'You have been added to MJStore Admin Panel. Your username is '.$username.' and 
                Password is '.$request->password.' please do well to change your password on your first login thanks.
                Also Please click on the link below to verify your email.';

                $mail_data = [
                    'recipient' => $request->super_email,
                    'fromEmail' => $request->super_email,
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
                return redirect()->back()->with('success','Superuser Added Successfully and Needs Verification')->withInput();
            }
        }
    }





public function VerifyEmail(Request $request){
    $token = $request->token;
    $checkToken = VerifySuperuser::where('token', $token)->get()->first();

    if(!is_null($checkToken)){
        $user = Superuser::where('id', $checkToken->user_id)->get()->first();
        if($user->super_email_verified === 1){
            return redirect()->route('superuser.super.login')
            ->with('info', 'Your email have been verified already! please login')
            ->withInput();
        }else{
            Superuser::where('id', $checkToken->user_id)
                        ->update([
                            'super_email_verified' => 1
                        ]);
             return redirect()->route('superuser.super.login')
                        ->with('success', 'Your email have been verified! please login')
                        ->withInput();

        }
    }else{
        return redirect()->route('superuser.super.invalidtoken')
        ->with('success', 'Your token is invalid enter your email to get a fresh token')
        ->withInput();
    }
}

public function processLogin(Request $request){
    $validator = Validator::make($request->all(),[
                'username' => 'required|exists:superusers,username',
                'password' => 'required'
    ],[
        'username.exists' => 'Superuser not found!'
    ]);
    if(!$validator->passes()){
        return redirect()->back()->withErrors($validator)->withInput();
    }else{
        $check = $request->only('username', 'password');
        if(Auth::guard('superuser')->attempt($check)){
            $user = Superuser::where('username', $request->username)->get()->first();
            if($user->deleted == 1){
                Auth::guard('superuser')->logout();
                return redirect()->back()->withErrors('You have been suspened from accessing admin panel please contact superuser')->withInput();
            }
            if($user->super_email_verified == 0){
                $token = $user->id.hash('sha256', Str::random(120));
                $verifyUrl = route('superuser.super.email.verify', ['token'=>$token, 'service'=> 'Email Service']);
                $checkToken = VerifySuperuser::where('user_id', $user->id)->get()->first();
                if($checkToken->count()){
                    VerifySuperuser::where('user_id', $user->id)->delete();
                }
                VerifySuperuser::create([
                    'user_id' => $user->id,
                    'token' => $token
                ]);

                $message = 'Hi, ' . $user->fullname;
                $message .= 'Please click on the link below to verify your email.';

                $mail_data = [
                    'recipient' => $user->super_email,
                    'fromEmail' => $user->super_email,
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
                Auth::guard('superuser')->logout();
                return redirect()->back()->withErrors('Please verify your account! check your email for verification link')->withInput();
            }else{
                return redirect()->intended(route('superuser.super.dashboard'))->with('success', 'You have successfully logged in!');
            }
        }else{
            return redirect()->back()->withErrors('There was an error logging you in! check your password')->withInput();
        }
    }
}

public function superLogout(){
    Auth::guard('superuser')->logout();
    return redirect()->route('superuser.super.login')->withErrors('You have logged out of the system!');
}

}
