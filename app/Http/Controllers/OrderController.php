<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orders(){
        return 'orders';
    }

    // store order details
    public function placeorder(Request $request){
        $request->validate([
            'address' => 'required',
            'payment_method'
        ]);
    }
}
