<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Banner;
 


class BannerController extends Controller
{
    public function ListBanners(){
        $banners = Banner::all()->orderBy('id', 'desc');
        return Datatables::of($banners)
                        ->addIndexColumn()
                        ->addColumn('actions', function($row){
                            return '
                            <div class="btn-group">
                            <button type="button" 
                            data-id="'.$row->id.'" 
                            data-url="'.route('superuser.super.edit.banner').'"
                            data-image="'.public_path('uploads/banners/').'/'.$row->photo.'"
                            id="editBanner" 
                            class="btn btn-outline-success">Edit</button>

                            <button type="button" 
                            data-id="'.$row->id.'" 
                            data-url="'.route('superuser.super.delete.banner').'"
                            id="deleteBanner" 
                            class="btn btn-outline-danger">Delete</button>
                        </div>
                                    ';
                        })
                        ->addColumn('status', function($row){
                            if($row->status === 'active'){
                                return ' <button type="button" 
                                data-id="'.$row->id.'" 
                                data-url="'.route('superuser.super.inactive.banner').'"
                                id="inactiveBanner" 
                                class="btn btn-outline-warning">Inactive</button>';
                            }else{
                                return '<button type="button" 
                                data-id="'.$row->id.'" 
                                data-url="'.route('superuser.super.active.banner').'"
                                id="activeBanner" 
                                class="btn btn-outline-success">Active</button>';
                            }
                                    
                        })
                        ->addColumn('condition', function($row){
                            if($row->condition === 'promo'){
                                return '   <button type="button" 
                                data-id="'.$row->id.'" 
                                data-url="'.route('superuser.super.banner.banner').'"
                                id="bannerBanner" 
                                class="btn btn-outline-info">Banner</button>';
                            }else{
                                return ' <button type="button" 
                                data-id="'.$row->id.'" 
                                data-url="'.route('superuser.super.promo.banner').'"
                                id="promoBanner" 
                                class="btn btn-outline-success">Promo</button>
                              ';
                            }
                        })
                        ->rawColumns(['actions', 'status', 'condition'])
                        ->make(true);
    }
}
