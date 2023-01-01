<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
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
    public function index(){
        Session::put('pagetitle', 'Cart');
        $cartitems = Cart::getCartItems();
        $numberOfCartItem = count($cartitems);
        Session::put('numberOfCartItem', $numberOfCartItem);
        return view('frontend.cart', ['cartitems'=>$cartitems]);
    }
    public function store(Request $request, $id){

        $cartitems = Cart::getCartItems();
        Session::put('pagetitle', 'Cart');
        $numberOfCartItem = count($cartitems);
        Session::put('numberOfCartItem', $numberOfCartItem);

        if(empty($request->size) || empty($request->quantity)){
            return back()->with('error_msg', "Size and Quantity Required !");
        }
        if($request->quantity < 1){
            $request->quantity = 1;
        }
        $request->size = Crypt::decryptString($request->size);
        // check that, product already added or not
        $alreadyaddedproduct = Cart::where(['products_id'=> $id, 'attributes_id' => $request->size])->get();
        if(count($alreadyaddedproduct) > 0){
            return back()->with('error_msg', 'This product Already Added !');
        }
        // check that, product stock has or not
        $productAttr = ProductsAttribute::where(["products_id" => $id, 'id' => $request->size])->first();
        if($productAttr->stock < $request->quantity){
            return back()->with('error_msg', 'Desire quantity is not available !');
        }

        // // check that, the attribute valid or not
        // if(count($productAttr) < 1){
        //     return back()->with('error_msg', "Invalid Size !");
        // }

        if(Auth::check()){
            Session::forget('session_id');
            $session_id = 0;
            $user_id = Auth::id();
        }else{
            $user_id = 0;
            if(Session::has('session_id')){
                $session_id = Session::get('session_id');
            }else{
                Session::put('session_id',Session::getId());
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
        if($cart->save()){
            return back()->with('success_msg', 'Added to cart Successfully !');
        }
        return back()->with('error_msg', 'Something Error, Plese try again letter!');
    }

    public function update(Request $request){
        $did = Crypt::decryptString($request->id);
        $cart = Cart::find($did);
        $stock = ProductsAttribute::select('stock')->where(['id' => $cart->attributes_id])->first();
        $stock = $stock->stock;
        if($request->quantity <= $stock){
            $cart->quantity = $request->quantity;
            $cart->save();
            $status = true;
            $message = 'Cart Updated !';
            $cartitems = Cart::getCartItems();
            $html = view('frontend.cart_ajax')->with(['cartitems' => $cartitems])->render();
            return ['html' => $html, 'status' => $status, 'message' => $message];
        }else{
            $cart->quantity = $stock;
            $cart->save();
            $status = false;
            $message = 'Stock unavailable as your request !';
            $cartitems = Cart::getCartItems();
            $html = view('frontend.cart_ajax')->with(['cartitems' => $cartitems])->render();
            return ['html' => $html, 'status' => $status, 'message' => $message];
        }
    }

    public function delete(Request $request){
        $did = Crypt::decryptString($request->id);
        Cart::destroy($did);
        $cartitems = Cart::getCartItems();
        $status = true;
        $message = 'Cart Deleted !';
        $html = view('frontend.cart_ajax')->with(['cartitems' => $cartitems])->render();
        return ['html' => $html, 'status' => $status, 'message' => $message];
    }
}
