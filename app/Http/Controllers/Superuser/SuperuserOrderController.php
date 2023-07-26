<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

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
        // delete order but first if user have not completed the order and the number 
        //of days ordered is not greater than one month
        //create function that checks number of days
        $orderid = $req->order_id;

        // check order status
        $getOrder = Order::where('id', $orderid)->first();
        if($getOrder->order_status == "processing"){
             //warn not to be deleted
             return response()->json(['code' => 0, 'error'=>'This order is under process and can not be deleted!']);
        }if($getOrder->order_status == "pending"){
            if($getOrder->order_status == "pending"){
                $dateOrdered = $getOrder->created_at;
                if(IsOneMonth($dateOrdered)){
                    return response()->json(['code' => 2, 'msg'=> "This order is not upto one month!"]);
                }else{
                    $order_number = $getOrder->order_number;
                    
                    $message = 'Order Number: ' . $order_number;
                    $actionLink = "";
                    $orderItems = OrderItems::with('products')->where('u_order_id', $order_number)->get();
                    $current_order =  Order::where('order_number', $order_number)->first();
                    $data = [
                            'mailFrom' =>  $getOrder->email,
                            'mailTo' =>  $getOrder->email,
                            'mailFromName' =>  $getOrder->fullname,
                            'subject' => 'Order Delete',
                            'body' => $message,
                            'actionLink' => $actionLink,
                            'orderid' => $order_number,
                            'orderItems' => $orderItems,
                            'current_order' => $current_order
                    ];
                    //send mail 
                        Mail::send('inc.order-deleted-notice-template', $data, function ($message) use ($data) {
                            $message->from($data['mailFrom'], $data['mailFromName'])
                            ->to($data['mailTo'])
                            ->cc(['gtechnoproject22@gmail.com', 'admin@gmail.com'])
                            ->subject($data['subject']);
                        //    ->replyTo('john@johndoe.com', 'John Doe')
                        //    ->attach('pathToFile');
                        });
                    $getOrder->delete();
                     return response()->json(['code' => 1, 'msg'=> "This order is greater than one month and has been deleted! Customer will be notified"]);
                }
                
            }
        }
        //check if order is less than one month
       
        //delete order
    }
}//end of class
