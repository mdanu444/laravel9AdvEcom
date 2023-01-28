<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function orders(){
        return 'orders';
    }

    // store order details
    public function placeorder(Request $request){
        $request->validate([
            'address' => 'required',
            'payment_method' => 'required'
        ]);

        $shipping_address_id = Crypt::decryptString($request->address);
        $payment_method = $request->payment_method;

        // Create Order Table
        $coupon_code = Session::get('coupon_code') ? Session::get('coupon_code') : 0;
        $coupon_amount = Session::get('coupon_amount') ? Session::get('coupon_amount') : 0;
        $grandTotal = Session::get('grandTotal') ? Session::get('grandTotal') : 0;

        return ['session' => Session::all()];
        Session::forget('coupon_code');
        Session::forget('coupon_amount');
        Session::forget('grandTotal');
    }
}
