<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function ListPCategories(){
        $categories = ProductCategory::orderBy('id', 'desc')->get();
        return Datatables::of($categories)
                        ->addIndexColumn()
                        ->addColumn('actions', function($row){
                            return '
                            <div class="btn-group">
                            <a href="'.url('superuser/super-pcategory-edit', [$row->id]).'" 
                            class="btn btn-outline-success">Edit</a>
                            <button type="button" 
                            data-id="'.$row->id.'" 
                            data-url="'.route('superuser.super.delete.product.category').'"
                            id="deleteProductCategory" 
                            class="btn btn-outline-danger">Delete</button>
                        </div>
                                    ';
                        })
                        ->addColumn('isParent', function($row){
                            
                            if($row->is_parent == 1){
                                return ' <button type="button" 
                                class="btn btn-outline-success">True</button>';
                            }else{
                                return ' <button type="button" 
                                class="btn bg-olive">false</button>';
                            }
                                    
                        })
                        ->addColumn('parent_category', function($row){
                            
                            if($row->parent_id == NULL){
                                return ' <button type="button" 
                                class="btn btn-info btn-sm">Not Child</button>';
                            }else{
                                return ' <button type="button" 
                                class="btn bg-olive">'.ProductCategory::where('id', $row->parent_id)->get()->first()->title.'-'.$row->parent_id.' </button>';
                            }
                                    
                        })
                        ->addColumn('status', function($row){
                            
                            if($row->status === 'active'){
                                return ' <button type="button" 
                                data-id="'.$row->id.'" 
                                data-url="'.route('superuser.super.inactive.product.category').'"
                                id="inactivePCategory" 
                                class="btn btn-outline-warning" title="Make product.category Inactive">Inactive</button>';
                            }else{
                                return '<button type="button" 
                                data-id="'.$row->id.'" 
                                data-url="'.route('superuser.super.active.product.category').'"
                                id="activePCategory" 
                                class="btn btn-outline-success" title="Make product.category Active">Active</button>';
                            }
                                    
                        })
                       
                        ->addColumn('photoCus', function($row){
                            if($row->photo != ''){
                                return '<img class="img-circle shadow-lg" width="50" src="'.asset('uploads/products/category').'/'.$row->photo.'">';
                            }else{
                                return '<button class="btn btn-warning btn-rounded">No image</button>';
                            }
                        })
                        ->rawColumns(['actions', 'status', 'photoCus', 'isParent', 'parent_category'])
                        ->make(true);
    }


public function GenerateProductCategorySlugUrl(Request $request){
       
        if(empty($request->product_category_slug)){
            return response()->json(['code'=>0, 'error'=>'Product Category Title is required to generate slug url!']);
        }
        
        $slug = Str::slug($request->product_category_slug); //generate slug url
        $check_slug = ProductCategory::where('slug', $slug)->count();// check the database if the slug generated is existing 
        
        if($check_slug > 0){
            // if slug generated eixsts then add a random number the new slug
            $slug = $slug.'-'.rand(1111,9999);
        }
        return response()->json(['code'=>1, 'msg'=>$slug]);
}


public function addPcategory(Request $request){
    // validate all request
    $validator = Validator::make($request->all(), [
                    'product_category_title' => 'required',
                    'product_category_slug_url' => 'required',
                    'product_category_summary' => 'nullable',
                    'product_category_status' => 'nullable|in:active,inactive',
                    'is_parent' => 'nullable|in:1',
                    'parent_id' => 'nullable',
                    'product_category_file' => 'nullable|max:5080'
    ]);

    if(!$validator->passes()){
        // if validation is fail return the error message
        return response()->json(['code' => 0,  'error'=>$validator->errors()->toArray()]);
    }else{
        //process file upload
        if($request->product_category_file != ''){
            $newfilename = 'mjstore_prod_category'.rand(111,999).'.'.$request->product_category_file->extension();
            $request->product_category_file->move(public_path('uploads/products/category'), $newfilename);
        }else{
            $newfilename = null;
        }

        ProductCategory::create([
            'title' => $request->product_category_title,
            'slug' => $request->product_category_slug_url,
            'summary' => $request->product_category_summary,
            'photo' => $newfilename,
            'status' => $request->product_category_status,
            'is_parent' => $request->is_parent,
            'parent_id' => $request->parent_id
        ]);

        return response()->json(['code'=>1, 'msg'=>'Product Category Created Successfully!']);
    }

}


// make banner active
public function activePcategory(Request $request){
    $p_cate_id = $request->p_cate_id;
    ProductCategory::where('id', $p_cate_id)->update([
        'status' => 'active'
    ]);
    return 'Category has been activated!';
}
// make banner in active
public function inactivePcategory(Request $request){
    $p_cate_id = $request->p_cate_id;
    ProductCategory::where('id', $p_cate_id)->update([
        'status' => 'inactive'
    ]);
    return 'Category has been deactivated!';
}

//delete banner from database
public function deletePcategory(Request $request){
    $p_cat_id = $request->p_cat_id;
    //request to deactivate category before deleting
    if(ProductCategory::where('id', $p_cat_id)->get()->first()->status == 'active'){
        return response()->json(['code'=>0, 'error'=>'Please deactivate category before deleting!']);
    }
    //find category children if it has
    $child_cat_id = ProductCategory::where('parent_id', $p_cat_id)->pluck('id');
    // if child category exists
    if(count($child_cat_id) > 0){
        // call the shift child function from the product category model and change all child category to parent category
            ProductCategory::shiftChild($child_cat_id);
        // shift child function converts child category to parent category
        
        //get category to unlink the file if it has
        $catfile = ProductCategory::where('id', $p_cat_id)->get()->first();
         //delete category
         if($catfile->photo != ''){
            unlink(public_path('uploads/products/category').'/'.$catfile->photo);
         }

         ProductCategory::where('id', $p_cat_id)->delete();
    }
    return response()->json(['code'=>1, 'msg'=>'Category Deleted and all children set to parent!']);
}

public function EditPcategory($id){
    $p_category = ProductCategory::where('is_parent', 1)->get();
    $category = ProductCategory::where('id', $id)->get()->first();
    return view('users.superuser.product.super-productcategoryedit', ['p_category'=>$p_category, 'category'=>$category]);
}

// public function ReGenerateBannerSlugUrl(Request $request){
       
//     if(empty($request->banner_slug)){
//         return response()->json(['code'=>0, 'error'=>'Banner Title is required to generate slug url!']);
//     }
 
//     $slug = Str::slug($request->banner_slug); //generate slug url
//     $check_slug = ProductCategory::where('slug', $slug)->count();// check the database if the slug generated is existing 
    
//     if($check_slug > 0){
//         // if slug generated eixsts then add a random number the new slug
//         $slug = $slug.'-'.rand(1111,9999);
//     }
//     return response()->json(['code'=>1, 'msg'=>$slug]);
// }

public function deletePcategoryImage(Request $request){
    $cateid = $request->category_id;
    $getimage = ProductCategory::where('id', $cateid)->get()->first();
    if(unlink(public_path('uploads/products/category').'/'.$getimage->photo)){
        ProductCategory::where('id', $cateid)->update(['photo'=>Null]);
         return redirect()->back()->withErrors('Image Deleted!')->withInput();
    };
    return false;
}

// update banner

public function updatePCategory(Request $request){
    // validate all request
    $validator = Validator::make($request->all(), [
                    'edit_product_category_title' => 'required',
                    'edit_product_category_slug_url' => 'required',
                    'edit_product_category_summary' => 'required',
    ]);
    

    if(!$validator->passes()){
        // if validation is fail return the error message
        return redirect()->back()->withErrors($validator->errors())->withInput();
    }else{
        //process file upload
        $category = ProductCategory::where('id', $request->category_id)->get()->first();
        if($request->edit_product_category_file != $category->photo){
            $newfilename = 'mjstore_category'.rand(111,999).'.'.$request->edit_product_category_file->extension();
            $request->edit_product_category_file->move(public_path('uploads/products/category'), $newfilename);
        }else{
            $newfilename = $request->edit_product_category_file;
        }
       

        if($category->title != $request->edit_product_category_title){
            $category_slug_url = Str::slug($request->edit_product_category_title);
            $check_url = ProductCategory::where('slug', $category_slug_url)->count();
                if($check_url > 0){
                    $category_slug_url = $category_slug_url .'-'. rand(1111,9999);
                }
            
        }else{
            $category_slug_url = $request->edit_product_category_slug_url;
        }

        ProductCategory::where('id', $request->category_id)->update([
            'title' => $request->edit_product_category_title,
            'slug' => $category_slug_url,
            'summary' => $request->edit_product_category_summary,
            'photo' => $newfilename,
        ]);

        return redirect()->route('superuser.super.product.category.page')->with('success','Category Updated Successfully!');
    }

}
}
