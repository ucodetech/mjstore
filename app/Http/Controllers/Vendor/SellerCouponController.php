<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class SellerCouponController extends Controller
{
    public function showCouponPage(){
        return view('users.seller.pages.coupon.seller-coupon');
    }

    public function ListCoupon(){
        $coupons = Coupon::where('vendor_id', seller()->id)->orderBy('id', 'desc')->get();
        return DataTables::of($coupons)
                            ->addIndexColumn()
                            ->addColumn('codeCus', function($row){
                                return '<span class="badge bagde-pill badge-info">'.$row->coupon_code.'</span>';
                            })
                            ->addColumn('typeCus', function($row){
                                if($row->type === 'fixed'){
                                    return ' <button type="button" 
                                    data-id="'.$row->id.'" 
                                    data-url="'.route('seller.vendor.toggle.type.coupon').'"
                                    id="percentCoupon" 
                                    class="btn btn-outline-warning" title="Make Coupon Percent">Percent</button>';
                                }else{
                                    return '<button type="button" 
                                    data-id="'.$row->id.'" 
                                    data-url="'.route('seller.vendor.toggle.type.coupon').'"
                                    id="fixedCoupon" 
                                    class="btn btn-outline-success" title="Make Coupon Fixed">Fixed</button>';
                                }
                            })
                            ->addColumn('actions', function($row){
                                return '
                                <div class="btn-group">
                                    <button type="button" 
                                    data-id="'.$row->id.'" 
                                    data-url="'.route('seller.vendor.delete.coupon').'"
                                    id="deleteCoupon" 
                                    class="btn btn-outline-danger">Delete</button>
                                </div>
                                        ';
                            })
                            ->addColumn('status', function($row){
                                if($row->status === 'active'){
                                    return ' <button type="button" 
                                    data-id="'.$row->id.'" 
                                    data-url="'.route('seller.vendor.toggle.status.coupon').'"
                                    id="deactivateCoupon" 
                                    class="btn btn-outline-warning" title="Make Coupon Inactive">Deactivate</button>';
                                }else{
                                    return '<button type="button" 
                                    data-id="'.$row->id.'" 
                                    data-url="'.route('seller.vendor.toggle.status.coupon').'"
                                    id="activateCoupon" 
                                    class="btn btn-outline-success" title="Make Coupon Active">Activate</button>';
                                }
                            })
                            ->addColumn('created_at', function($row){
                                return pretty_dates($row->created_at);
                            })
                            ->addColumn('updated_at', function($row){
                                return pretty_dates($row->updated_at);
                            })
                            ->rawColumns(['codeCus', 'typeCus', 'status', 'actions', 'updated_at', 'created_at'])
                            ->make(true);
    }





public function addCoupon(Request $request){
        $validator = Validator::make($request->all(),[
                    'code' => 'required|min:10|max:10',
                    'type' => 'required',
                    'status' => 'required',
                    'coupon_value' => 'required'
        ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0, 'error'=>$validator->errors()->toArray()]);
        }else{
            Coupon::create([
                'coupon_code' => $request->code,
                'type' => $request->type,
                'status' => $request->status,
                'value' => $request->coupon_value,
                'created_at' => Carbon::now(),
                'vendor_id' => seller()->id
            ]);
            return response()->json(['code'=>1, 'msg'=>'Coupon Code Created Successfully!']);
        }
}



public function GenerateCouponCode(Request $request){
   
    $code = Str::random(10); //generate code
    $check = Coupon::where('coupon_code', $code)->count();// check the database if the slug generated is existing 
    if($check > 0){
        // if slug generated eixsts then add a random number the new slug
        return response()->json(['code'=>0, 'error'=>$code . 'Already exist in the database']);
    }
    return response()->json(['code'=>1, 'msg'=>$code]);
}


public function couponStatus(Request $request){
        
    if($request->mode == 'deactivate'){
        Coupon::where('id', $request->coupon_id)
        ->update([
            'status'=>'inactive',
            'updated_at' => Carbon::now()
            ]);
            
    }elseif($request->mode == 'activate'){
        Coupon::where('id', $request->coupon_id)
        ->update([
            'status'=>'active',
            'updated_at' => Carbon::now()
        ]);
        
    }
     return 'Status Updated!';
    
}


public function couponType(Request $request){
        
    if($request->mode == 'percent'){
        Coupon::where('id', $request->coupon_id)
        ->update([
            'type'=>'percent',
            'updated_at' => Carbon::now()
            ]);
            
    }elseif($request->mode == 'fixed'){
        Coupon::where('id', $request->coupon_id)
        ->update([
            'type'=>'fixed',
            'updated_at' => Carbon::now()
        ]);
        
    }
     return 'Type Updated!';
    
}


public function deleteCoupon(Request $request){
        if(Coupon::where('id', $request->coupon_id)->first()->status == 'active'){
            return response()->json(['code'=>0, 'error'=>'Please deactivate coupon before deleting it!']);
        }
        Coupon::where('id', $request->coupon_id)
        ->delete();
            
        return 'Coupon Deleted Successfully!';
    
}




}
