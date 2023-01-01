<?php

namespace App\Models;

use App\Models\Admin\Product;
use App\Models\Admin\ProductsAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Cart extends Model
{
    use HasFactory;

    public static function getdiscount($product_id){
        $discount = 0;
        $product = Product::select('id', 'product_sub_categories_id', 'product_categories_id','discount', 'price')->where('id', $product_id)->where('status', 1)->first();

        if($product->product_categories->discount > 0){
            $discount = $product->product_categories->discount;
        }
        if(!empty($product->product_sub_categories) && ($product->product_sub_categories->discount > 0)){
            $discount = $product->product_sub_categories->discount;
        }
        if($product->discount > 0){
            $discount = $product->discount;
        }
        return $discount;
    }

    public static function getCartItems(){
        if(Auth::check()){
            $user_id = Auth::id();
        }else{
            $user_id = 0;
        }
        if(Session::has('session_id')){
            $session_id = Session::get('session_id');
        }else{
            $session_id = 0;
        }
        $cartItems = Cart::select('id','price', 'products_id', 'quantity', 'attributes_id')->where(['session_id'=> $session_id, 'users_id' => $user_id])->get();
        return $cartItems;
    }

    public static function getCartProducts($product_id, $attribute_id){
        $cartProduct = [];
        $product = Product::select('id','title', 'code', 'color', 'price', 'image')->where('id',$product_id)->where('status', 1)->first();
        $cartProduct['product'] = $product;
        $attribute = ProductsAttribute::select('id', 'size', 'stock', 'sku')->where('id', $attribute_id)->first();
        $cartProduct['attribute'] = $attribute;
        $cartProduct['discount'] = Self::getdiscount($product_id);
        return $cartProduct;
    }
}
