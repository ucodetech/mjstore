<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Banner;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
 


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
                            return '<img class="img-rounded" width="80" src="'.asset('storage/uploads/banners').'/'.$row->photo.'">';
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
                    'price_description' => 'nullable',
                    'link' => 'nullable',
                    'link_descriptions' => 'nullable'
    ]);
    $tmp_file = TemporaryFile::where('folder', $request->banner_file)->get()->first();

    if(!$validator->passes()){
        // if validation is fail return the error message
        if($tmp_file){
            Storage::deleteDirectory('uploads/banners/tmp/'.$tmp_file->folder);
            $tmp_file->delete();
        }
        return response()->json(['code' => 0,  'error'=>$validator->errors()->toArray()]);
    }else{
        //process file upload
        if($tmp_file){
            $from = 'uploads/banners/tmp/'.$tmp_file->folder .'/'. $tmp_file->file;
            $to = 'uploads/banners/'.$tmp_file->folder. '/'. $tmp_file->file;
            Storage::copy($from, $to);
        
        Banner::create([
            'title' => $request->banner_title,
            'slug' => $request->banner_slug_url,
            'description' => $request->banner_description,
            'price_description' => $request->price_description,
            'link' => $request->link,
            'link_descriptions' => $request->link_descriptions,
            'photo' => $tmp_file->folder.'/'.$tmp_file->file,
            'status' => $request->banner_status,
            'condition' => $request->banner_condition
        ]);
            if($tmp_file){
                Storage::deleteDirectory('uploads/banners/tmp/'.$tmp_file->folder);
                $tmp_file->delete();
                }
        return response()->json(['code'=>1, 'msg'=>'Banner Uploaded Successfully!']);
        }
    }

}

public function tmpUploadBanner(Request $request){
    $file = $request->banner_file;
    if($request->hasFile('banner_file')){
        $folder = rand(1111,9999);
        $file_name = 'mjstore_banner'.$folder.'.'.$file->extension();
        $file->storeAs('uploads/banners/tmp/'.$folder, $file_name);
        TemporaryFile::create([
            'folder' => $folder,
            'file' => $file_name
        ]);
        return $folder;
     }
        return '';
    
}

public function tmpDeleteBanner(){
    $tmp_file = TemporaryFile::where('folder', request()->getContent())->first();
    if($tmp_file){
        Storage::deleteDirectory('uploads/banners/tmp/'.$tmp_file->folder);
        $tmp_file->delete();
        return;
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
    $banner = Banner::where('id', $banner_id)->get()->first();
    if($banner->status == 'active'){
        return response()->json(['code'=>0, 'error'=>'Please deactivate banner before deleting']);
    }else{
            $getfolder = explode('/', $banner->photo);
            $folder = 'uploads/banners/'.$getfolder[0];
            if(Storage::deleteDirectory($folder)){
            Banner::where('id', $banner_id)->delete();
            return response()->json(['code'=>1, 'msg'=>'Banner Deleted Successfully']);
        }
    }
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
        $getfolder = explode('/', $getimage->photo);
        $folder = 'uploads/banners/'.$getfolder[0];
        if(Storage::deleteDirectory($folder)){
         Banner::where('id', $bannerid)->update(['photo'=>Null]);
         return redirect()->back()->withErrors('Image Deleted!')->withInput();
    };
    return false;
}

// update bannerato,

public function updateBanner(Request $request){
    // validate all request
    $validator = Validator::make($request->all(), [
                    'edit_banner_title' => 'required',
                    'edit_banner_slug_url' => 'required',
                    'edit_banner_description' => 'required',
                    'edit_price_description' => 'nullable',
                    'edit_link' => 'nullable',
                    'edit_link_descriptions' => 'nullable'
    ]);

    $tmp_file = TemporaryFile::where('folder', $request->banner_file)->first();
    if(!$validator->passes()){
        // if validation is fail return the error message
        if($tmp_file){
            Storage::deleteDirectory('uploads/banners/tmp/'.$tmp_file->folder);
            $tmp_file->delete();
        }
        return redirect()->back()->withErrors($validator->errors())->withInput();
    }else{
        //process file upload
        $banner = Banner::where('id', $request->banner_id)->get()->first();
        if($tmp_file){
            $from = 'uploads/banners/tmp/'.$tmp_file->folder .'/'. $tmp_file->file;
            $to = 'uploads/banners/'.$tmp_file->folder. '/'. $tmp_file->file;
            Storage::copy($from, $to);
            $newfilename = $tmp_file->folder.'/'.$tmp_file->file;
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
            'price_description' => $request->edit_price_description,
            'link' => $request->edit_link,
            'link_descriptions' => $request->edit_link_descriptions
        ]);
        if($tmp_file){
            Storage::deleteDirectory('uploads/banners/tmp/'.$tmp_file->folder);
            $tmp_file->delete();
        }
        return redirect()->route('superuser.super.banner.page')->with('success','Banner Updated Successfully!');
    }

}


}//end of class
