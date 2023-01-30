<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class OrderItemController extends Controller
{
    public function orderdetails($id){
        $did = Crypt::decryptString($id);
        $order = Order::with('shipping', 'order_items')->where('id', $did)->firstOrFail();
        Session::put('pagetitle', 'Order Details');
        return view('frontend.orderdetails', ['order' => $order]);
    }
}
