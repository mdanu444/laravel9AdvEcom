<?php

namespace App\Http\Controllers;

use App\Models\Admin\OrderStatus;
use App\Models\Admin\OrderStatusLog;
use App\Models\Admin\ProductsAttribute;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Milon\Barcode\Facades\DNS2DFacade;

class OrderController extends Controller
{

    public function orders()
    {
        Session::put('pagetitle', 'Orders');
        $orders = Order::where('user_id', Auth::id())->with('order_items')->orderBy('id', 'desc')->get();
        return view('frontend.order', ['orders' => $orders]);
    }

    // store order details
    public function placeorder(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'payment_method' => 'required'
        ]);
        $cartItems = Cart::getCartItems();

        // check cart item has or not
        if (count($cartItems) < 1) {
            return redirect()->back()->with('error_msg', "You do not have checkout any product !");
        }
        $shipping_address_id = Crypt::decryptString($request->address);
        $payment_method = $request->payment_method;

        // Create Order Table
        $coupon_code = Session::get('coupon_code') ? Session::get('coupon_code') : 0;
        $coupon_amount = Session::get('coupon_amount') ? Session::get('coupon_amount') : 0;
        $grandTotal = (Session::get('grandTotal') != null ? Session::get('grandTotal') : 0) + (Session::get('shipping_charge') != null ? Session::get('shipping_charge') : 0);

        if ($payment_method == "COD") {
            $payment_gateway = "COD";
        }
        if ($payment_method == "Prepaid") {
            $payment_gateway = "paypal";
        }

        $order = new Order();
        $order->name = Auth::user()->name;
        $order->user_id = Auth::id();
        $order->shipping_charge = (Session::get('shipping_charge') != null ? Session::get('shipping_charge') : 0);
        $order->shipping_address = $shipping_address_id;
        $order->coupon_code = $coupon_code;
        $order->coupon_amount = $coupon_amount;
        $order->order_status = 'New Order';
        $order->payment_method = $payment_method;
        $order->payment_gateway = $payment_gateway;
        $order->grand_total = $grandTotal;

        if ($order->save()) {

            $orderStatusLog = new OrderStatusLog();
            $orderStatusLog->orders_id = $order->id;
            $orderStatusLog->status = 'New Order';
            $orderStatusLog->save();

            foreach ($cartItems as $item) {
                $orderItem = new OrderItem();
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
                if ($orderItem->save()) {
                    Cart::destroy($item->id);
                    $attribute->stock = $attribute->stock - $item->quantity;
                    $attribute->save();
                }
            }
            Session::forget('coupon_code');
            Session::forget('coupon_amount');
            Session::forget('grandTotal');
            Session::forget('numberOfCartItem');
            Session::forget('shipping_charge');

            $email = Auth::user()->email;
            Mail::send('email.neworder', ['order' => $order], function ($message) use($email){
                $message->to($email)->subject('Order Confirmation');
            });


            return redirect()->back()->with('success_msg', 'Your order id is # ' . $order->id . '. Please Check you email !');
        }
        return redirect()->back()->with('error_msg', 'Something error, Please try again !');
    }

    // admin order list show
    public function adminorder()
    {
        Session::put('pageTitle', 'Product');
        Session::put('activer', 'Order List');
        $orders = Order::orderBy('id','desc')->with('users')->get();
        return view('admin.product.order.index', ['data' => $orders]);
    }
    public function adminorderdetails($id)
    {
        Session::put('pageTitle', 'Product');
        Session::put('activer', 'Order List');
        $orders = Order::with('users', 'order_items', 'shipping')->findOrFail($id);
        $statuses = OrderStatus::where('status', 1)->orderBy('order_number', 'asc')->get();
        $statuslogs = OrderStatusLog::where('orders_id', $id)->orderBy('id', 'desc')->get();
        $previouslogs = count($statuslogs) > 1 ? $statuslogs[1]->status :  'None';
        $updatedLogsArray = OrderStatusLog::where('orders_id', $id)->select('status')->get();
        $logsArray = array();
        foreach ($updatedLogsArray as $log) {
            $logsArray[] = $log->status;
        }
        $logsArray;
        // order item has product and product has image
        return view('admin.product.order.show', ['data' => $orders, 'statuses' => $statuses, 'statuslogs' => $statuslogs, 'previouslog' => $previouslogs, 'updatedLogsArray' => $logsArray]);
    }

    public function updateorderstatus(Request $request, $id)
    {
        $request->validate(['order_status' => "required"]);
        if ($request->order_status == "Shipped") {
            $request->validate([
                'courier_name' => 'required',
                'tracking_number' => 'required',
            ], [
                'courier_name' => 'Courier Name is required!',
                'tracking_number' => 'Tracking Numbe is required!',
            ]);
        }
        $order = Order::findOrFail($id);
        $order->order_status = $request->order_status;
        $order->courier_name = $request->courier_name;
        $order->tracking_number = $request->tracking_number;
        if($request->shipping_charge != null){
            $order->grand_total = ($order->grand_total - $order->shipping_charge) + $request->shipping_charge;
            $order->shipping_charge = $request->shipping_charge;
        }

        if ($order->save()) {

            // validated already this update done or not
            $oldOrderStatusLog = OrderStatusLog::where('orders_id', $id)->where('status', $request->order_status)->get();
            $user=User::find($order->user_id);
            $email = $user->email;
            if (count($oldOrderStatusLog) == 0) {
                $log = new OrderStatusLog();
                $log->orders_id = $id;
                $log->status = $request->order_status;
                $log->save();
                Mail::send('email.orderStatus', ['order' => $order, 'user' => $user], function ($message) use($email) {
                    $message->to($email)->subject('Order Status');
                });
                return redirect()->back()->with('message', 'Order Updated !');
            } else {
                $log = OrderStatusLog::where('orders_id', $id)->where('status', $request->order_status)->first();
                $log->updated_at = now();
                $log->save();
                Mail::send('email.orderStatus', ['order' => $order, 'user' => $user], function ($message) use($email) {
                    $message->to($email)->subject('Order Status');
                });

                return redirect()->back()->with('message', 'Order Updated !');
            }
            return redirect()->back()->with('message', 'Order does not update, please try again !');
        }
    }

    public function orderinvoicePrint($id)
    {
        $did = Crypt::decryptString($id);
        Session::put('page_title', 'Order Invoice');
        $orders = Order::with('users', 'order_items', 'shipping')->findOrFail($did);
        $statuses = OrderStatus::where('status', 1)->orderBy('order_number', 'asc')->get();
        $statuslogs = OrderStatusLog::where('orders_id', $did)->orderBy('id', 'desc')->get();
        $previouslogs = count($statuslogs) > 1 ? $statuslogs[1]->status :  'None';
        $updatedLogsArray = OrderStatusLog::where('orders_id', $did)->select('status')->get();
        $logsArray = array();
        foreach ($updatedLogsArray as $log) {
            $logsArray[] = $log->status;
        }
        $logsArray;
        // order item has product and product has image
        return view('frontend.orderinvoice', ['data' => $orders, 'statuses' => $statuses, 'statuslogs' => $statuslogs, 'previouslog' => $previouslogs, 'updatedLogsArray' => $logsArray]);
    }
    public function orderinvoiceDownload($id)
    {
        $did = Crypt::decryptString($id);
        Session::put('page_title', 'Order Invoice');
        $orders = Order::with('users', 'order_items', 'shipping')->findOrFail($did);
        $statuses = OrderStatus::where('status', 1)->orderBy('order_number', 'asc')->get();
        $statuslogs = OrderStatusLog::where('orders_id', $did)->orderBy('id', 'desc')->get();
        $previouslogs = count($statuslogs) > 1 ? $statuslogs[1]->status :  'None';
        $updatedLogsArray = OrderStatusLog::where('orders_id', $did)->select('status')->get();
        $logsArray = array();
        foreach ($updatedLogsArray as $log) {
            $logsArray[] = $log->status;
        }
        $logsArray;

        $html = "";
        $html .= "<!DOCTYPE html>
        <html lang='en'>

            <head>
                <meta charset='UTF-8'>
                <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Invoice</title>
                <style>
                    html {
                        font-size: 14px;
                    }

                    * {
                        box-sizing: border-box;
                        font-family: Arial, Helvetica, sans-serif;
                        line-height: 1;
                        margin: 0;
                    }

                    body {
                        padding: 10px;
                    }

                    .a4 {
                        width: 7.7in;
                        display: flex;
                        justify-content: center;
                        z-index: 2;
                        padding: 20px;
                    }
                    .container {
                        width: 100%;
                    }

                    .addresses {
                        display: flex;
                        justify-content: space-between;
                        width: 100%;
                    }

                    .heading {
                        display: flex;
                        justify-content: space-between;
                    }

                    table {
                        padding: 10px;
                        border-radius: 8px;
                        box-shadow: 0 0 4px lightgray;
                    }

                    table * {
                        padding-top: 10px;
                        padding-right: 10px;
                        color: gray;
                    }

                    .itemstable {
                        width: 100%;
                        border-collapse: collapse;
                    }

                    .itemstable td,
                    th {
                        padding: 5px;
                        border: .5px solid lightgray;
                    }

                    .watermark {
                        position: fixed;
                        font-size: 70px;
                        color: gray;
                        opacity: .15;
                        z-index: 1;
                        top: 40%;
                        left: 0;
                        transform: rotate(-45deg);
                        display: none;
                    }

                    h4,
                    th {
                        color: black;
                    }

                    h3 {
                        background-color: lightgray;
                        padding: 10px;
                        border-radius: 5px 5px 0 0;
                        margin-bottom: -15px;
                        box-shadow: 0 0 4px lightgray;
                    }

                    .print-button {
                        border: 0;
                        padding: 5px;
                        border-radius: 2px;
                        background: red;
                        font-size: 18px;
                        cursor: pointer;
                    }


                    @media print {
                        .notprintable {
                            display: none;
                        }

                        .container {
                            border: none;
                        }

                        .watermark {
                            display: block;
                        }
                    }
                </style>

            </head>

        <body>
            <div class='a4'>
                <div class='container'>
                    <div class='heading' style='margin-top: 20px; '>
                        <div style='background: white; width: 83%; margin: 0; display: inline-block;'>
                            <h1 style='color: red;'>Advanced <span style='color:black'>Ecommerce</span></h1>
                            <h1 style='background: black; padding: 10px; color: #fff; display: inline-block; background: red;'>Invoice No#
                                " . $orders->id . "</h1>
                            <p style='margin-top: 10px; color: gray;'>Order Date: " . date_format($orders->created_at, 'd M, Y') . "</p>
                            <p style='margin-top: 10px; color: gray;'>Invoice Date:" . date('d M, Y') . "</p>
                        </div>
                        <div style='background: white; width: 16%; margin: 0; display: inline-block; float: right;'>
                            <span style='width: 100px;'>" . DNS2DFacade::getBarcodeHTML(route('orderinvoicePrint', ['id' => Crypt::encryptString($orders->id)]), 'QRCODE', 2, 2) . "</span>
                            <p style='margin-top: 5px; color: black; font-size: 16px;'>Scane to verify.</p>
                        </div>
                    </div>
                    <br>
                    <div class='addresses' style='margin-top: 10px; padding: 0; '>
                        <div class='billingaddress' style='background:none; display: inline-block;border-radius: 8px; border: 1px solid lightgray' >
                            <h3>Billing Details:</h3>
                            <table>
                                <tr>
                                    <td>Name</td>
                                    <td>:</td>
                                    <td>" . $orders->users->name . "</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>:</td>
                                    <td>" . $orders->users->address . "</td>
                                </tr>
                                <tr>
                                    <td>District</td>
                                    <td>:</td>
                                    <td>" . $orders->users->city . "</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>:</td>
                                    <td>" . $orders->users->email . "</td>
                                </tr>
                                <tr>
                                    <td>Mobile</td>
                                    <td>:</td>
                                    <td>" . $orders->users->mobile . "</td>
                                </tr>
                            </table>
                        </div>
                        <div class='shippingaddress' style='display: inline-block; float:right;border-radius: 8px; border: 1px solid lightgray'>
                            <h3>Shipping Details:</h3>
                            <table>
                                <tr>
                                    <td>Name</td>
                                    <td>:</td>
                                    <td>" . $orders->shipping->name . "</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>:</td>
                                    <td>" . $orders->shipping->address . "</td>
                                </tr>
                                <tr>
                                    <td>Upazila</td>
                                    <td>:</td>
                                    <td> " . $orders->shipping->upazilas->name . "</td>
                                </tr>
                                <tr>
                                    <td>District</td>
                                    <td>:</td>
                                    <td> " . $orders->shipping->districts->name . "</td>
                                </tr>
                                <tr>
                                    <td>Mobile</td>
                                    <td>:</td>
                                    <td>" . $orders->shipping->mobile . "</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <br><br>
                    <div class='items' style='padding: 0; '>
                    <div class='billingaddress' style='background:none; border-radius: 8px; '>
                        <h3>Order Items:</h3>
                        <br>
                        <table class='itemstable' style='width: 100%; padding: 0'>
                            <tr>
                                <th>Sl No</th>
                                <th>Product Description</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Sub Total</th>
                            </tr>";
        foreach ($orders->order_items as $key => $item) {
            $html .= "<tr>
                                    <td>" . $key + 1 . ".</td>
                                    <td>
                                        <h4>" . $item->product_name . "</h4>
                                        Color: " . $item->product_color . " <br>
                                        Size: " . $item->product_size . " <br>
                                        Code: " . $item->product_code . " <br>
                                    </td>
                                    <td style='text-align: center;'>" . $item->product_quantity . " Unit</td>
                                    <td style='text-align: center;'>BDT " . number_format($item->product_price, 2) . "</td>" .
                $totalAmount = $item->product_price * $item->product_quantity;

            $html .= "
                                    <td style='text-align: center;'>BDT
                                        " . number_format($totalAmount * (Cart::getdiscount($item->product_id) / 100), 2) . "
                                    </td>
                                    <td style='text-align: center;'>BDT

                                        " . number_format(
                $totalAmount - $totalAmount * (Cart::getdiscount($item->product_id) / 100),
                2,
            ) . "
                                    </td>
                                </tr>";
        }
        $html .= "<tr>
                                <td colspan='5' style='text-align: right; padding: 10px; font-weight: bold;' >Sub Total</td>
                                <td style='font-weight: bold; text-'>BDT
                                    " . number_format(($orders->grand_total + $orders->coupon_amount) - $orders->shipping_charge, 2) . "</td>
                            </tr>
                            <tr>
                                <td colspan='5' style='text-align: right; padding: 10px; font-weight: bold;' >Coupon Discount</td>
                                <td style='font-weight: bold; text-'>BDT (" . number_format($orders->coupon_amount, 2) . ")</td>
                            </tr>
                            <tr>
                                <td colspan='5' style='text-align: right; padding: 10px; font-weight: bold;' >Shipping Charge</td>
                                <td style='font-weight: bold; text-'>BDT " . number_format($orders->shipping_charge, 2) . "</td>
                            </tr>
                            <tr>
                                <td colspan='5' style='text-align: right; padding: 10px; font-weight: bold;' >Grand Total</td>
                                <td style='font-weight: bold; '>BDT " . number_format($orders->grand_total, 2) . "</td>
                            </tr>
                        </table>
                        <br><br><br><br>
                    </div>
                </div>
            </div>
            <div class='watermark'>
                Advanced Ecommerce
            </div>
        </body>

        </html>";
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        return $pdf->stream();
        //return $view;
    }
}
