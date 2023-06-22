<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class SuperuserOrderController extends Controller
{
    public function orderPage(){
        $orders = Order::orderBy('id', 'desc')->get();
        $order_count = Order::all()->count();
        return view('users.superuser.order.super-orders', ['orders' => $orders, 'order_count'=> $order_count]);
    }
}
