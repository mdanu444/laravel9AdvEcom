<?php

use App\Http\Controllers\AddressAjaxController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandsController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ProductsAttributeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\ProductSectionController;
use App\Http\Controllers\Admin\ProductSubCategoryController;
use App\Http\Controllers\BkashController;
use App\Http\Controllers\Frontend\Index;
use App\Http\Controllers\Frontend\ProductDetails;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\InsertDataController;
use App\Http\Controllers\NagadController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\RocketController;
use App\Http\Controllers\ShippingChargeController;
use App\Http\Controllers\SSLCommerzController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Models\Admin\Banner;
use App\Models\Admin\Coupon;
use App\Models\Admin\OrderStatus;
use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\ProductSection;
use App\Models\Admin\ProductSubCategory;
use App\Models\District;
use App\Models\Division;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
// SSLCommerz

//Route::get('/payment/{SSLCommerz}/SSLCommerz', [SSLCommerzController::class, 'index']);

// SSLCOMMERZ Start
//Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2/{SSLCommerz}', [SslCommerzPaymentController::class, 'exampleHostedCheckout'])->name('frontend.SSLCommerz.index');

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END


// // for frontend start from here
Route::middleware(['cartCleaner', 'PreventBackHistory'])->name('frontend.')->group(function () {
    Route::get('/', [Index::class, 'index'])->name('index');
    Route::match(['get', 'post'], 'c/{cat_link}', [Index::class, 'category'])->name('category');
    Route::match(['get', 'post'], 's/{sub_link}', [Index::class, 'subcat'])->name('subcat');
    Route::get('/details/{id}', [ProductDetails::class, 'index'])->name('product_details');
    Route::post('/getpricebysize', [ProductDetails::class, 'getpricebysize'])->name('getpricebysize');
    Route::post('/cart/{id}', [CartController::class, 'store'])->name('cart.store');
    Route::get('/carts', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart_update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart_delete', [CartController::class, 'delete'])->name('cart.delete');
    Route::post('/emailunickness', [UserController::class, 'emailunickness'])->name('user.emailunickness');

    // user login and registration
    Route::group(['middleware' => ['guest:web']], function(){
        Route::get('/forgotpassview', [UserController::class, 'forgotpassview'])->name('user.forgotpassview');
        Route::post('/forgotpass', [UserController::class, 'forgotpass'])->name('user.forgotpass');
        Route::post('/login', [UserController::class, 'login'])->name('user.login');
        Route::get('/logreg', [UserController::class, 'index'])->name('logreg.index');
        Route::post('/register', [UserController::class, 'register'])->name('user.register');
        Route::get('/accountverify/{id}', [UserController::class, 'accountverify'])->name('user.accountverify');
        // for sms
        Route::post('/varification', [UserController::class, 'varification'])->name('user.varification');
        Route::get('/varificationview', [UserController::class, 'varificationview'])->name('user.varificationview');
    });
    Route::group(['middleware' => ["auth:web"]], function(){
        Route::put('/updateuser', [UserController::class, 'updateuser'])->name('user.updateuser');
        Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');
        Route::get('/account', [UserController::class, 'account'])->name('user.account');

        Route::get('/addnewshippingaddress', [UserController::class, 'addnewshippingaddress'])->name('user.addnewshippingaddress');
        Route::post('/addnewshippingaddress', [UserController::class, 'storeshippingaddress'])->name('user.storeshippingaddress');
        Route::get('/addnewshippingaddress/{id}/edit', [UserController::class, 'editshippingaddress'])->name('user.addnewshippingaddress.edit');
        Route::put('/addnewshippingaddress/{id}', [UserController::class, 'updateshippingaddress'])->name('user.addnewshippingaddress.update');
        Route::get('/addnewshippingaddress/{id}/delete', [UserController::class, 'deleteshippingaddress'])->name('user.addnewshippingaddress.delete');

        Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
        Route::get('/orderdetails/{id}', [OrderItemController::class, 'orderdetails'])->name('orderdetails');
        Route::post('/placeorder', [OrderController::class, 'placeorder'])->name('placeorder');

        Route::post('/checkpass', [UserController::class, 'checkpass'])->name('user.checkpass');
        Route::put('/updatepassword', [UserController::class, 'updatepassword'])->name('user.updatepassword');
        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
        Route::post('/Updatecheckout', [CartController::class, 'UpdateCheckout'])->name('UpdateCheckout');

        // paypal
        Route::get('/payment/{paypal}/paypal', [PaypalController::class, 'index'])->name('paypal.index');
        Route::get('/payment/{paypal}/success', [PaypalController::class, 'success'])->name('paypal.success');
        Route::get('/payment/{paypal}/cancel', [PaypalController::class, 'cancel'])->name('paypal.cancel');

        // bkash
        Route::get('/payment/{bkash}/bkash', [BkashController::class, 'index'])->name('bkash.index');
        Route::get('/payment/{bkash}/success', [BkashController::class, 'success'])->name('bkash.success');
        Route::get('/payment/{bkash}/cancel', [BkashController::class, 'cancel'])->name('bkash.cancel');

        // Nagad
        Route::get('/payment/{nagad}/nagad', [NagadController::class, 'index'])->name('nagad.index');
        Route::get('/payment/{nagad}/success', [NagadController::class, 'success'])->name('nagad.success');
        Route::get('/payment/{nagad}/cancel', [NagadController::class, 'cancel'])->name('nagad.cancel');
    });

});

Route::post('/districts', [AddressAjaxController::class, 'districts']);
Route::post('/upazilas', [AddressAjaxController::class, 'upazilas']);

// for admin panel start from here
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('frontend.index');
    });
    Route::middleware(['guest:admin', 'PreventBackHistory'])->group(function () {
        Route::view('/login', 'admin.login')->name('login');
        Route::post('/login', [AdminController::class, 'check'])->name('check');
        Route::view('/register', 'admin.register')->name('register');
        Route::post('/register', [AdminController::class, 'save'])->name('save');
    });



    Route::middleware(['auth:admin', 'PreventBackHistory'])->group(function () {
        Route::post('/statuschanger', function (Request $request) {
            if ($request->status == "productsection") {
                $item = ProductSection::findOrfail($request->id);
                if ($item->status == 1) {
                    $item->status = 0;
                } else {
                    $item->status = 1;
                }
                $item->save();
                return ['status' => true];
            }
            if ($request->status == "productcategory") {
                $item = ProductCategory::findOrfail($request->id);
                if ($item->status == 1) {
                    $item->status = 0;
                } else {
                    $item->status = 1;
                }
                $item->save();
                return ['status' => true];
            }
            if ($request->status == "order_status") {
                $item = OrderStatus::findOrfail($request->id);
                if ($item->status == 1) {
                    $item->status = 0;
                } else {
                    $item->status = 1;
                }
                $item->save();
                return ['status' => true];
            }
            if ($request->status == "productsubcategory") {
                $item = ProductSubCategory::findOrfail($request->id);
                if ($item->status == 1) {
                    $item->status = 0;
                } else {
                    $item->status = 1;
                }
                $item->save();
                return ['status' => true];
            }
            if ($request->status == "product") {
                $item = Product::findOrfail($request->id);
                if ($item->status == 1) {
                    $item->status = 0;
                } else {
                    $item->status = 1;
                }
                $item->save();
                return ['status' => true];
            }
            if ($request->status == "banner") {
                $item = Banner::findOrfail($request->id);
                if ($item->status == 1) {
                    $item->status = 0;
                } else {
                    $item->status = 1;
                }
                $item->save();
                return ['status' => true];
            }
            if ($request->status == "coupons") {
                $item = Coupon::findOrfail($request->id);
                if ($item->status == 1) {
                    $item->status = 0;
                } else {
                    $item->status = 1;
                }
                $item->save();
                return ['status' => true];
            }
        });


        Route::get('/logout', function () {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login');
        })->name('logout');

        Route::get('/home', function () {
            Session::put('pageTitle', 'Home');
            Session::put('activer', 'home');
            return view('admin.home');
        })->name('home');

        Route::get('/profile/password', function () {
            Session::put('pageTitle', 'Profile');
            Session::put('activer', 'Change Password');
            return view('admin.profile.profile-changePassword');
        })->name('profile.changePassword');

        Route::put('/profile/password', [AdminController::class, 'changepse'])->name('profile.updatepsw');

        Route::get('/profile/update', [AdminController::class, 'profileview'])->name('profile.update');
        Route::put('/profile/update', [AdminController::class, 'profileupdater'])->name('profile.updater');

        // Product Catelogues
        Route::resource('/productsections', ProductSectionController::class);
        Route::resource('/productcategory', ProductCategoryController::class);
        Route::resource('/productsubcategory', ProductSubCategoryController::class);
        Route::post('/getcategorybysection', [ProductSubCategoryController::class, 'getcategorybysection'])->name('getcategorybysection');
        Route::resource('productbrands', BrandsController::class);
        Route::resource('banner', BannerController::class);
        Route::resource('coupons', CouponController::class);
        Route::resource('product', ProductController::class);
        Route::post('/getsubcategorybysection', [ProductController::class, 'getsubcategorybysection'])->name('getsubcategorybysection');
        Route::resource('product/{product}/p_attribute', ProductsAttributeController::class);
        Route::resource('product/{product}/p_image', ProductImageController::class);
        Route::get('/orders', [OrderController::class, 'adminorder'])->name('adminorder');
        Route::get('/orders/{id}', [OrderController::class, 'adminorderdetails'])->name('adminorderdetails');
        Route::put('/updateorderstatus/{id}', [OrderController::class, 'updateorderstatus'])->name('updateorderstatus');
        Route::resource('/order_status', OrderStatusController::class);
        Route::post('/updateStatusOrder', [OrderStatusController::class, 'updateStatusOrder']);
        Route::get('/shippingcharge', [ShippingChargeController::class, 'index'])->name('shippingcharge.index');
        Route::get('/shippingcharge/{id}/edit', [ShippingChargeController::class, 'edit'])->name('shippingcharge.edit');
        Route::put('/shippingcharge/{id}', [ShippingChargeController::class, 'update'])->name('shippingcharge.update');
    });
});

Route::get('orderinvoice/{id}', [OrderController::class, 'orderinvoicePrint'])->name('orderinvoicePrint');
Route::get('orderinvoice/{id}/download', [OrderController::class, 'orderinvoiceDownload'])->name('orderinvoiceDownload');

// Route::get('insertdata', [InsertDataController::class, 'insertData']);
// Route::get('insertShippingCharge', [ShippingChargeController::class, 'store']);
