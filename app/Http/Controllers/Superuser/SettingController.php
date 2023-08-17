<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function Index(){
        $settings = Settings::where('id', 0)->first();
        return view('users.superuser.settings.super-settings', ['settings'=>$settings]);
    }

    public function UpsertSettings(Request $request){
        $get = Settings::where('id', 0)->first();

        $validator = Validator::make($request->all(), [
                        'site_title' => 'required',
                        'site_logo' => 'sometimes|required|mimes:png,jpg',
                        'favicon' => 'sometimes|required|mimes:ico',
                        'address' => 'required',
                        'phone' => 'required',
                        'email' => 'required',
                        'made_with' => 'required',
        ]);

        if(!$validator->passes()){
            return back()->withErrors($validator->errors()); 
        }else{
            //check if inserted before 
            if($get){
                if($request->hasFile('site_logo')){
                    $filelogo = $request->file('site_logo');
                    $filefavicon = $request->file('favicon');
                    $newlogoname = 'mjstore-logo'. '.'.$request->site_logo->extension();
                    $newfaviconname = 'mjstore-favicon' . '.' . $request->favicon->extension();
                    $path = 'uploads/settings';
                   
                    $filelogo->storeAs($path, $newlogoname);
                    $filefavicon->storeAs($path, $newfaviconname);
                }else{
                    $filefavicon = $request->favicon_saved;
                    $newlogoname = $request->site_logo_saved;
                }
                Settings::where('id', 0)->update([
                    'site_title'  => $request->site_title,
                    'meta_description'  => $request->meta_description,
                    'meta_keywords'  => $request->meta_keywords,
                    'site_logo'  => $newlogoname,
                    'favicon'  => $filefavicon,
                    'address'  => $request->address,
                    'phone'  => $request->phone,
                    'email'  => $request->email,
                    'made_with'  => $request->made_with,
                    'facebook_url'  => $request->facebook_url,
                    'whatsapp_url'  => $request->whatsapp_url,
                    'instagram_url'  => $request->instagram_url,
                    'linkedin_url'  => $request->linkedin_url,
                    'youtube_url'  => $request->youtube_url,
                    'twitter_url'  => $request->twitter_url

                ]);
                return redirect()->back()->with("success", "Settings updated!")->withInput();
            }else{
                if($request->hasFile('site_logo')){
                    $filelogo = $request->file('site_logo');
                    $filefavicon = $request->file('favicon');
                    $newlogoname = 'mjstore-logo'. '.'.$request->site_logo->extension();
                    $newfaviconname = 'mjstore-favicon' . '.' . $request->favicon->extension();
                    $path = 'uploads/settings';
                   
                    $filelogo->storeAs($path, $newlogoname);
                    $filefavicon->storeAs($path, $newfaviconname);
                }
                Settings::create([
                    'id' => 0,
                    'site_title'  => $request->site_title,
                    'meta_description'  => $request->meta_description,
                    'meta_keywords'  => $request->meta_keywords,
                    'site_logo'  =>  $newlogoname,
                    'favicon'  => $newfaviconname,
                    'address'  => $request->address,
                    'phone'  => $request->phone,
                    'email'  => $request->email,
                    'made_with'  => $request->made_with,
                    'facebook_url'  => $request->facebook_url,
                    'whatsapp_url'  => $request->whatsapp_url,
                    'instagram_url'  => $request->instagram_url,
                    'linkedin_url'  => $request->linkedin_url,
                    'youtube_url'  => $request->youtube_url,
                    'twitter_url'  => $request->twitter_url
                ]);
                 return redirect()->back()->with("success", "Settings created!")->withInput();
            }
        }
    }
}
