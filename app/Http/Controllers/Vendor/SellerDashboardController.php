<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\LocalGov;
use Illuminate\Http\Request;
use App\Models\SellerBusinessInformation;
use App\Models\State;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductCategory;

class SellerDashboardController extends Controller
{
    public function sellerDashboard(){
        $bizinfo = SellerBusinessInformation::where(['seller_id'=>seller()->id, 'approved'=>0])->first();
       
        return view('users.seller.pages.seller-dashboard', ['bizinfo'=>$bizinfo]);
    }

    public function showProductCategoryPage(){
        $product_category = ProductCategory::where(['status'=>'active', 'vendor_id'=>seller()->id])->orderBy('parent_id', 'desc')->get();
        return view('users.seller.pages.product.seller-productcategory', ['product_category'=> $product_category]);
    }



    public function brandPage(){
        $categories = ProductCategory::orderBy('title', 'asc')->get();
        return view('users.seller.pages.brand.seller-brand', ['categories'=>$categories]);
    }

    public function bizInfo(){
        $states = State::orderBy('name', 'asc')->get();
        return view('users.seller.pages.seller-businessInfo', ['states'=>$states]);
    }

        //get cities of pre selected state on edit of address
    public function getStateCityBiz(Request $request){
        $state = $request->state_name;
        $selected = $request->selected;
        $state_id  =  State::where('name', $state)->first()->state_id;
        $cities =  LocalGov::where('state_id', $state_id)->get();
        $output = '';

        $output .= '<option value="">--Select City--</option>';
        foreach($cities as $city){
            $output.='<option value="'.$city->local_name.'" '.(($request->selected == $city->local_name)?' selected':'').'>'.$city->local_name.'</option>';
        }

        return $output;
    }

    public function processBizInfo(Request $request){
        $validator = Validator::make($request->all(), [
                            'shop_address' => 'required',
                            'shop_city' => 'required',
                            'shop_state' => 'required',
                            'shop_logo' => 'required|mimes:png,jpeg,jpg',
                            'bank_name' => 'required',
                            'account_name' => 'required',
                            'account_number' => 'required|min:10|max:10|unique:seller_business_information,account_number',
                            'registered_biz_name' => 'sometimes|required|unique:seller_business_information,registered_biz_name',
                            'cac_registration_no' => 'sometimes|required|unique:seller_business_information,cac_registration_no',
                            'cac_certificate' => 'sometimes|required',
                            'customer_support_email' => 'required|email|unique:seller_business_information,customer_support_email',
                            'customer_support_phone_no' => 'required|unique:seller_business_information,customer_support_phone_no',
                            'customer_support_whatsapp' => 'required|unique:seller_business_information,customer_support_whatsapp',
        ]);
        if(!$validator->passes()){
            return response()->json(['code'=>0, 'error'=>$validator->errors()->toArray()]);
        }else{
            
           
                $registered_biz_name = seller()->business_options == 1 ? $request->registered_biz_name : Null;
                $cac_registration_no = seller()->business_options == 1 ? $request->cac_registration_no : Null;

                if($request->hasFile('cac_certificate')){
                    $file = $request->file('cac_certificate');
                    $newfilecacname = 'cac' .rand(111,999). '.' . $file->extension();
                    $path = 'uploads/bizinfo/'.seller()->unique_key;
                    $file->storeAs($path, $newfilecacname);
                }else{
                    $newfilecacname = Null;
                }
                if($request->hasFile('shop_logo')){
                    $file_logo = $request->file('shop_logo');
                    $newfilelogoname = 'logo' . rand(1111,9999) .'.' . $file_logo->extension(); 
                    $path = 'uploads/bizinfo/'.seller()->unique_key;
                    $file_logo->storeAs($path, $newfilelogoname);
                }

                SellerBusinessInformation::create([
                    'seller_id'   => seller()->id,
                    'shop_address'   => $request->shop_address,
                    'shop_city'   => $request->shop_city,
                    'shop_state'   => $request->shop_state,
                    'shop_logo'   =>  $newfilelogoname,
                    'bank_name'   => $request->bank_name,
                    'account_name'   => $request->account_name,
                    'account_number'   => $request->account_number,
                    'registered_biz_name'   => $registered_biz_name,
                    'cac_registration_no'   =>$cac_registration_no,
                    'cac_certificate'   =>  $newfilecacname,
                    'customer_support_email'   =>$request->customer_support_email,
                    'customer_support_phone_no'   =>$request->customer_support_phone_no,
                    'customer_support_whatsapp'   =>$request->customer_support_whatsapp,
                ]);

                return response()->json(['code' => 1, 'msg'=> "Your application have been submitted successfully and is under review! please  check your mail box within 2 - 3 working days for approval email"]);
        }
    }
}
