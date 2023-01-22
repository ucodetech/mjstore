<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Banner;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
 


class BannerController extends Controller
{
    public function ListBanners(){
        $banners = Banner::orderBy('id', 'desc')->get();
        return Datatables::of($banners)
                        ->addIndexColumn()
                        ->addColumn('actions', function($row){
                            return '
                            <div class="btn-group">
                            <a href="'.url('superuser/super-banner-edit', [$row->id]).'" 
                            class="btn btn-outline-success">Edit</a>
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
                                class="btn btn-outline-warning" title="Make Banner Inactive">Inactive</button>';
                            }else{
                                return '<button type="button" 
                                data-id="'.$row->id.'" 
                                data-url="'.route('superuser.super.active.banner').'"
                                id="activeBanner" 
                                class="btn btn-outline-success" title="Make Banner Active">Active</button>';
                            }
                                    
                        })
                        ->addColumn('condition', function($row){
                            if($row->condition === 'promo'){
                                return '   <button type="button" 
                                data-id="'.$row->id.'" 
                                data-url="'.route('superuser.super.banner.banner').'"
                                id="bannerBanner" 
                                class="btn btn-outline-info" title="Change banner to Banner">Banner</button>';
                            }else{
                                return ' <button type="button" 
                                data-id="'.$row->id.'" 
                                data-url="'.route('superuser.super.promo.banner').'"
                                id="promoBanner" 
                                class="btn btn-outline-success" title="Change banner to promotion">Promo</button>
                              ';
                            }
                        })
                        ->addColumn('photoCus', function($row){
                            return '<img class="img-fluid img-circle" src="'.asset('uploads/banners').'/'.$row->photo.'">';
                        })
                        ->rawColumns(['actions', 'status', 'condition', 'photoCus'])
                        ->make(true);
    }


public function GenerateBannerSlugUrl(Request $request){
       
        if(empty($request->banner_slug)){
            return response()->json(['code'=>0, 'error'=>'Banner Title is required to generate slug url!']);
        }
        // // trim white and change it to - 
        // $slug_url = preg_replace('/[^a-z0-9]+/i', '-', strtolower(trim($request->banner_slug)));
        // // check database if the url exists already
        // $check = Banner::select('slug')->where('slug', 'LIKE', '%'.$slug_url.'%')->get();
        // //loop through the result 
        // foreach ($check as $slug) {
        //     $data[] = $slug->slug;
        //     if(in_array($slug_url, $data)){
        //         $count = 0;
        //         while (in_array(($slug_url.'-'.$count+1), $data)) {
        //             $slug_url = $slug_url .'-'. $count;
        //         }
        //     }
        // }
        $slug = Str::slug($request->banner_slug); //generate slug url
        $check_slug = Banner::where('slug', $slug)->count();// check the database if the slug generated is existing 
        
        if($check_slug > 0){
            // if slug generated eixsts then add a random number the new slug
            $slug = $slug.'-'.rand(1111,9999);
        }
        return response()->json(['code'=>1, 'msg'=>$slug]);
}


public function addBanner(Request $request){
    // validate all request
    $validator = Validator::make($request->all(), [
                    'banner_title' => 'required',
                    'banner_slug_url' => 'required',
                    'banner_description' => 'required',
                    'banner_status' => 'required',
                    'banner_condition' => 'required',
                    'banner_file' => 'required|max:5080'
    ]);

    if(!$validator->passes()){
        // if validation is fail return the error message
        return response()->json(['code' => 0,  'error'=>$validator->errors()->toArray()]);
    }else{
        //process file upload
        $newfilename = 'mjstore_banner'.rand(111,999).'.'.$request->banner_file->extension();
        $request->banner_file->move(public_path('uploads/banners'), $newfilename);

        Banner::create([
            'title' => $request->banner_title,
            'slug' => $request->banner_slug_url,
            'description' => $request->banner_description,
            'photo' => $newfilename,
            'status' => $request->banner_status,
            'condition' => $request->banner_condition
        ]);

        return response()->json(['code'=>1, 'msg'=>'Banner Uploaded Successfully!']);
    }

}


// make banner active
public function activeBanner(Request $request){
    $banner_id = $request->banner_id;
    Banner::where('id', $banner_id)->update([
        'status' => 'active'
    ]);
    return 'Banner has been activated!';
}
// make banner in active
public function inactiveBanner(Request $request){
    $banner_id = $request->banner_id;
    Banner::where('id', $banner_id)->update([
        'status' => 'inactive'
    ]);
    return 'Banner has been deactivated!';
}
// set banner to a promo banner 
public function promoBanner(Request $request){
    $banner_id = $request->banner_id;
    Banner::where('id', $banner_id)->update([
        'condition' => 'promo'
    ]);
    return 'Banner has been set to promotion banner!';
}
// set banner to ordinary banner 
public function bannerBanner(Request $request){
    $banner_id = $request->banner_id;
    Banner::where('id', $banner_id)->update([
        'condition' => 'banner'
    ]);
    return 'Banner has been set to ordinary banner!';
}
//delete banner from database
public function deleteBanner(Request $request){
    $banner_id = $request->banner_id;
    Banner::where('id', $banner_id)->delete();
    return 'Banner has been deleted!';
}

public function EditBanner($id){
    $banner = Banner::where('id', $id)->get()->first();
    return view('users.superuser.banner.super-editbanner', ['banner'=>$banner]);
}

// public function ReGenerateBannerSlugUrl(Request $request){
       
//     if(empty($request->banner_slug)){
//         return response()->json(['code'=>0, 'error'=>'Banner Title is required to generate slug url!']);
//     }
 
//     $slug = Str::slug($request->banner_slug); //generate slug url
//     $check_slug = Banner::where('slug', $slug)->count();// check the database if the slug generated is existing 
    
//     if($check_slug > 0){
//         // if slug generated eixsts then add a random number the new slug
//         $slug = $slug.'-'.rand(1111,9999);
//     }
//     return response()->json(['code'=>1, 'msg'=>$slug]);
// }

public function deleteBannerImage(Request $request){
    $bannerid = $request->banner_id;
    $getimage = Banner::where('id', $bannerid)->get()->first();
    if(unlink(public_path('uploads/banners').'/'.$getimage->photo)){
        Banner::where('id', $bannerid)->update(['photo'=>Null]);
         return redirect()->back()->withErrors('Image Deleted!')->withInput();
    };
    return false;
}

// update banner

public function updateBanner(Request $request){
    // validate all request
    $validator = Validator::make($request->all(), [
                    'edit_banner_title' => 'required',
                    'edit_banner_slug_url' => 'required',
                    'edit_banner_description' => 'required',
                    'banner_file' => 'required|max:5080'
    ]);

    if(!$validator->passes()){
        // if validation is fail return the error message
        return redirect()->back()->withErrors($validator->errors())->withInput();
    }else{
        //process file upload
        $banner = Banner::where('id', $request->banner_id)->get()->first();
        if($request->banner_file != $banner->photo){
            $newfilename = 'mjstore_banner'.rand(111,999).'.'.$request->banner_file->extension();
            $request->banner_file->move(public_path('uploads/banners'), $newfilename);
        }else{
            $newfilename = $request->banner_file;
        }
       

        if($banner->title != $request->edit_banner_title){
            $banner_slug_url = Str::slug($request->edit_banner_title);
            $check_url = Banner::where('slug', $banner_slug_url)->count();
                if($check_url > 0){
                    $banner_slug_url = $banner_slug_url .'-'. rand(1111,9999);
                }
            
        }else{
            $banner_slug_url = $request->edit_banner_slug_url;
        }

        Banner::where('id', $request->banner_id)->update([
            'title' => $request->edit_banner_title,
            'slug' => $banner_slug_url,
            'description' => $request->edit_banner_description,
            'photo' => $newfilename,
        ]);

        return redirect()->route('superuser.super.banner.page')->with('success','Banner Updated Successfully!');
    }

}


}//end of class
