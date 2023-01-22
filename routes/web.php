<?php

use App\Http\Controllers\Superuser\PagesController;
use App\Http\Controllers\Superuser\SuperuserController;
use App\Http\Controllers\Superuser\BannerController;
use App\Http\Controllers\Superuser\BrandController;
use App\Http\Controllers\Superuser\ProductCategoryController;
use App\Http\Controllers\Superuser\ProductController;
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
            Route::get('/super-productcategories', 'showProductCategoryPage')->name('super.product.category.page');
            Route::get('/super-brands', 'brandPage')->name('super.brands.page');

          
        });

        Route::controller(SuperuserController::class)->group(function () {
            Route::get('/super-logout', 'superLogout')->name('super.logout');
            Route::get('/super-register', 'showRegisterPage')->name('super.register.page');
            Route::post('/super-post-register', 'processRegister')->name('super.process.register');

            
        });

        Route::controller(BannerController::class)->group(function(){
            Route::get('/super-banners-list', 'ListBanners')->name('super.list.banners');
            Route::post('/super-banner-add', 'addBanner')->name('super.add.banner');
            Route::get('/generate-banner-slugurl', 'GenerateBannerSlugUrl')->name('super.generate.banner.slugurl');
            Route::get('/edit-generate-banner-slugurl', 'ReGenerateBannerSlugUrl')->name('super.regenerate.banner.slugurl');
            Route::get('/super-banner-edit/{id}', 'EditBanner')->name('super.edit.banner');
            Route::post('/super-banner-update', 'updateBanner')->name('super.update.banner');
            Route::post('/super-banner-active', 'activeBanner')->name('super.active.banner');
            Route::post('/super-banner-inactive', 'inactiveBanner')->name('super.inactive.banner');
            Route::post('/super-banner-promo', 'promoBanner')->name('super.promo.banner');
            Route::post('/super-banner-banner', 'bannerBanner')->name('super.banner.banner');
            Route::post('/super-banner-delete', 'deleteBanner')->name('super.delete.banner');
            Route::post('/super-banner-image-delete', 'deleteBannerImage')->name('super.delete.banner.image');

        });

        Route::controller(ProductCategoryController::class)->group(function(){
            Route::get('/super-pcategory-list', 'ListPCategories')->name('super.list.products.categories');
            Route::post('/super-pcategory-add', 'addPcategory')->name('super.add.product.category');
            Route::get('/generate-pcategory-slugurl', 'GenerateProductCategorySlugUrl')->name('super.generate.product.category.slugurl');
            Route::get('/super-pcategory-edit/{id}', 'EditPcategory')->name('super.edit.product.category');
            Route::post('/super-pcategory-update', 'updatePcategory')->name('super.update.product.category');
            Route::post('/super-pcategory-active', 'activePcategory')->name('super.active.product.category');
            Route::post('/super-pcategory-inactive', 'inactivePcategory')->name('super.inactive.product.category');
            Route::post('/super-pcategory-delete', 'deletePcategory')->name('super.delete.product.category');
            Route::post('/super-pcategory-image-delete', 'deletePcategoryImage')->name('super.delete.product.category.image');


        });

        // product route
        Route::controller(ProductController::class)->group(function () {
            Route::get('/super-products-page', 'productPage')->name('super.products.page');
            Route::get('/super-add-product-page', 'addProductPage')->name('super.add.product.page');
            Route::get('/generate-product-slugurl', 'GenerateProductSlugUrl')->name('super.generate.product.slugurl');
            Route::get('/super-product-edit/{id}', 'EditProduct')->name('super.edit.product');
            Route::post('/super-product-update', 'updateProduct')->name('super.update.product');
            Route::post('/super-product-status', 'productStatus')->name('super.toggle.status.product');
            Route::post('/super-product-delete', 'deleteProduct')->name('super.delete.product');
            Route::post('/super-product-image-delete', 'deleteProductImage')->name('super.delete.product.image');

        });

          // product route
          Route::controller(BrandController::class)->group(function () {
            Route::get('/super-brand-list', 'ListBrands')->name('super.list.brand');
            Route::post('/super-brand-add', 'addBrand')->name('super.add.brand');
            Route::get('/generate-brand-slugurl', 'GenerateBrandSlugUrl')->name('super.generate.brand.slugurl');
            Route::get('/super-brand-edit/{id}', 'EditBrand')->name('super.edit.brand');
            Route::post('/super-brand-update', 'updateBrand')->name('super.update.brand');
            Route::post('/super-brand-active', 'activateBrand')->name('super.active.brand');
            Route::post('/super-brand-inactive', 'deactivateBrand')->name('super.inactive.brand');
            Route::post('/super-brand-delete', 'deleteBrand')->name('super.delete.brand');
            Route::post('/super-brand-image-delete', 'deleteBrandImage')->name('super.delete.brand.image');
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
