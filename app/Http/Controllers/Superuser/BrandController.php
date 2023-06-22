<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;


class BrandController extends Controller
{
    public function ListBrands(){
        $brands = Brand::orderBy('id', 'desc')->get();
        return Datatables::of($brands)
                        ->addIndexColumn()
                        ->addColumn('actions', function($row){
                            return '
                            <div class="btn-group">
                            <a href="'.url('superuser/super-brand-edit', [$row->id]).'" 
                            class="btn btn-outline-success">Edit</a>
                            <button type="button" 
                            data-id="'.$row->id.'" 
                            data-url="'.route('superuser.super.delete.brand').'"
                            id="deleteBrand" 
                            class="btn btn-outline-danger">Delete</button>
                        </div>
                                    ';
                        })
                        ->addColumn('status', function($row){
                            
                            if($row->status === 'active'){
                                return ' <button type="button" 
                                data-id="'.$row->id.'" 
                                data-url="'.route('superuser.super.inactive.brand').'"
                                id="deactivateBrand" 
                                class="btn btn-outline-warning" title="Make Brand Inactive">Inactive</button>';
                            }else{
                                return '<button type="button" 
                                data-id="'.$row->id.'" 
                                data-url="'.route('superuser.super.active.brand').'"
                                id="activateBrand" 
                                class="btn btn-outline-success" title="Make Brand Active">Active</button>';
                            }
                                    
                        })
                       
                        ->addColumn('photoCus', function($row){
                            return '<img class="img-fluid img-circle" src="'.asset('storage/uploads/brands').'/'.$row->photo.'">';
                        })
                        ->rawColumns(['actions', 'status','photoCus'])
                        ->make(true);
    }


public function GenerateBrandSlugUrl(Request $request){
       
        if(empty($request->brand_title)){
            return response()->json(['code'=>0, 'error'=>'Brand Title is required to generate slug url!']);
        }
        
        $slug = Str::slug($request->brand_title); //generate slug url
        $check_slug = Brand::where('slug', $slug)->count();// check the database if the slug generated is existing 
        
        if($check_slug > 0){
            // if slug generated eixsts then add a random number the new slug
            $slug = $slug.'-'.rand(1111,9999);
        }
        return response()->json(['code'=>1, 'msg'=>$slug]);
}


public function addBrand(Request $request){
    // validate all request
    $validator = Validator::make($request->all(), [
                    'brand_title' => 'required',
                    'brand_slug_url' => 'required',
                    'brand_status' => 'nullable|in:active,inactie',
                   
    ]);
    $tmp_file = TemporaryFile::where('folder', $request->brand_file)->first();
    if(!$validator->passes()){
        // if validation is fail return the error message
        if($tmp_file){
            $tmp_path = 'uploads/brand/tmp/'.$tmp_file->folder;
            Storage::deleteDirectory($tmp_path);
            $tmp_file->delete();
        }
        return response()->json(['code' => 0,  'error'=>$validator->errors()->toArray()]);
    }else{
        //process file upload
        $from = 'uploads/brands/tmp/'.$tmp_file->folder .'/'.$tmp_file->file;
        $to = 'uploads/brands/'.$tmp_file->folder.'/'.$tmp_file->file;
        Storage::copy($from, $to);
        $newfilename = $tmp_file->folder .'/'.$tmp_file->file;

        // $request->brand_file->move(public_path('uploads/brands'), $newfilename);
        
        Brand::create([
            'title' => $request->brand_title,
            'slug' => $request->brand_slug_url,
            'photo' => $newfilename,
            'status' => $request->brand_status,
        ]);
        if($tmp_file){
            $tmp_path = 'uploads/brand/tmp/'.$tmp_file->folder;
            Storage::deleteDirectory($tmp_path);
            $tmp_file->delete();
        }
        return response()->json(['code'=>1, 'msg'=>'Brand Created Successfully!']);
    }

}
public function tmpUploadBrand(Request $request){
    $file = $request->brand_file;
    if($request->hasFile('brand_file')){
        $folder = rand(1111,9999);
        $file_name = 'mjstore_brand' .$folder . '.'.$file->extension();
        $tmp_path = 'uploads/brands/tmp/';
        $file->storeAs($tmp_path.$folder, $file_name);
        TemporaryFile::create([
            'folder' => $folder,
            'file' => $file_name
        ]);
        return $folder;
    }
    return;
}
public function tmpDeleteBrand(){
    $tmp_file = TemporaryFile::where('folder', request()->getContent())->first();
    if($tmp_file){
        $tmp_path = 'uploads/brands/tmp/'.$tmp_file->folder;
        Storage::deleteDirectory($tmp_path);
        $tmp_file->delete();
        return;
    }
}
// make brand active
public function activateBrand(Request $request){
    $brand_id = $request->brand_id;
    Brand::where('id', $brand_id)->update([
        'status' => 'active'
    ]);
    return 'Brand has been activated!';
}
// make brand in active
public function deactivateBrand(Request $request){
    $brand_id = $request->brand_id;
    Brand::where('id', $brand_id)->update([
        'status' => 'inactive'
    ]);
    return 'Brand has been deactivated!';
}

//delete brand from database
public function deleteBrand(Request $request){
    $brand_id = $request->brand_id;
    $brand = Brand::where('id', $brand_id)->first();
    $folder = explode('/', $brand->photo);
    $folder = $folder[0];
    $folder_path = 'uploads/brands/'.$folder;
    if(Storage::deleteDirectory($folder)){
        Brand::where('id', $brand_id)->delete();
        return 'Brand has been deleted!';
    }
   
}

public function EditBrand($id){
    $brand = Brand::where('id', $id)->get()->first();
    return view('users.superuser.brand.super-editbrand', ['brand'=>$brand]);
}



public function deleteBrandImage(Request $request){
    $brand_id = $request->brand_id;
    $getimage = Brand::where('id', $brand_id)->get()->first();
    $folder = explode('/', $getimage->photo);
    $folder = $folder[0];
    $folder_path = 'uploads/brands/'.$folder;
    // if(Storage::deleteDirectory($folder_path)){
        if(unlink(public_path('uploads/brands'.'/'.$getimage->photo))){
            Brand::where('id', $brand_id)->update(['photo'=>Null]);
            return redirect()->back()->withErrors('Image Deleted!')->withInput();
    };
    return false;
}

// update brand

public function updateBrand(Request $request){
    // validate all request
    $validator = Validator::make($request->all(), [
                    'edit_brand_title' => 'required',
                    'edit_brand_slug_url' => 'required',
    ]);
    $tmp_file = TemporaryFile::where('folder', $request->brand_file)->first();
    if(!$validator->passes()){
        // if validation is fail return the error message
        if($tmp_file){
            $folder = 'uploads/brands/tmp/'.$tmp_file->folder;
            Storage::deleteDirectory($folder);
            $tmp_file->delete();
        }
        return redirect()->back()->withErrors($validator->errors())->withInput();
    }else{
        //process file upload
        $brand = Brand::where('id', $request->brand_id)->get()->first();
        if($tmp_file){
            $from = 'uploads/brands/tmp/'.$tmp_file->folder.'/'.$tmp_file->file;
            $to = 'uploads/brands/'.$tmp_file->folder . '/' . $tmp_file->file;
            Storage::copy($from,$to);
            $newfilename = $tmp_file->folder .'/' . $tmp_file->file;
          
        }else{
            $newfilename = $request->brand_file;
        }
       

        if($brand->title != $request->edit_brand_title){
            $brand_slug_url = Str::slug($request->edit_brand_title);
            $check_url = Brand::where('slug', $brand_slug_url)->count();
                if($check_url > 0){
                    $brand_slug_url = $brand_slug_url .'-'. rand(1111,9999);
                }
            
        }else{
            $brand_slug_url = $request->edit_brand_slug_url;
        }

        Brand::where('id', $request->brand_id)->update([
            'title' => $request->edit_brand_title,
            'slug' => $brand_slug_url,
            'photo' => $newfilename,
        ]);
        if($tmp_file){
            $folder = 'uploads/brands/tmp/'.$tmp_file->folder;
            Storage::deleteDirectory($folder);
            $tmp_file->delete();
        }

        return redirect()->route('superuser.super.brands.page')->with('success','Brand Updated Successfully!');
    }

}


}// end of class
