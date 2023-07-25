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
use App\Http\Controllers\Superuser\ShippingMethodController;
use App\Http\Controllers\Superuser\SuperuserOrderController;


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

Route::controller(FrontPagesController::class)->group(function () {
    Route::get('/', 'Index')->name('home');
    Route::get('/category/{slug_url}', 'Category')->name('category.product');
    Route::get('/shop-mjstore-list', 'ShopList')->name('shop.list');
    Route::get('/product-details/{slug_url}', 'productDetails')->name('product.details');
    Route::get('/product-quick-view', 'productQuickview')->name('product.quickview.detail');
    Route::get('/products-category/{slug_url}', 'categoryProducts')->name('products.category');
    Route::get('/404-error', 'Error404')->name('404');
    Route::get('/shop-cart', 'ShopCart')->name('shop.cart');

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

    Route::middleware(['guest:seller', 'is_user_seller'])->group(function () {
        Route::controller(SellerController::class)->group(function () {
            Route::get('/login-seller', 'sellerLogin')->name('vendor.login');
            Route::get('/register-seller', 'sellerRegister')->name('seller.register');
            // Route::post('/processs-login-user', 'userLoginProcess')->name('user.login.process');
            // Route::post('/processs-register-user', 'userRegisterProcess')->name('user.register.process');
            // Route::get('/success-user', 'userRegisterSuccess')->name('user.register.success.page');
             
            // Route::post('/processs-login-user', 'userLoginProcess')->name('user.login.process');
            // Route::post('/processs-register-user', 'userRegisterProcess')->name('user.register.process');
            // Route::get('/success-user', 'userRegisterSuccess')->name('user.register.success.page');
            // Route::get('/user-email-verify', 'VerifyEmail')->name('user.email.verify');
            // Route::get('/user-invalid-token', 'invalidToken')->name('user.invalidtoken');

         });
        
        });

        Route::middleware(['auth:seller', 'is_user_seller'])->group(function () {
        
        });
    
    });

   
Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


