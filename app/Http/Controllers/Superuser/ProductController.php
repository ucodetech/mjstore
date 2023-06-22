<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\ProductCategory;
use App\Models\Brand;
use App\Models\User;
use Yajra\DataTables\DataTables;
use App\Models\Color;
use App\Models\Size;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Condition;
use Illuminate\Support\Facades\DB;

 


class ProductController extends Controller
{
    public function productPage(){
        $products = Product::where('home_shop', 1)->get();
        $product_count = Product::where('home_shop', 1)->count();
        $conditions = Condition::all();
        return view('users.superuser.product.products.super-products', ['products'=>$products, 'product_count'=>$product_count, 'conditions'=> $conditions]);
    }
    public function productAddPage(){
        $active = 'active';
        $product_count = Product::where('home_shop', 1)->count();
        $brands = Brand::where('status',$active)->get();
        $categories = ProductCategory::where('is_parent', 1)->where('status',$active)->get();
        $colors = Color::all();
        $sizes = Size::all();
        $conditions = Condition::all();
        return view('users.superuser.product.products.super-createproduct', 
        ['product_count'=>$product_count, 
        'brands'=>$brands, 
        'categories'=>$categories, 
        'colors'=> $colors, 
        'sizes'=>$sizes,
        'conditions'=>$conditions]);
    }

    public function processProductCreate(Request $request){
       
        $validator = Validator::make($request->all(), [
            'product_title' => 'required|min:3|max:100',
            'product_stock' => 'required',
            'product_weights' => 'nullable|numeric',
            'product_price' => 'required',
            'product_discount' => 'nullable|numeric',
            'product_brand' => 'required',
            'product_category' => 'required|exists:product_categories,id',
            'product_child_category' => 'nullable|exists:product_categories,id',
            'product_condition' => 'nullable|in:new,popular,onsale,featured',
            'product_status' => 'nullable',
            'product_color' => 'nullable',
            'product_size' => 'nullable',
            'product_summary' => 'nullable',
            'product_description' => 'nullable',
            
        ]);
        $tmp_file = TemporaryFile::where('folder', $request->product_file)->first();
        if(!$validator->passes()){
            if($tmp_file){
                Storage::deleteDirectory('uploads/products/tmp/'.$tmp_file->folder);
                $tmp_file->delete();
            }
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            if($tmp_file){
                // $file = $request->product_file;
                // $newfilename = 'mjstore_product'.rand(1111,9999).'.'.$file->extension();
                // $folder = rand(1111,9999);
                // $file->storeAs('uploads/products', $newfilename);
            
                Storage::copy('uploads/products/tmp/'.$tmp_file->folder.'/'.$tmp_file->file, 'uploads/products/'.$tmp_file->folder.'/'.$tmp_file->file);

                $slug_url = Str::slug($request->product_title);
                $check_slug = Product::where('slug', $slug_url)->count();
                if($check_slug > 0){
                    $slug_url = $slug_url . '-' . rand(1111,9999);
                }
                //caculate discount
                //sales_price = (price-((price*discount)/100)) // not working well
                $sales_price = $request->product_price - $request->product_discount;


                //collect color and size array
                if($request->product_size){
                    $size = implode(',',$request->product_size);
                }else{
                    $size = '';
                }
                if($request->product_color){
                    $color = implode(',',$request->product_color);
                }else{
                    $color = '';
                }   
               
                Product::create([
                    'photo' => $tmp_file->folder .'/'.$tmp_file->file,
                    'title' => $request->product_title,
                    'slug' => $slug_url,
                    'summary' => $request->product_summary,
                    'description' => $request->product_description,
                    'stock' => $request->product_stock,
                    'brand_id' => $request->product_brand,
                    'cat_id' => $request->product_category,
                    'child_cat_id' => $request->product_child_category,
                    'price' => $request->product_price,
                    'product_discount' => $request->product_discount,
                    'sales_price' => $sales_price,
                    'weights' => $request->product_weights,
                    'size' => $size,
                    'condition' => $request->product_condition,
                    // 'vendor_id' => null,
                    'status' => $request->product_status,
                    'color' => $color,
                    'unique_key' => rand(111111,999999),
                    'home_shop' => 1
                ]);
                Storage::deleteDirectory('uploads/products/tmp/'.$tmp_file->folder);
                $tmp_file->delete();

                return redirect()->route('superuser.super.products.page')->with('success','Product added successfully!')->withInput();
            }
            
        }
      
        
        
    }

    // processProductCreateMoreImages
    public function processProductCreateMoreImages(Request $request){
            $tmp_file = TemporaryFile::where('folder', $request->product_file)->first();
            if($tmp_file){
                $from = 'uploads/products/tmp/'.$tmp_file->folder .'/'.$tmp_file->file;
                $to = 'uploads/products/'.$tmp_file->folder .'/'.$tmp_file->file;
                Storage::copy($from, $to);
                $filename = $tmp_file->folder .'/'.$tmp_file->file;
                Product::where('id', $request->product_id_use)->update([
                    'photo' => DB::raw("CONCAT(photo, '" . ','. $filename . "')"),
                    // 'photo' => Str::concat($filename)
                ]);
                Storage::deleteDirectory('uploads/products/tmp/'.$tmp_file->folder);
                $tmp_file->delete();
            }
            return redirect()->route('superuser.super.products.page')->with('success','Product image added successfully!')->withInput();
        
    }
    // 6975/mjstore_product9175.png

    //temp upload file 
    public function tmpUploadProduct(Request $request){
        if($request->hasFile('product_file')){
            $file = $request->product_file;
            $newname = 'mjstore_product' .rand(1111,9999).'.' .$request->product_file->extension();
            $folder = rand(1111,9999);
            $file->storeAs('uploads/products/tmp/'.$folder, $newname);
            // change this to storage path its working
            TemporaryFile::create([
                'folder' => $folder,
                'file' => $newname
            ]);
            return $folder;
        }
        return ''; 
    }     
    //temp revert upload
    public function tmpDeleteProduct(){
        $tmp_file = TemporaryFile::where('folder', request()->getContent())->first();
        if($tmp_file){
            Storage::deleteDirectory('uploads/products/tmp/'.$tmp_file->folder);
            $tmp_file->delete();
            return;
        }
    }



    public function productStatus(Request $request){
        
        if($request->mode == 'deactivate'){
            Product::where('id', $request->product_id)
            ->update([
                'status'=>'inactive'
                ]);
                
        }elseif($request->mode == 'activate'){
            Product::where('id', $request->product_id)
            ->update([
                'status'=>'active'
            ]);
            
        }
        return redirect()->back()->with('info', 'Status Updated Successfully!');
        
    }

    public function productFeatured(Request $request){
        
        if($request->mode == 0){
            Product::where('id', $request->product_id)
            ->update([
                'featured'=> 0
                ]);
                
        }elseif($request->mode == 1){
            Product::where('id', $request->product_id)
            ->update([
                'featured'=> 1
            ]);
            
        }
        return redirect()->back()->with('info', 'Featured Updated Successfully!');
        
    }
    public function getChildCategory(Request $request){
        $parent_cat = $request->parent_cat;
        $data = ProductCategory::where('parent_id', $parent_cat)->pluck('title', 'id');
        if($data->count()){
            return  response()->json(['status'=>true, 'data'=>$data, 'msg'=>'']);
        }else{
            return response()->json(['status'=>false, 'data'=>Null, 'msg'=>'No child category found!']);
        }
    }

    // get child cat on edit 
    
    public function ChildCategory(Request $request){
        $selected = $request->selected;
        $parentid = $request->parent_id;
        $children = ProductCategory::where('parent_id', $parentid)->get();
        $output = '';
        $output .= '<option value="">--Select City--</option>';
        foreach($children as $child){
            $output.='<option value="'.$child->id.'" '.(($selected == $child->id)?' selected':'').'>'.$child->title.'</option>';
        }

        return $output;
    }
    // fetch single product from the database
    public function productDetail(Request $request){
        $uniquekey = $request->uniquekey;
        $get = Product::where('unique_key', $uniquekey)->get()->first();
        $output = '';
                if($get->child_cat_id != ''){
                    $childCat = ProductCategory::where('id', $get->child_cat_id)->get()->first()->title;
                }else{
                    $childCat = '<span class="text-warning">No Child Category</span>';
                }
                $color = explode(',',$get->color);
                $sizes = explode(',',$get->size);
               
                $status = (($get->status == 'active')? 'success':'danger');
                $homeshop = (($get->vendor_id != '')? User::find($get->vendor_id)->fullname:' <span class="badge badge-pill badge-primary">Home Shop</span>');
                
                $output .= '<div class="row">
                                <div class="col-md-8 shadow-lg">
                                    <img  src="'.asset('uploads/products').'/'.$get->photo.'" 
                                    class="img-fluid" alt="'.$get->title.'">
                                </div>
                                <div class="col-md-4">
                                    <h2 class="text-muted">'.$get->title.'</h2>
                                </div>
                            </div>
                            <hr class="invisible">
                            <div class="row shadow-lg p-3">
                                <div class="col-md-3">
                                    <h5 class="">Title</h5>
                                    '.$get->title.'
                                </div>
                                <div class="col-md-3">
                                    <h5 class="">Slug Url</h5>
                                    '.$get->slug.'
                            </div>
                            <div class="col-md-3">
                                    <h5 class="">Category</h5>
                                    '.ProductCategory::where('id', $get->cat_id)->get()->first()->title.'
                            </div>
                            <div class="col-md-3">
                                    <h5 class="">Child Category</h5>
                                    '.$childCat.'
                            </div>
                           
                         </div>
                         <hr class="invisible">
                    <div class="row shadow-lg p-3">
                         <div class="col-md-3">
                         <h5 class="">Brand</h5>
                         '.$get->brand->title.'
                        </div>
                        <div class="col-md-3">
                                <h5 class="">Price</h5>
                                '.Naira($get->price).'
                        </div>
                        <div class="col-md-3">
                                <h5 class="">Sales Price</h5>
                                '.Naira($get->sales_price).'
                        </div>
                        <div class="col-md-3">
                                <h5 class="">Discount</h5>
                                '.Naira($get->product_discount).'
                        </div>
                    </div>
                  <div class="row shadow-lg p-3">
                        <div class="col-md-3">
                            <h5 class="">Stock</h5>
                            '.$get->stock.'
                        </div>
                        <div class="col-md-3">
                                <h5 class="">Weight</h5>
                                '.$get->weights.'
                        </div>
                        <div class="col-md-3">
                                <h5 class="">Size</h5>';
                                foreach ($sizes as $size) {
                                    $output.= '<span class="badge badge-pill badge-info m-1">'.$size.'</span>';
                                }
                       $output.='</div>
                        <div class="col-md-3">
                                <h5 class="">Color</h5>';
                                foreach ($color as $col) {
                                $output .='<span class="badge badge-pill badge-primary ml-1">'.$col.'</span>';
                                }
                        $output.='</div>
                    </div>
                        <hr class="invisible">
                            <div class="row shadow-lg p-3">
                                <div class="col-md-3">
                                    <h5 class="">Condition</h5>
                                    <span class="badge badge-pill badge-primary ml-1">'.$get->condition.'</span>
                                </div>
                                <div class="col-md-3">
                                    <h5 class="">Status</h5>
                                    <span class="badge badge-pill badge-'.$status.' ml-1">'.$get->status.'</span>
                            </div>
                            <div class="col-md-3">
                                    <h5 class="">Unique Key</h5>
                                    <span class="badge badge-pill badge-success ml-1">'.$get->unique_key.'</span>
                            </div>
                            <div class="col-md-3">
                                    <h5 class="">Vendor</h5>
                                    '.$homeshop.'
                            </div>
                           
                         </div>
                    
                    ';
                
        return $output;
    } 



public function EditProduct($unique_key){
    $categories = ProductCategory::where('is_parent', 1)->where('status', 'active')->get();
    $brands = Brand::where('status', 'active')->get();
    $product_count = Product::where('home_shop', 1)->count();
    $product = Product::where('unique_key', $unique_key)->get()->first();
    $conditions = Condition::all();
    return view('users.superuser.product.products.super-editproducts', 
        [
        'categories'=>$categories, 
        'brands'=>$brands, 
        'product_count'=>$product_count, 
        'product'=>$product,
        'conditions'=>$conditions
    ]);
}

public function deleteProductImage(Request $request){
    $id = $request->product_id;
    $getfile = Product::where('id', $id)->get()->first();
    $getfolder = explode('/', $getfile->photo);
    $folder = 'uploads/products/'.$getfolder[0];
    if(Storage::deleteDirectory($folder)){
        Product::where('id', $id)->update([
            'photo' => Null
        ]);
    
        return redirect()->back()->with('info', 'Image Deleted!')->withInput();
    }
}

public function updateProduct(Request $request){
    
    $validator = Validator::make($request->all(), [
        'product_title' => 'required|min:3|max:100',
        'product_stock' => 'required',
        'product_weights' => 'nullable|numeric',
        'product_price' => 'required',
        'product_discount' => 'nullable|numeric',
        'product_brand' => 'required',
        'product_category' => 'required|exists:product_categories,id',
        'product_child_category' => 'nullable|exists:product_categories,id',
        'product_condition' => 'nullable:in:new,popular,onsale,featured',
        'product_status' => 'nullable|in:active,inactive',
        'product_color' => 'nullable',
        'product_size' => 'nullable',
        'product_summary' => 'nullable',
        'product_description' => 'nullable',
    ]);
    $tmp_file = TemporaryFile::where('folder', $request->product_file)->get()->first();
    $des_folder = 'uploads/products/tmp/';
    $des_folder_final  = 'uploads/products/';
    if(!$validator->passes()){
        if($tmp_file){
            Storage::deleteDirectory($des_folder.$tmp_file->folder);
            $tmp_file->delete();
        }
        return redirect()->back()->withErrors($validator->errors())->withInput();
    }else{
        $product = Product::where('id', $request->product_id)->get()->first();
        if($tmp_file){
            Storage::copy($des_folder.$tmp_file->folder.'/'.$tmp_file->file, $des_folder_final.$tmp_file->folder.'/'.$tmp_file->file);
            $newfilename = $tmp_file->folder.'/'.$tmp_file->file;
           
        }else{
            $newfilename = $request->product_file_saved;
        }
            
        if($request->product_title != $product->title){
                $slug_url = Str::slug($request->product_title);
                $check_slug = Product::where('slug', $slug_url)->count();
                if($check_slug > 0){
                    $slug_url = $slug_url . '-' . rand(1111,9999);
                }
            }else{
                $slug_url = $product->slug;
            }
            
            //caculate discount
            //sales_price = (price-((price*discount)/100)) // not working well
            $sales_price = $request->product_price - $request->product_discount;


            //collect color and size array
            
            $size =  $request->product_size;
            $color = $request->product_color;

            Product::where('id', $request->product_id)->update([
                'photo' => $newfilename,
                'title' => $request->product_title,
                'slug' => $slug_url,
                'summary' => $request->product_summary,
                'description' => $request->product_description,
                'stock' => $request->product_stock,
                'brand_id' => $request->product_brand,
                'cat_id' => $request->product_category,
                'child_cat_id' => $request->product_child_category,
                'price' => $request->product_price,
                'product_discount' => $request->product_discount,
                'sales_price' => $sales_price,
                'weights' => $request->product_weights,
                'size' => $size,
                'condition' => $request->product_condition,
                // 'vendor_id' => null,
                'status' => $request->product_status,
                'color' => $color,
              
            ]);
            if($tmp_file){
                Storage::deleteDirectory($des_folder.$tmp_file->folder);
                $tmp_file->delete();
            }
            return redirect()->route('superuser.super.products.page')->with('success','Product updated successfully!')->withInput();
        
    }
  
}
public function deleteProduct(Request $request){
    $file = Product::find($request->product_id);
    if($file->status == 'active'){
        return response()->json(['code'=>0, 'error'=>'Please deactivated product before deleting!']);
    }else{
            $getfolder = explode('/', $file->photo);
            $folder = 'uploads/products/'.$getfolder[0];
            if(Storage::deleteDirectory($folder)){
            Product::where('id', $request->product_id)->delete();
        }

        return response()->json(['code'=>1, 'msg'=>'Product Deleted Successfully!']);
    }
}



public function sizesPage(){
    // $products = Product::where('home_shop', 1)->get();
    // $product_count = Product::where('home_shop', 1)->count();
    return view('users.superuser.product.sizes.super-sizes');
}


public function addSizes(Request $request){
    // validate all request
    // validate all request
    $validator = Validator::make($request->all(), [
        'size' => 'required',
        
    ]);

    if(!$validator->passes()){
     // if validation is fail return the error message
      return response()->json(['code' => 0,  'error'=>$validator->errors()->toArray()]);
    }else{
         $size = Size::where('size', $request->size)->get();
        if(count($size) > 0){
         return response()->json(['code' => 2,  'error'=>'Size already exists!']);
      }

        Size::create([
        'size' => strtoupper($request->size),
        ]);

        return response()->json(['code'=>1, 'msg'=>'Size added Successfully!']);
     }

}


public function ListSizes(){
    $sizes = Size::orderBy('id', 'desc')->get();
    return Datatables::of($sizes)
                    ->addIndexColumn()
                    ->addColumn('actions', function($row){
                        return '
                        <div class="btn-group">
                        <button type="button" 
                        data-id="'.$row->id.'" 
                        data-url=""
                        id="deleteProductCategory" 
                        class="btn btn-outline-danger">Delete</button>
                    </div>';
                                                
                    })
                    ->rawColumns(['actions'])
                    ->make(true);
}

public function colorsPage(){
    // $product_count = Product::where('home_shop', 1)->count();
    return view('users.superuser.product.colors.super-colors');
}

public function addColors(Request $request){
    // validate all request
    $validator = Validator::make($request->all(), [
                    'color' => 'required',
                    
    ]);

    if(!$validator->passes()){
        // if validation is fail return the error message
        return response()->json(['code' => 0,  'error'=>$validator->errors()->toArray()]);
    }else{
        $color = Color::where('color', $request->color)->get();
        if(count($color) > 0){
            return response()->json(['code' => 2,  'error'=>'Color already exists!']);
        }

        Color::create([
            'color' => $request->color
        ]);

        return response()->json(['code'=>1, 'msg'=>'Color added Successfully!']);
    }

}

public function ListColors(){
    $colors = Color::orderBy('id', 'desc')->get();
    return Datatables::of($colors)
                    ->addIndexColumn()
                    ->addColumn('actions', function($row){
                        return '
                        <div class="btn-group">
                        <button type="button" 
                        data-id="'.$row->id.'" 
                        data-url=""
                        id="deleteProductCategory" 
                        class="btn btn-outline-danger">Delete</button>
                    </div>';
                                                
                    })
                    ->rawColumns(['actions'])
                    ->make(true);
}



public function conditionPage(){
    // $product_count = Product::where('home_shop', 1)->count();
    return view('users.superuser.product.conditions.super-conditions');
}

public function addConditions(Request $request){
    // validate all request
    $validator = Validator::make($request->all(), [
                    'condition' => 'required',
                    
    ]);

    if(!$validator->passes()){
        // if validation is fail return the error message
        return response()->json(['code' => 0,  'error'=>$validator->errors()->toArray()]);
    }else{
        $condition = Condition::where('condition', $request->condition)->get();
        if(count($condition) > 0){
            return response()->json(['code' => 2,  'error'=>'Condition already exists!']);
        }

        Condition::create([
            'condition' => $request->condition
        ]);

        return response()->json(['code'=>1, 'msg'=>'Condition added Successfully!']);
    }

}

public function ListConditions(){
    $condition = Condition::orderBy('id', 'desc')->get();
    return Datatables::of($condition)
                    ->addIndexColumn()
                    ->addColumn('actions', function($row){
                        return '
                        <div class="btn-group">
                        <button type="button" 
                        data-id="'.$row->id.'" 
                        data-url=""
                        id="deleteCondtion" 
                        class="btn btn-outline-danger">Delete</button>
                    </div>';
                                                
                    })
                    ->rawColumns(['actions'])
                    ->make(true);
}






}
// 'title',
// 'slug',
// 'summary',
// 'description',
// 'stock',
// 'brand_id',
// 'cat_id',
// 'child_cat_id',
// 'price',
// 'sales_price',
// 'product_discount',
// 'weights',
// 'size',
// 'condition',
// 'vendor_id',
// 'status',
// 'color',
// 'unique_key'