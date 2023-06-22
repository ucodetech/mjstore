<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipping;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ShippingMethodController extends Controller
{
    public function ShippingMethod(){
        return view('users.superuser.shippingmethod.super-shippingmethod');
    }
    
    public function storeShippingMethod(Request $request){
            $validator = Validator::make($request->all(),[
                'shipping_delivery_charge' => 'required|numeric',
                'shipping_delivery_time' => 'required',
                'shipping_method' => 'required|unique:shippings,shipping_method',
                'shipping_method_status' => 'required',
                
            ]);
        
            if(!$validator->passes()){
                return response()->json(['code'=>0, 'error'=>$validator->errors()->toArray()]);
            }else{
                Shipping::create([
                    'shipping_method' => $request->shipping_method,
                    'delivery_charge' => $request->shipping_delivery_charge,
                    'delivery_time' => $request->shipping_delivery_time,
                    'delivery_description' => $request->delivery_description,
                    'status' => $request->shipping_method_status
                ]);
                return response()->json(['code'=>1, 'msg'=>'Shipping Method Created!']);
            }

    }

    public function listShippingMethod(){
        $shippings = Shipping::all();
        return DataTables::of($shippings)
                            ->addIndexColumn()
                            ->addColumn('status', function($row){
                                if($row->status === 'active'){
                                    return ' <button type="button" 
                                    data-id="'.$row->id.'" 
                                    data-url="'.route('superuser.super.toggle.status.shipping.method').'"
                                    id="deactivateMethod" 
                                    class="btn btn-outline-warning" title="Deactivate Method">Deactivate</button>';
                                }else{
                                    return '<button type="button" 
                                    data-id="'.$row->id.'" 
                                    data-url="'.route('superuser.super.toggle.status.shipping.method').'"
                                    id="activateMethod" 
                                    class="btn btn-outline-success" title="Activate Method">Active</button>';
                                }
                                        
                            })
                            ->addColumn('actions', function($row){
                                return '
                                <div class="btn-group">
                                <button type="button"
                                data-id="'.$row->id.'"
                                data-url="" 
                                class="btn btn-outline-success">Edit</button>
                                <button type="button" 
                                data-id="'.$row->id.'" 
                                data-url="'.route('superuser.super.delete.banner').'"
                                id="deleteBanner" 
                                class="btn btn-outline-danger">Delete</button>
                            </div>';
                            })
                            ->rawColumns(['actions', 'status'])
                            ->make(true);
    
     }





public function shippingMethodStatus(Request $request){

    if($request->mode == 'deactivate'){
        Shipping::where('id', $request->coupon_id)
        ->update([
            'status'=>'inactive',
            'updated_at' => Carbon::now()
            ]);
            
    }elseif($request->mode == 'activate'){
        Shipping::where('id', $request->coupon_id)
        ->update([
            'status'=>'active',
            'updated_at' => Carbon::now()
        ]);
        
    }
        return 'Status Updated!';
    
}







}//
