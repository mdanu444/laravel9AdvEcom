<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandsController;
use App\Http\Controllers\Admin\ProductsAttributeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\ProductSectionController;
use App\Http\Controllers\Admin\ProductSubCategoryController;
use App\Http\Controllers\Frontend\Index;
use App\Http\Controllers\Frontend\ProductDetails;
use App\Http\Controllers\ProductCategoryController;
use App\Models\Admin\Banner;
use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\ProductSection;
use App\Models\Admin\ProductSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

Route::name('frontend.')->group(function () {
    Route::get('/', [Index::class, 'index'])->name('index');
    Route::match(['get', 'post'], 'c/{cat_link}', [Index::class, 'category'])->name('category');
    Route::match(['get', 'post'], 's/{sub_link}', [Index::class, 'subcat'])->name('subcat');
    Route::get('/details/{id}', [ProductDetails::class, 'index'])->name('product_details');
    Route::post('/getpricebysize', [ProductDetails::class, 'getpricebysize'])->name('getpricebysize');
});


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
        Route::resource('product', ProductController::class);
        Route::post('/getsubcategorybysection', [ProductController::class, 'getsubcategorybysection'])->name('getsubcategorybysection');
        Route::resource('product/{product}/p_attribute', ProductsAttributeController::class);
        Route::resource('product/{product}/p_image', ProductImageController::class);
    });
});
