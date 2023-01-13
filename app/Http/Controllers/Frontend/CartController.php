<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin\Coupon;
use App\Models\Admin\Product;
use App\Models\Admin\ProductsAttribute;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class CartController extends Controller
{
    public function index()
    {
        $coupon = 0;
        $coupon_amount_type = "";
        Session::put('pagetitle', 'Cart');
        $cartitems = Cart::getCartItems();
        $numberOfCartItem = count($cartitems);
        $coupone = 0;
        Session::put('numberOfCartItem', $numberOfCartItem);
        return view('frontend.cart', ['cartitems' => $cartitems, 'coupon' => $coupon, 'coupon_amount_type' => $coupon_amount_type]);
    }
    public function store(Request $request, $id)
    {

        $cartitems = Cart::getCartItems();
        Session::put('pagetitle', 'Cart');
        $numberOfCartItem = count($cartitems);
        Session::put('numberOfCartItem', $numberOfCartItem);

        if (empty($request->size) || empty($request->quantity)) {
            return back()->with('error_msg', "Size and Quantity Required !");
        }
        if ($request->quantity < 1) {
            $request->quantity = 1;
        }
        $request->size = Crypt::decryptString($request->size);

        // check that, product already added or not
        if (Auth::check()) {
            $alreadyaddedproduct = Cart::where(['products_id' => $id, 'attributes_id' => $request->size, 'users_id' => Auth::id()])->get();
            if (count($alreadyaddedproduct) > 0) {
                return back()->with('error_msg', 'This product Already Added !');
            }
        } else {
            $alreadyaddedproduct = Cart::where(['products_id' => $id, 'attributes_id' => $request->size, 'session_id' => Session::get('session_id')])->get();
            if (count($alreadyaddedproduct) > 0) {
                return back()->with('error_msg', 'This product Already Added !');
            }
        }
        // check that, product stock has or not
        $productAttr = ProductsAttribute::where(["products_id" => $id, 'id' => $request->size])->first();
        if ($productAttr->stock < $request->quantity) {
            return back()->with('error_msg', 'Desire quantity is not available !');
        }

        // // check that, the attribute valid or not
        // if(count($productAttr) < 1){
        //     return back()->with('error_msg', "Invalid Size !");
        // }

        if (Auth::check()) {
            Session::forget('session_id');
            $session_id = 0;
            $user_id = Auth::id();
        } else {
            $user_id = 0;
            if (Session::has('session_id')) {
                $session_id = Session::get('session_id');
            } else {
                Session::put('session_id', Session::getId());
                $session_id = Session::get('session_id');
            }
        }
        $cart = new Cart();
        $cart->session_id = $session_id;
        $cart->users_id = $user_id;
        $cart->products_id = $id;
        $cart->quantity = $request->quantity;
        $cart->price = $productAttr->price;
        $cart->attributes_id = $productAttr->id;
        if ($cart->save()) {
            $cartitems = Cart::getCartItems();
            $numberOfCartItem = count($cartitems);
            Session::put('numberOfCartItem', $numberOfCartItem);
            return back()->with('success_msg', 'Added to cart Successfully !');
        }
        return back()->with('error_msg', 'Something Error, Plese try again letter!');
    }

    public function update(Request $request)
    {
        $coupon = 0;
        $coupon_amount_type = "";
        if(isset($request->code) && !empty($request->code)){
            $coupon_items = Coupon::where('code', $request->code)->get();

            if(count($coupon_items) > 0){

                // validation start

                // status_validation
                if($coupon_items[0]->status == 0){
                    $status = false;
                    $message = 'Coupon disabled !';
                    return  ['status' => $status, 'message' => $message];
                }
                // expiry_validation
                if($coupon_items[0]->status == 1){
                    // expiry date should bigger then now
                    $expiry_date = $coupon_items[0]->expiry_date;
                    $current_date = date('Y-m-d');
                    if($expiry_date < $current_date){
                        $status = false;
                        $message = 'Coupon Expired !';
                        return  ['status' => $status, 'message' => $message];
                    }
                }
                // user_validation
                if($coupon_items[0]->status == 1){
                    $coupone_users_array = Coupon::getStrToArr($coupon_items[0]->users);

                    if(!in_array(Auth::id(), $coupone_users_array)){
                        $status = false;
                        $message = 'This coupone created for enother user !';
                        return  ['status' => $status, 'message' => $message];
                    }
                }

                // category_validation
                if($coupon_items[0]->status == 1){
                    $categories = Coupon::getStrToArr($coupon_items[0]->categories);
                    $subcategories = Coupon::getStrToArr($coupon_items[0]->subcategories);
                    $cartitems = Cart::getCartItems();
                    foreach($cartitems as $cart){
                        $category_id = $cart->product->product_categories_id;
                        if(!in_array($category_id,$categories)){
                            $status = false;
                            $message = 'This coupon is not for one of selected products !';
                            return  ['status' => $status, 'message' => $message];
                        }
                    }
                }
                // subcategory_validation
                if($coupon_items[0]->status == 1){
                    $subcategories = Coupon::getStrToArr($coupon_items[0]->subcategories);
                    $cartitems = Cart::getCartItems();
                    foreach($cartitems as $cart){
                        $subcategory_id = $cart->product->product_sub_categories_id;
                        if($subcategory_id != 0){
                            if(!in_array($subcategory_id,$subcategories)){
                                $status = false;
                                $message = 'This coupon is not for one of selected products !';
                                return  ['status' => $status, 'message' => $message];
                            }
                        }
                    }
                }

                // validation end



                $coupon =$coupon_items[0]->amount;
                $coupon_amount_type =$coupon_items[0]->amount_type;
                $status = true;
                $message = 'Cart Updated !';
                $cartitems = Cart::getCartItems();
                $html = view('frontend.cart_ajax')->with(['cartitems' => $cartitems, 'coupon' => $coupon, 'coupon_amount_type' => $coupon_amount_type])->render();
                return ['html' => $html, 'status' => $status, 'message' => $message];
            }else{
                $status = false;
                $message = 'Coupon not found !';
                $cartitems = Cart::getCartItems();
                $html = view('frontend.cart_ajax')->with(['cartitems' => $cartitems, 'coupon' => $coupon, 'coupon_amount_type' => $coupon_amount_type])->render();
                return ['html' => $html, 'status' => $status, 'message' => $message];
            }
        }
        $did = Crypt::decryptString($request->id);
        $cart = Cart::find($did);
        $stock = ProductsAttribute::select('stock')->where(['id' => $cart->attributes_id])->first();
        $stock = $stock->stock;
        if ($request->quantity <= $stock) {
            $cart->quantity = $request->quantity;
            $cart->save();
            $status = true;
            $message = 'Cart Updated !';
            $cartitems = Cart::getCartItems();
            $html = view('frontend.cart_ajax')->with(['cartitems' => $cartitems, 'coupon' => $coupon, 'coupon_amount_type' => $coupon_amount_type])->render();
            return ['html' => $html, 'status' => $status, 'message' => $message];
        } else {
            $cart->quantity = $stock;
            $cart->save();
            $status = false;
            $message = 'Stock unavailable as your request !';
            $cartitems = Cart::getCartItems();
            $html = view('frontend.cart_ajax')->with(['cartitems' => $cartitems, 'coupon' => $coupon, 'coupon_amount_type' => $coupon_amount_type])->render();
            return ['html' => $html, 'status' => $status, 'message' => $message];
        }
    }

    public function delete(Request $request)
    {
        $coupon = 0;
        $coupon_amount_type = "";
        $did = Crypt::decryptString($request->id);
        Cart::destroy($did);
        $cartitems = Cart::getCartItems();
        $status = true;
        $message = 'Cart Deleted !';
        $html = view('frontend.cart_ajax')->with(['cartitems' => $cartitems, 'coupon' => $coupon, 'coupon_amount_type' => $coupon_amount_type])->render();
        return ['html' => $html, 'status' => $status, 'message' => $message];
    }
}
