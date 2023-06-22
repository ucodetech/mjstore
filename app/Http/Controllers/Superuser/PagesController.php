<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\Superuser;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class PagesController extends Controller
{
    public function Dashboard(Request $request){
        return view('users.superuser.super-dashboard');
    }


    public function showBannerPage(){
        return view('users.superuser.banner.super-banner');
    }


    public function showProductCategoryPage(){
        $product_category = ProductCategory::where('status', 'active')->orderBy('parent_id', 'desc')->get();
        return view('users.superuser.product.super-productcategory', compact('product_category', $product_category));
    }



    public function brandPage(){
        return view('users.superuser.brand.super-brand');
    }

    public function customerPage(){
        $user_count = User::all()->count();
        return view('users.superuser.customers.super-users', ['user_count'=>$user_count]);
    }

    public function superuserPage(){
        return view('users.superuser.auth.list-superusers');
    }

    public function superuserProfile(){
        $super = Superuser::where('id', auth()->user()->id)->get()->first();
        return view('users.superuser.auth.super-profile', ['super'=>$super]);
    }


    public function deleteTempFile(Request $request){
         //delete Temporary files 
         if($request->deleteTempFiles == 'deleteTmpFiles')
            $tmp_file = TemporaryFile::where('date_created', '<' ,Carbon::now())->get();
            if(count($tmp_file)>0){
                foreach($tmp_file as $file){
                    //delete the golder
                $folder1 = 'uploads/products/tmp/'.$file->folder;
                $folder2 = 'uploads/products/category/tmp/'.$file->folder;
                $folder3 = 'uploads/brands/tmp/'.$file->folder;
                $folder4 = 'uploads/banners/tmp/'.$file->folder;
                $folders = [$folder1, $folder2, $folder3, $folder4];
                    if($folders)
                        foreach($folders as $folder){
                            Storage::deleteDirectory($folder);
                        }
                    
                        $file->delete();
                       
                }
                
                return 'Tmp files deleted for date: ' . pretty_dates(Carbon::now());
            }
            return 'No tmp file to delete for date: ' . pretty_dates(Carbon::now());
    }
}
