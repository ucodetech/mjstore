<?php

use App\Http\Controllers\Superuser\PagesController;
use App\Http\Controllers\Superuser\SuperuserController;
use App\Http\Controllers\Superuser\BannerController;
use App\Http\Controllers\Superuser\BrandController;
use App\Http\Controllers\Superuser\ProductCategoryController;
use App\Http\Controllers\Superuser\ProductController;
use App\Http\Controllers\Superuser\UserController;
use App\Http\Controllers\User\UserPages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontPagesController;
use App\Http\Controllers\User\CustomerController;
use App\Http\Controllers\Vendor\SellerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Superuser\CouponController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Superuser\SuperCurrencyController;
use App\Http\Controllers\Superuser\ShippingMethodController;
use App\Http\Controllers\Superuser\SuperuserOrderController;
use App\Http\Controllers\Superuser\SettingController;
use App\Http\Controllers\Superuser\SuperSellerController;
use App\Http\Controllers\Vendor\SellerDashboardController;

use App\Http\Controllers\Vendor\SellerBrandController;
use App\Http\Controllers\Vendor\SellerProductCategoryController;
use App\Http\Controllers\Vendor\SellerProductController;
use App\Http\Controllers\Vendor\SellerCouponController;
use App\Http\Controllers\Vendor\SellerOrderController;



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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::controller(SuperCurrencyController::class)->group(function () {
    Route::get('/currency_load', 'LoadCurrency')->name('shop.load.currency');

    // Route::post('/orders', 'store');
});


Route::controller(FrontPagesController::class)->group(function () {
    Route::get('/', 'Index')->name('home');
    Route::get('/category/{slug_url}', 'Category')->name('category.product');
    Route::get('/shop-mjstore-list', 'ShopList')->name('shop.list');
    Route::get('/product-details/{slug_url}', 'productDetails')->name('product.details');
    Route::get('/product-quick-view', 'productQuickview')->name('product.quickview.detail');
    Route::get('/products-category/{slug_url}', 'categoryProducts')->name('products.category');
    Route::get('/404-error', 'Error404')->name('404');
    Route::get('/shop-cart', 'ShopCart')->name('shop.cart');
    Route::post('/search-brand', 'searchBrand')->name('search.brand');
    Route::post('/fetch-brand', 'fetchBrand')->name('fetch.brand');
    Route::post('/multi-filter', 'multiFilter')->name('multi.filter');
    Route::get('/auto-search', 'autoSearch')->name('auto.search');
    Route::get('/get-formatted-price', 'formattedCurrency')->name('get.formatted.currency');
    Route::post('/submit-review', 'submitReview')->name('submit.review');
    Route::get('/fetch-review', 'fetchReview')->name('fetch.review');






    // Route::post('/orders', 'store');
});


Route::controller(CheckoutController::class)->middleware('is_logged_in')->group(function(){
    Route::get('/process-checkout', 'CheckoutProcess')->middleware('is_cart_empty')->name('shop.billing.checkout');
    // Route::get('/checkout-shipping', 'ShippingCheckout')->name('shop.shipping.checkout');
    // Route::get('/checkout-payment', 'PaymentCheckout')->name('shop.payment.checkout');
    Route::get('/checkout-review', 'ReviewCheckout')->name('shop.review.checkout');
    Route::post('/get-state-lga', 'getStateLGA')->name('get.state.lga');



    Route::post('/checkout-billing-submit', 'BillingCheckoutSubmit')->name('shop.billing.submit');
    Route::post('/checkout-billing-update', 'UpdateBillingCheckoutSubmit')->name('shop.billing.update.submit');
    Route::post('/get-state-city', 'getStateCity')->name('get.state.city');


    Route::post('/checkout-shipping-submit', 'ShippingCheckoutSubmit')->name('shop.shipping.submit');
    Route::get('/get-shipping-details', 'getShippingDetails')->name('get.shipping.details');
    Route::post('/change-shipping-method', 'changeShippingMethod')->name('change.delivery.method');

    Route::post('/checkout-payment-submit', 'PaymentCheckoutSubmit')->name('shop.payment.method.submit');
    Route::post('/checkout-payment-final', 'PaymentProceed')->name('shop.comfirm.order');

    Route::post('/checkout-complete-order-submit', 'ComfirmOrder')->name('shop.comfirm.order.submit');

    Route::get('/get-order-details', 'getOrderDetails')->name('get.order.details');

    Route::get('/order-completed/{orderid}', 'orderCompleted')->name('shop.order.completed');

    Route::get('/temp-view', 'tempView');

});
 //wishlist 
 Route::controller(WishlistController::class)->group(function(){
    Route::post('/store-wishlist', 'StoreWishlist')->name('wishlist.store');
});

Route::controller(CartController::class)->group(function(){
    Route::post('/store-cart-item', 'StoreCartItem')->name('cart.store');
    Route::post('/delete-cart-item', 'DeleteCartItem')->name('cart.delete');
    Route::post('/update-cart', 'updateCart')->name('cart.update');
    Route::post('/apply-coupon', 'applyCoupon')->name('cart.apply.coupon.code');
    Route::post('/clear-coupon-session', 'clearCouponSession');

});



// Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth:superuser,seller']], function () {
//     \UniSharp\LaravelFilemanager\Lfm::routes();
//    });


Route::prefix('superuser')->name('superuser.')->group(function(){

    Route::middleware(['guest:superuser'])->group(function () {
        Route::controller(SuperuserController::class)->group(function () {
            Route::get('/super-login', 'showLogin')->name('super.login');
            Route::post('/super-process-login', 'processLogin')->name('super.process.login');
            Route::get('/super-email-verify', 'VerifyEmail')->name('super.email.verify');
            Route::get('/super-invalid-token', 'invalidToken')->name('super.invalidtoken');
           

            
        });
    });

    Route::middleware(['auth:superuser', 'is_super_email_verified'])->group(function () {
       
        Route::controller(PagesController::class)->group(function () {
            Route::get('/super-dashboard', 'Dashboard')->name('super.dashboard');
            Route::get('/super-banner', 'showBannerPage')->name('super.banner.page');
            Route::get('/super-productcategories', 'showProductCategoryPage')->name('super.product.category.page');
            Route::get('/super-brands', 'brandPage')->name('super.brands.page');
            Route::get('/super-users', 'customerPage')->name('super.user.page');
            Route::get('/super-sellers', 'sellerPage')->name('super.seller.page');
            Route::get('/super-superusers', 'superuserPage')->middleware('is_superuser')->name('super.superuser.page');
            Route::get('/super-profile', 'superuserProfile')->name('super.profile');
            Route::post('/super-delete-temp-files', 'deleteTempFile')->name('super.delete.temp.files');
          
        });

        Route::controller(SuperuserController::class)->group(function () {
            Route::get('/super-logout', 'superLogout')->name('super.logout');
           
            Route::post('/super-update-details', 'updateSuperuser')->name('super.update.details');
            Route::post('/super-update-password', 'updateSuperPassword')->name('super.update.password');
            Route::post('/super-update-profile-photo', 'updateSuperPhoto')->name('super.update.profile.photo');
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
            Route::post('/tmp-upload-banner', 'tmpUploadBanner');
            Route::delete('/tmp-revert-banner', 'tmpDeleteBanner');

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
            Route::post('/tmp-upload-category', 'tmpUploadCategory');
            Route::delete('/tmp-revert-category', 'tmpDeleteCategory');

            Route::post('/super-pcategory-top', 'topPcategory')->name('super.top.product.category');
            Route::post('/super-pcategory-regular', 'regularPcategory')->name('super.regular.product.category');

        });

        // product route
        Route::controller(ProductController::class)->group(function () {
            Route::get('/super-products-page', 'productPage')->name('super.products.page');
            Route::get('/super-add-product-page', 'productAddPage')->name('super.add.product.page');
            Route::post('/super-process-product-create', 'processProductCreate')->name('super.process.product.create');
            Route::get('/generate-product-slugurl', 'GenerateProductSlugUrl')->name('super.generate.product.slugurl');
            Route::get('/super-product-edit/{unique_key}', 'EditProduct')->name('super.edit.product');
            Route::post('/super-product-update', 'updateProduct')->name('super.update.product');
            Route::post('/super-product-detail', 'productDetail')->name('super.detail.product');
            Route::post('/super-product-status', 'productStatus')->name('super.toggle.status.product');
            Route::post('/super-product-delete', 'deleteProduct')->name('super.delete.product');
            Route::post('/super-product-image-delete', 'deleteProductImage')->name('super.delete.product.image');
            Route::post('/super-product-image-create', 'processProductCreateImage')->name('super.add.product.image');
            Route::post('/super-get-child-cat', 'getChildCategory');
            Route::get('/super-child-cat', 'ChildCategory')->name('get.product.child.cat');


            Route::get('/super-colors', 'colorsPage')->name('super.page.colors');
            Route::get('/super-sizes', 'sizesPage')->name('super.page.sizes');
            Route::get('/super-conditions', 'conditionPage')->name('super.page.conditions');


            Route::get('/super-sizes-list', 'ListSizes')->name('super.list.sizes');
            Route::post('/super-size-add', 'addSizes')->name('super.add.sizes');

            Route::get('/super-colors-list', 'ListColors')->name('super.list.colors');
            Route::post('/super-colors-add', 'addColors')->name('super.add.colors');

            Route::get('/super-conditions-list', 'ListConditions')->name('super.list.conditions');
            Route::post('/super-conditions-add', 'addConditions')->name('super.add.conditions');

            Route::post('/tmp-upload-product', 'tmpUploadProduct')->name('tmp.product.upload');
            Route::delete('/tmp-revert-product', 'tmpDeleteProduct')->name('tmp.product.delete');

            Route::post('/super-product-featured', 'productFeatured')->name('super.toggle.featured.product');

            Route::post('/super-process-product-create-more-images', 'processProductCreateMoreImages')->name('super.upload.more.images');

            //add product attribute route
            Route::get('/super-product-attributes/{uniquekey}', 'productAttributePage')->name('super.add.product.attribute');

            //get stock size
            Route::post('/super-product-attributes-add', 'processProductAttribute')->name('attributes.add');
            Route::get('/super-product-attributes-fetch', 'fetchProductAttribute')->name('attributes.fetch');
            Route::post('/super-product-attributes-delete', 'deleteProductAttribute')->name('attributes.delete');
            Route::post('/super-product-attributes-edit', 'editProductAttribute')->name('attributes.edit');

            //add product information route
            Route::get('/super-product-information/{uniquekey}', 'productInformationPage')->name('super.product.information');
            //product additional information 
            Route::post('/super-product-information-add', 'processProductInformation')->name('information.add');
            Route::get('/super-product-information-fetch', 'fetchProductInformation')->name('information.fetch');
            Route::post('/super-product-information-delete', 'deleteProductInformation')->name('information.delete');
            Route::post('/super-product-information-edit', 'editProductInformation')->name('information.edit');




        });

          // brand route
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
            Route::post('/tmp-upload-brand', 'tmpUploadBrand');
            Route::delete('/tmp-revert-brand', 'tmpDeleteBrand');
        });

        //   list users
          Route::controller(UserController::class)->group(function () {
            Route::get('/super-cusomters-list', 'listCustomers')->name('super.list.customers');
         
            // Route::get('/generate-brand-slugurl', 'GenerateBrandSlugUrl')->name('super.generate.brand.slugurl');
            Route::post('/super-customer.detail', 'CustomerDetail')->name('super.customer.detail');
            // Route::post('/super-brand-update', 'updateBrand')->name('super.update.brand');
            Route::post('/super-activate-customer', 'activateCustomer')->name('super.activate.customer');
            Route::post('/super-deactivate-customer', 'deactivateCustomer')->name('super.deactivate.customer');
           
            //supersusers
            Route::get('/super-superusers-list', 'listSuperusers')->name('super.list.superusers');
            Route::post('/super-edit/{super_uniqueid}', 'editSuperuser')->name('super.edit');
            Route::post('/super-superuser.detail', 'SuperuserDetail')->name('super.superuser.detail');
            Route::post('/super-superuser-update', 'updateSuperuser')->name('super.update.superuser');
            Route::post('/super-activate-superuser', 'activateSuperuser')->name('super.activate.superuser');
            Route::post('/super-deactivate-superuser', 'deactivateSuperuser')->name('super.deactivate.superuser');
          });

        //coupon route
        Route::controller(CouponController::class)->group(function () {
            Route::get('/super-coupon-page', 'showCouponPage')->name('super.coupon.page');
            Route::post('/super-coupon-status', 'couponStatus')->name('super.toggle.status.coupon');
            Route::get('/super-coupon-list', 'ListCoupon')->name('super.list.coupon');
            Route::post('/super-coupon-add', 'addCoupon')->name('super.add.coupon');
            Route::post('/super-coupon-delete', 'deleteCoupon')->name('super.delete.coupon');
            Route::get('/super-coupon-edit', 'editCoupon')->name('super.edit.coupon');
            Route::get('/generate-coupon-code', 'GenerateCouponCode')->name('super.generate.coupon.code');
            Route::post('/super-coupon-type', 'couponType')->name('super.toggle.type.coupon');



        });

        Route::controller(ShippingMethodController::class)->group(function () {
            Route::get('/super-shipping', 'ShippingMethod')->name('super.shipping.method');
            Route::post('/super-process-method', 'storeShippingMethod')->name('super.process.method');
            Route::get('/super-shipping-list', 'listShippingMethod')->name('super.list.shipping.method');
            Route::post('/super-shipping-method-status', 'shippingMethodStatus')->name('super.toggle.status.shipping.method');

        });

        Route::controller(SuperuserOrderController::class)->group(function(){
            Route::get('/super-orders', 'orderPage')->name('super.orders');
            Route::get('/super-order-details/{orderId}', 'orderItems')->name('super.order.items');
            Route::post('/super-update-order-status', 'updateOrderStatus')->name('super.update.order.status');
            Route::post('/super-get-order-status', 'getOrderStatus')->name('super.get.order.status');
            Route::post('/super-delete-order', 'deleteOrder')->name('super.delete.order');
        });
        
        //settings route
        Route::controller(SettingController::class)->group(function () {
            Route::get('/super-settings', 'Index')->name('super.settings.index');
            Route::post('/super-upsert-settings', 'UpsertSettings')->name('super.update.insert.setttings');
        });
      
        Route::controller(SuperCurrencyController::class)->group(function(){
            Route::get('/super-currencies', 'CurrencyPage')->name('super.currency');
            Route::post('/super-update-currency-status', 'updateCurrenyStatus')->name('super.update.currency.status');
            Route::post('/super-add-currency', 'addCurrency')->name('super.add.currency');
            Route::get('/super-list-currency', 'listCurrency')->name('super.list.currency');
            Route::post('/super-delete-currency', 'deleteCurrency')->name('super.delete.currency');
        });
      
        //seller controller
        //list users
        Route::controller(SuperSellerController::class)->group(function () {
            Route::get('/super-sellers-list', 'listSellers')->name('super.list.sellers');
         
            // Route::get('/generate-brand-slugurl', 'GenerateBrandSlugUrl')->name('super.generate.brand.slugurl');
            Route::get('/super-seller-detail/{uniquekey}', 'SellerDetail')->name('super.seller.detail');
            Route::post('/super-seller-request', 'sellerRequest')->name('super.seller.request');
            Route::post('/super-seller-approve', 'sellerApprove')->name('super.seller.approve');
            Route::post('/super-activate-seller', 'activateSeller')->name('super.activate.seller');
            Route::post('/super-deactivate-seller', 'deactivateSeller')->name('super.deactivate.seller');
           
          
          });



    });


});

Route::prefix('user')->name('user.')->group(function(){

    Route::middleware(['guest:web'])->group(function () {
        Route::controller(UserPages::class)->group(function () {
            Route::get('/login-user', 'userLogin')->name('user.login');
            Route::get('/register-user', 'userRegister')->name('user.register');
            Route::post('/processs-login-user', 'userLoginProcess')->name('user.login.process');
            Route::post('/processs-register-user', 'userRegisterProcess')->name('user.register.process');
            Route::get('/success-user', 'userRegisterSuccess')->name('user.register.success.page');
            
        });
        Route::controller(CustomerController::class)->group(function () {
            Route::post('/processs-login-user', 'userLoginProcess')->name('user.login.process');
            Route::post('/processs-register-user', 'userRegisterProcess')->name('user.register.process');
            Route::get('/success-user', 'userRegisterSuccess')->name('user.register.success.page');
            Route::get('/user-email-verify', 'VerifyEmail')->name('customer.email.verify');
            Route::get('/user-invalid-token', 'invalidToken')->name('user.invalidtoken');
            Route::get('/forgot-password', 'userForgotPassword')->name('user.forgot.password');

        });
    });

    Route::middleware(['auth:web', 'is_user_email_verified'])->group(function () {
        Route::controller(CustomerController::class)->group(function () {
            Route::get('/customer-dashboard', 'customerDashboard')->name('customer.dashboard');
            Route::get('/customer-logout', 'userLogout')->name('customer.logout');
            // Route::post('/check-user-status', 'checkUserStatus');
            Route::get('/customer-profile', 'userProfile')->name('customer.profile');
            Route::get('/customer-orders', 'userOrders')->name('customer.orders');
            Route::get('/customer-addresses', 'userAddresses')->name('customer.addresses');
            Route::get('/customer-downloads', 'userDownloads')->name('customer.downloads');
            Route::post('/customer-update-billing', 'updateBillingAddress')->name('customer.update.billing.address');
            Route::get('/fetch-billing-address', 'fetchBillingAddress')->name('customer.fetch.billing.address');
            Route::post('/customer-update-shipping', 'updateShippingAddress')->name('customer.update.shipping.address');
            Route::get('/fetch-shipping-address', 'fetchShippingAddress')->name('customer.fetch.shipping.address');
            

            Route::post('/customer-update-profile-photo', 'updateProfilePhoto')->name('customer.update.profile.photo');
            Route::post('/customer-update-password', 'updateCustomerPassword')->name('customer.update.password');
            Route::post('/customer-update-details', 'updateDetails')->name('customer.update.details');

            //order items 
            Route::get('/customer-order-details/{order_no}/', 'OrderItems')->name('customer.order.items');

        });
    
        //wishlist 
        Route::controller(WishlistController::class)->group(function(){
            Route::get('/customer-wishlist', 'ShopWishlist')->name('customer.wishlist');
            Route::get('/fetch-user-wishlist', 'ajaxWishlist')->name('fetch.user.wishlist');
            // Route::post('/store-wishlist', 'StoreWishlist')->name('wishlist.store');
            Route::post('/delete-wishlist', 'DeleteWishlist')->name('wishlist.delete');
            Route::post('/update-wishlist', 'updateWishlist')->name('wishlist.update');
        });
        
   
    });

    

    
});

Route::prefix('seller')->name('seller.')->group(function(){

    Route::middleware(['guest:seller'])->group(function () {
        Route::controller(SellerController::class)->group(function () {
            Route::get('/login-seller', 'sellerLogin')->name('vendor.login');
            Route::get('/register-seller', 'sellerRegister')->name('vendor.register');
            Route::post('/processs-login-seller', 'sellerLoginProcess')->name('vendor.process.login');
            Route::post('/processs-register-seller', 'sellerRegisterProcess')->name('vendor.register.process');
            Route::get('/success-seller', 'sellerRegisterSuccess')->name('vendor.registeration.success');
             
            Route::post('/check-shop-name', 'checkShopName')->name('vendor.check.shopname');
            Route::get('/seller-email-verify', 'VerifyEmail')->name('vendor.email.verify');
            Route::get('/seller-invalid-token', 'invalidToken')->name('vendor.invalidtoken');

            Route::get('/seller-logout', 'sellerLogout')->name('vendor.logout');


         });
        
        });

        Route::middleware(['auth:seller', 'is_user_seller', 'is_seller_email_verified'])->group(function () {
                Route::controller(SellerDashboardController::class)->group(function(){
                    Route::get('/seller-dashboard', 'sellerDashboard')->name('vendor.dashboard');
                    Route::get('/seller-businessInfo', 'bizInfo')->name('vendor.biz.info');
                    Route::post('/seller-business-info-process', 'processBizInfo')->name('vendor.biz.info.process');
                    Route::post('/get-state-city-biz', 'getStateCityBiz')->name('get.state.city.biz');
                    Route::get('/seller-productcategories', 'showProductCategoryPage')->name('vendor.product.category.page');
                    Route::get('/seller-brands', 'brandPage')->name('vendor.brands.page');

                });

                Route::controller(SellerController::class)->group(function () {
                    Route::get('/seller-logout', 'sellerLogout')->name('vendor.logout');
                    Route::get('/seller-profile', 'sellerProfile')->name('vendor.profile');
                    Route::post('/seller-update-details', 'updateSeller')->name('vendor.update.details');
                    Route::post('/seller-update-password', 'updateSellerPassword')->name('vendor.update.password');
                    Route::post('/seller-update-profile-photo', 'updateSellerPhoto')->name('vendor.update.profile.photo');
        
                 });

                 Route::controller(SellerProductCategoryController::class)->group(function(){
                    Route::get('/seller-pcategory-list', 'ListPCategories')->name('vendor.list.products.categories');
                    Route::post('/seller-pcategory-add', 'addPcategory')->name('vendor.add.product.category');
                    Route::get('/generate-pcategory-slugurl', 'GenerateProductCategorySlugUrl')->name('vendor.generate.product.category.slugurl');
                    Route::get('/seller-pcategory-edit/{id}', 'EditPcategory')->name('vendor.edit.product.category');
                    Route::post('/seller-pcategory-update', 'updatePcategory')->name('vendor.update.product.category');
                    Route::post('/seller-pcategory-active', 'activePcategory')->name('vendor.active.product.category');
                    Route::post('/seller-pcategory-inactive', 'inactivePcategory')->name('vendor.inactive.product.category');
                    Route::post('/seller-pcategory-delete', 'deletePcategory')->name('vendor.delete.product.category');
                    Route::post('/seller-pcategory-image-delete', 'deletePcategoryImage')->name('vendor.delete.product.category.image');
                    Route::post('/tmp-upload-category', 'tmpUploadCategory');
                    Route::delete('/tmp-revert-category', 'tmpDeleteCategory');
        
                    Route::post('/seller-pcategory-top', 'topPcategory')->name('vendor.top.product.category');
                    Route::post('/seller-pcategory-regular', 'regularPcategory')->name('vendor.regular.product.category');
        
                });
        
                // product route
                Route::controller(SellerProductController::class)->group(function () {
                    Route::get('/seller-products-page', 'productPage')->name('vendor.products.page');
                    Route::get('/seller-add-product-page', 'productAddPage')->name('vendor.add.product.page');
                    Route::post('/seller-process-product-create', 'processProductCreate')->name('vendor.process.product.create');
                    Route::get('/generate-product-slugurl', 'GenerateProductSlugUrl')->name('vendor.generate.product.slugurl');
                    Route::get('/seller-product-edit/{unique_key}', 'EditProduct')->name('vendor.edit.product');
                    Route::post('/seller-product-update', 'updateProduct')->name('vendor.update.product');
                    Route::post('/seller-product-detail', 'productDetail')->name('vendor.detail.product');
                    Route::post('/seller-product-status', 'productStatus')->name('vendor.toggle.status.product');
                    Route::post('/seller-product-delete', 'deleteProduct')->name('vendor.delete.product');
                    Route::post('/seller-product-image-delete', 'deleteProductImage')->name('vendor.delete.product.image');
                    Route::post('/seller-product-image-create', 'processProductCreateImage')->name('vendor.add.product.image');
                    Route::post('/seller-get-child-cat', 'getChildCategory');
                    Route::get('/seller-child-cat', 'ChildCategory')->name('get.product.child.cat');
        
        
                    Route::get('/seller-colors', 'colorsPage')->name('vendor.page.colors');
                    Route::get('/seller-sizes', 'sizesPage')->name('vendor.page.sizes');
                    Route::get('/seller-conditions', 'conditionPage')->name('vendor.page.conditions');
        
        
                    Route::get('/seller-sizes-list', 'ListSizes')->name('vendor.list.sizes');
                    Route::post('/seller-size-add', 'addSizes')->name('vendor.add.sizes');
        
                    Route::get('/seller-colors-list', 'ListColors')->name('vendor.list.colors');
                    Route::post('/seller-colors-add', 'addColors')->name('vendor.add.colors');
        
                    Route::get('/seller-conditions-list', 'ListConditions')->name('vendor.list.conditions');
                    Route::post('/seller-conditions-add', 'addConditions')->name('vendor.add.conditions');
        
                    Route::post('/tmp-upload-product', 'tmpUploadProduct')->name('tmp.product.upload');
                    Route::delete('/tmp-revert-product', 'tmpDeleteProduct')->name('tmp.product.delete');
        
                    Route::post('/seller-product-featured', 'productFeatured')->name('vendor.toggle.featured.product');
        
                    Route::post('/seller-process-product-create-more-images', 'processProductCreateMoreImages')->name('vendor.upload.more.images');
        
                    //add product attribute route
                    Route::get('/seller-product-attributes/{uniquekey}', 'productAttributePage')->name('vendor.add.product.attribute');
        
                    //get stock size
                    Route::post('/seller-product-attributes-add', 'processProductAttribute')->name('vendor.attributes.add');
                    Route::get('/seller-product-attributes-fetch', 'fetchProductAttribute')->name('vendor.attributes.fetch');
                    Route::post('/seller-product-attributes-delete', 'deleteProductAttribute')->name('vendor.attributes.delete');
                    Route::post('/seller-product-attributes-edit', 'editProductAttribute')->name('vendor.attributes.edit');
        
                    //add product information route
                    Route::get('/seller-product-information/{uniquekey}', 'productInformationPage')->name('vendor.product.information');
                    //product additional information 
                    Route::post('/seller-product-information-add', 'processProductInformation')->name('vendor.information.add');
                    Route::get('/seller-product-information-fetch', 'fetchProductInformation')->name('vendor.information.fetch');
                    Route::post('/seller-product-information-delete', 'deleteProductInformation')->name('vendor.information.delete');
                    Route::post('/seller-product-information-edit', 'editProductInformation')->name('vendor.information.edit');
        
        
        
        
                });
        
                  // brand route
                  Route::controller(SellerBrandController::class)->group(function () {
                    Route::get('/seller-brand-list', 'ListBrands')->name('vendor.list.brand');
                    Route::post('/seller-brand-add', 'addBrand')->name('vendor.add.brand');
                    Route::get('/generate-brand-slugurl', 'GenerateBrandSlugUrl')->name('vendor.generate.brand.slugurl');
                    Route::get('/seller-brand-edit/{id}', 'EditBrand')->name('vendor.edit.brand');
                    Route::post('/seller-brand-update', 'updateBrand')->name('vendor.update.brand');
                    Route::post('/seller-brand-active', 'activateBrand')->name('vendor.active.brand');
                    Route::post('/seller-brand-inactive', 'deactivateBrand')->name('vendor.inactive.brand');
                    Route::post('/seller-brand-delete', 'deleteBrand')->name('vendor.delete.brand');
                    Route::post('/seller-brand-image-delete', 'deleteBrandImage')->name('vendor.delete.brand.image');
                    Route::post('/tmp-upload-brand', 'tmpUploadBrand');
                    Route::delete('/tmp-revert-brand', 'tmpDeleteBrand');
                });
        
                      //coupon route
                Route::controller(SellerCouponController::class)->group(function () {
                    Route::get('/seller-coupon-page', 'showCouponPage')->name('vendor.coupon.page');
                    Route::post('/seller-coupon-status', 'couponStatus')->name('vendor.toggle.status.coupon');
                    Route::get('/seller-coupon-list', 'ListCoupon')->name('vendor.list.coupon');
                    Route::post('/seller-coupon-add', 'addCoupon')->name('vendor.add.coupon');
                    Route::post('/seller-coupon-delete', 'deleteCoupon')->name('vendor.delete.coupon');
                    Route::get('/seller-coupon-edit', 'editCoupon')->name('vendor.edit.coupon');
                    Route::get('/generate-coupon-code', 'GenerateCouponCode')->name('vendor.generate.coupon.code');
                    Route::post('/seller-coupon-type', 'couponType')->name('vendor.toggle.type.coupon');
        
            
            
                });
       
                Route::controller(SellerOrderController::class)->group(function(){
                    Route::get('/seller-orders', 'orderPage')->name('vendor.orders');
                    Route::get('/seller-order-details/{orderId}', 'orderItems')->name('vendor.order.items');
                    Route::post('/seller-update-order-status', 'updateOrderStatus')->name('vendor.update.order.status');
                    Route::post('/seller-get-order-status', 'getOrderStatus')->name('vendor.get.order.status');
                    Route::post('/seller-delete-order', 'deleteOrder')->name('vendor.delete.order');
                });
                
        });
    
    });

   
Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


