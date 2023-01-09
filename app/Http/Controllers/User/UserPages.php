<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserPages extends Controller
{
    public function userDashboard(Request $request){
        return view('users.user.user-dashboard');
    }
}
