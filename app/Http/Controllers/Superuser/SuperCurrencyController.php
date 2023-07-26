<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class SuperCurrencyController extends Controller
{
    public function CurrencyPage(){
        return view('users.superuser.currency.super-currency');
    }

    public function listCurrency(){
        $currency = Currency::all();
        return DataTables::of($currency)
            ->addIndexColumn()
            ->addColumn("status",function($row){
                 if($row->status == 'active'){
                                return ' <button type="button" 
                                data-id="'.$row->id.'" 
                                data-url="'.route('superuser.super.update.currency.status').'"
                                id="deactivateCurrency" 
                                class="btn btn-outline-warning" title="Deactivate Currency">Deactivate</button>';
                            }else{
                                return '<button type="button" 
                                data-id="'.$row->id.'" 
                                data-url="'.route('superuser.super.update.currency.status').'"
                                id="activateCurrency" 
                                class="btn btn-outline-success" title="Activate Currency">Activate</button>';
                            };
            })
            ->addColumn("action",function($row){
                return '
                <div class="btn-group">
                <button type="button" 
                data-id="'.$row->id.'" 
                data-url="'.route('superuser.super.delete.currency').'"
                id="deleteCurrency" 
                class="btn btn-outline-danger">Delete</button>
            </div>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function updateCurrenyStatus(Request $req){
        $mode = $req->mode;
        $cur_id = $req->cur_id;
        if($mode=="activate"){
            $update = Currency::where('id', $cur_id)->update([
                'status' => 'active',
                'updated_at' => Carbon::now()
            ]);
            if(!$update){
                return response()->json(['code' => 0 , 'error' => "Something went wrong! retry"]);
            }
            return response()->json(['code' => 1 , 'msg' => "Currency status updated!"]);
        }else if($mode == "deactivate"){
            $update = Currency::where('id', $cur_id)->update([
                'status' => 'inactive',
                'updated_at' => Carbon::now()
            ]);
            if(!$update){
                return response()->json(['code' => 0 , 'error' => "Something went wrong! retry"]);
            }
            return response()->json(['code' => 1 , 'msg' => "Currency status updated!"]);
        }
    }

    public function deleteCurrency(Request $req){
        $id = $req->cur_id;
        $curr = Currency::find($id);
        if($curr){
            if($curr->status == 'active'){
                return response()->json(['code' => 0 , 'error' => "Deactivate before deleting!"]);
               }
           $curr->delete();
            return response()->json(['code' => 1 , 'msg' => "Currency deleted!"]);
        }
    }
    public function addCurrency(Request $req){
        $validator = Validator::make($req->all(), [
            'currency_name' => 'required',
            'currency_symbol' => 'required',
            'code' => 'required',
            'currency_rate' => 'required',
            'currency_status' => 'required',
            ],
            [
            'code.exists' => "Currency Already added!"
            ]
        );
            if(!$validator->passes()){
                return response()->json(['code' => 0 , 'error' => $validator->errors()->toArray()]);
            }else{
               Currency::create([
                'name' => $req->currency_name,
                'symbol' => $req->currency_symbol,
                'exchange_rate' => $req->currency_rate,
                'code' => $req->code,
                'status' => $req->currency_status,
               ]); 
            
            return response()->json(['code' => 1 , 'msg' => "Currency added!"]);

            
        }
    }



    public function LoadCurrency(Request $req){
        session()->put('currency_code', $req->code);
        $currency = Currency::where('code', $req->code)->first();
        session()->put('currency_symbol', $currency->symbol);
        session()->put('currency_exchange_rate', $currency->exchange_rate);
        return response()->json(['code'=>1]);
    }
}