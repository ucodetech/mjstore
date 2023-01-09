<?php

use App\Http\Controllers\Superuser\PagesController;
use App\Http\Controllers\Superuser\SuperuserController;
use App\Http\Controllers\Superuser\BannerController;
use App\Http\Controllers\User\UserPages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('superuser')->name('superuser.')->group(function(){

    Route::middleware(['guest:superuser'])->group(function () {
        Route::controller(SuperuserController::class)->group(function () {
            Route::get('/super-login', 'showLogin')->name('super.login');
            Route::post('/super-process-login', 'processLogin')->name('super.process.login');
            Route::get('/super-email-verify', 'VerifyEmail')->name('super.email.verify');
            Route::get('/super-invalid-token', 'invalidToken')->name('super.invalidtoken');


            
        });
    });

    Route::middleware(['auth:superuser'])->group(function () {
        Route::controller(PagesController::class)->group(function () {
            Route::get('/super-dashboard', 'Dashboard')->name('super.dashboard');
            Route::get('/super-banner', 'showBannerPage')->name('super.banner.page');
          
        });

        Route::controller(SuperuserController::class)->group(function () {
            Route::get('/super-logout', 'superLogout')->name('super.logout');
            Route::get('/super-register', 'showRegisterPage')->name('super.register.page');
            Route::post('/super-post-register', 'processRegister')->name('super.process.register');

            
        });

        Route::controller(BannerController::class)->group(function(){
            Route::get('/super-banners-list', 'ListBanners')->name('super.list.banners');
            Route::get('/super-banner-edit', 'EditBanner')->name('super.edit.banner');
            Route::post('/super-banner-update', 'updateBanner')->name('super.update.banner');
            Route::post('/super-banner-active', 'activeBanner')->name('super.active.banner');
            Route::post('/super-banner-inactive', 'inactiveBanner')->name('super.inactive.banner');
            Route::post('/super-banner-promo', 'promoBanner')->name('super.promo.banner');
            Route::post('/super-banner-banner', 'bannerBanner')->name('super.banner.banner');
            Route::post('/super-banner-delete', 'deleteBanner')->name('super.delete.banner');

        });


    });


});

Route::prefix('user')->name('user.')->group(function(){
    Route::middleware(['guest:web'])->group(function () {
        Route::controller(UserPages::class)->group(function () {
            Route::get('/user-dashboard', 'userDashboard');
           
        });
    });

    Route::middleware(['auth:web'])->group(function () {
        
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
