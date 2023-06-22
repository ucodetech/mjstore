<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserPages extends Controller
{
    public function userDashboard(Request $request){
        return view('users.user.user-dashboard');
    }

    public function userLogin(Request $request){
        return view('users.user.auth.login-user');
    }

    public function userRegister(Request $request){
        return view('users.user.auth.register-user');
    }

}
