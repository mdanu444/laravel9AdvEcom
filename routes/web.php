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
use App\Http\Controllers\Frontend\Index;
use App\Http\Controllers\Frontend\ProductDetails;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCategoryController;
use App\Models\Admin\Banner;
use App\Models\Admin\Coupon;
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
        Route::post('/placeorder', [OrderController::class, 'placeorder'])->name('placeorder');

        Route::post('/checkpass', [UserController::class, 'checkpass'])->name('user.checkpass');
        Route::put('/updatepassword', [UserController::class, 'updatepassword'])->name('user.updatepassword');
        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
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
    });
});

Route::get('insertdata', function(){
    $data = array(
        array('id' => '1','name' => 'Chattagram','bn_name' => 'চট্টগ্রাম','url' => 'www.chittagongdiv.gov.bd'),
        array('id' => '2','name' => 'Rajshahi','bn_name' => 'রাজশাহী','url' => 'www.rajshahidiv.gov.bd'),
        array('id' => '3','name' => 'Khulna','bn_name' => 'খুলনা','url' => 'www.khulnadiv.gov.bd'),
        array('id' => '4','name' => 'Barisal','bn_name' => 'বরিশাল','url' => 'www.barisaldiv.gov.bd'),
        array('id' => '5','name' => 'Sylhet','bn_name' => 'সিলেট','url' => 'www.sylhetdiv.gov.bd'),
        array('id' => '6','name' => 'Dhaka','bn_name' => 'ঢাকা','url' => 'www.dhakadiv.gov.bd'),
        array('id' => '7','name' => 'Rangpur','bn_name' => 'রংপুর','url' => 'www.rangpurdiv.gov.bd'),
        array('id' => '8','name' => 'Mymensingh','bn_name' => 'ময়মনসিংহ','url' => 'www.mymensinghdiv.gov.bd')
      );
      if(count(Division::all()) < 1){
          DB::table('divisions')->insert($data);
      }
      return $data;
});
