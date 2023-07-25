<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SuperuserOrderController extends Controller
{
    public function orderPage()
    {
        $orders = Order::orderBy('id', 'desc')->get();
        $order_count = Order::all()->count();
        return view('users.superuser.order.super-orders', ['orders' => $orders, 'order_count' => $order_count]);
    }


    public function orderItems($OrderId)
    {
        $orderid = $OrderId;
        $output = '';
        $orderitems = OrderItems::where('u_order_id', $orderid)->get();

        $item = Order::OrderSelf($orderid);


        return view(
            'users.superuser.order.super-orderDetails',
            ['orderitems' => $orderitems, 'item' => $item, 'orderid' => $orderid]
        );
    }


    public function updateOrderStatus(Request $req)
    {
        $orderId = $req->orderId;
        $status = $req->status;

        Order::where('order_number', $orderId)->update([
            'order_status' => $status,
            'updated_at' => Carbon::now()

        ]);
        $msg = "Order Status updated to " . $status;

        return response()->json(['msg' => $msg]);
    }


    public function getOrderStatus(Request $req)
    {
        $orderid = $req->orderId;
        $order = Order::OrderSelf($orderid);
        $status =  $order->order_status;
        switch ($status) {
            case 'pending':
                $color = 'text-warning';
                break;
            case 'processing':
                $color = 'text-info';
                break;
            case 'delivered':
                $color = 'text-success';
                break;
            case 'canceled':
                $color = 'text-danger';
                break;
            
            default:
                $color = 'text-warning';
                break;
        } 
        return '<span class="'.$color.'"> '.ucfirst($status).'</span>';
    }

    public function deleteOrder(Request $req){
        // delete order but first if user have completed the order and the number of days order have stated
        //create function that checks number of days
        $orderid = $req->order_id;
    }
}//end of class
