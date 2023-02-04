<?php

namespace App\Http\Controllers;

use App\Models\Admin\OrderStatus;
use App\Models\Admin\OrderStatusLog;
use App\Models\Admin\ProductsAttribute;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{

    public function orders(){
        Session::put('pagetitle', 'Orders');
        $orders = Order::where('user_id', Auth::id())->with('order_items')->orderBy('id', 'desc')->get();
        return view('frontend.order', ['orders' => $orders]);
    }

    // store order details
    public function placeorder(Request $request){
        $request->validate([
            'address' => 'required',
            'payment_method' => 'required'
        ]);
        $cartItems = Cart::getCartItems();

        // check cart item has or not
        if(count($cartItems) < 1){
            return redirect()->back()->with('error_msg', "You do not have checkout any product !");
        }
        $shipping_address_id = Crypt::decryptString($request->address);
        $payment_method = $request->payment_method;

        // Create Order Table
        $coupon_code = Session::get('coupon_code') ? Session::get('coupon_code') : 0;
        $coupon_amount = Session::get('coupon_amount') ? Session::get('coupon_amount') : 0;
        $grandTotal = Session::get('grandTotal') ? Session::get('grandTotal') : 0;

        if($payment_method == "COD"){
            $payment_gateway = "COD";
        }
        if($payment_method == "Prepaid"){
            $payment_gateway = "paypal";
        }

        $order = New Order();
        $order->name = Auth::user()->name;
        $order->user_id = Auth::id();
        $order->shipping_charge = 0;
        $order->shipping_address = $shipping_address_id;
        $order->coupon_code = $coupon_code;
        $order->coupon_amount = $coupon_amount;
        $order->order_status = 'New Order';
        $order->payment_method = $payment_method;
        $order->payment_gateway = $payment_gateway;
        $order->grand_total = $grandTotal;

        if($order->save()){
            foreach($cartItems as $item){
                $orderItem = New OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->user_id = Auth::id();
                $orderItem->product_id = $item->products_id;


                $attribute = ProductsAttribute::find($item->attributes_id);
                $orderItem->product_code = $attribute->sku;
                $orderItem->product_name = $item->product->title;
                $orderItem->product_color = $item->product->color;


                $orderItem->product_size = $attribute->size;
                $orderItem->product_price = $item->price;
                $orderItem->product_quantity = $item->quantity;
                if($orderItem->save()){
                    Cart::destroy($item->id);
                    $attribute->stock = $attribute->stock - $item->quantity;
                    $attribute->save();
                    $orderStatusLog = new OrderStatusLog();
                    $orderStatusLog->orders_id =$order->id;
                    $orderStatusLog->status ="New Order";
                }
            }
            Session::forget('coupon_code');
            Session::forget('coupon_amount');
            Session::forget('grandTotal');
            Session::forget('numberOfCartItem');
            return redirect()->back()->with('success_msg', 'Your order id is # '.$order->id.'. Please stay with us, Thank you !');
        }
        return redirect()->back()->with('error_msg', 'Something error, Please try again !');
    }

    // admin order list show
    public function adminorder(){
        Session::put('pageTitle', 'Product');
        Session::put('activer', 'Order List');
        $orders = Order::with('users')->get();
        return view('admin.product.order.index', ['data' => $orders]);
    }
    public function adminorderdetails($id){
        Session::put('pageTitle', 'Product');
        Session::put('activer', 'Order List');
        $orders = Order::with('users', 'order_items', 'shipping')->findOrFail($id);
        $statuses = OrderStatus::where('status', 1)->orderBy('order_number', 'asc')->get();
        $statuslogs = OrderStatusLog::where('orders_id', $id)->orderBy('id', 'desc')->get();
        $previouslogs = count($statuslogs) > 1 ? $statuslogs[1]->status :  'None';
        $updatedLogsArray = OrderStatusLog::where('orders_id', $id)->select('status')->get();
        $logsArray = Array();
        foreach($updatedLogsArray as $log){
            $logsArray[] = $log->status;
        }
        $logsArray;
        // order item has product and product has image
        return view('admin.product.order.show', ['data' => $orders, 'statuses' => $statuses, 'statuslogs' => $statuslogs, 'previouslog' => $previouslogs, 'updatedLogsArray' => $logsArray]);
    }

    public function updateorderstatus(Request $request, $id){
        $request->validate(['order_status' => "required"]);
        if($request->order_status == "Shipped"){
            $request->validate([
                'courier_name' => 'required',
                'tracking_number' => 'required',
                'shipping_charge' => 'required'
            ],[
                'courier_name' => 'Courier Name is required!',
                'tracking_number' => 'Tracking Numbe is required!',
                'shipping_charge' => 'Shipping Charge is required!'
            ]);
        }
        $order = Order::findOrFail($id);
        $order->order_status = $request->order_status;
        $order->courier_name = $request->courier_name;
        $order->tracking_number = $request->tracking_number;
        $order->shipping_charge = $request->shipping_charge;
        if($order->save()){

        // validated already this update done or not
        $oldOrderStatusLog = OrderStatusLog::where('orders_id', $id)->where('status', $request->order_status)->get();
        if(count($oldOrderStatusLog) == 0){
            $log = new OrderStatusLog();
            $log->orders_id = $id;
            $log->status = $request->order_status;
            $log->save();
            return redirect()->back()->with('message', 'Order Updated !');
        }
        }
        return redirect()->back()->with('message', 'Order does not update, please try again !');
    }
}
