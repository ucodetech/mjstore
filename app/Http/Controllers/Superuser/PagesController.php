<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function Dashboard(Request $request){
        return view('users.superuser.super-dashboard');
    }


    public function showBannerPage(){
        return view('users.superuser.banner.super-banner');
    }
}
