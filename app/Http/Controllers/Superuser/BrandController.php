<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;


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
                            return '<img class="img-fluid img-circle" src="'.asset('uploads/brands').'/'.$row->photo.'">';
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
                    'brand_file' => 'nullable|max:5080'
    ]);

    if(!$validator->passes()){
        // if validation is fail return the error message
        return response()->json(['code' => 0,  'error'=>$validator->errors()->toArray()]);
    }else{
        //process file upload
        $newfilename = 'mjstore_brand'.rand(111,999).'.'.$request->brand_file->extension();
        $request->brand_file->move(public_path('uploads/brands'), $newfilename);

        Brand::create([
            'title' => $request->brand_title,
            'slug' => $request->brand_slug_url,
            'photo' => $newfilename,
            'status' => $request->brand_status,
        ]);

        return response()->json(['code'=>1, 'msg'=>'Brand Created Successfully!']);
    }

}


// make banner active
public function activateBrand(Request $request){
    $brand_id = $request->brand_id;
    Brand::where('id', $brand_id)->update([
        'status' => 'active'
    ]);
    return 'Brand has been activated!';
}
// make banner in active
public function deactivateBrand(Request $request){
    $brand_id = $request->brand_id;
    Brand::where('id', $brand_id)->update([
        'status' => 'inactive'
    ]);
    return 'Brand has been deactivated!';
}

//delete banner from database
public function deleteBrand(Request $request){
    $brand_id = $request->brand_id;
    Brand::where('id', $brand_id)->delete();
    return 'Brand has been deleted!';
}

public function EditBrand($id){
    $brand = Brand::where('id', $id)->get()->first();
    return view('users.superuser.brand.super-editbrand', ['brand'=>$brand]);
}



public function deleteBrandImage(Request $request){
    $brand_id = $request->brand_id;
    $getimage = Brand::where('id', $brand_id)->get()->first();
    if(unlink(public_path('uploads/brands').'/'.$getimage->photo)){
        Brand::where('id', $brand_id)->update(['photo'=>Null]);
         return redirect()->back()->withErrors('Image Deleted!')->withInput();
    };
    return false;
}

// update banner

public function updateBrand(Request $request){
    // validate all request
    $validator = Validator::make($request->all(), [
                    'edit_brand_title' => 'required',
                    'edit_brand_slug_url' => 'required',
                    'edit_brand_file' => 'nullable|max:5080'
    ]);

    if(!$validator->passes()){
        // if validation is fail return the error message
        return redirect()->back()->withErrors($validator->errors())->withInput();
    }else{
        //process file upload
        $brand = Brand::where('id', $request->brand_id)->get()->first();
        if($request->brand_file != $brand->photo){
            $newfilename = 'mjstore_brand'.rand(111,999).'.'.$request->edit_brand_file->extension();
            $request->edit_brand_file->move(public_path('uploads/brands'), $newfilename);
        }else{
            $newfilename = $request->edit_brand_file;
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

        return redirect()->route('superuser.super.brands.page')->with('success','Brand Updated Successfully!');
    }

}


}// end of class
