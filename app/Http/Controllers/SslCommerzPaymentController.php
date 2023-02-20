<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class SslCommerzPaymentController extends Controller
{

    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout($id)
    {
        $did = Crypt::decryptString($id);
        $order = Order::findOrFail($did);
        Session::forget('order');
        Session::put('order', $order);
        return view('exampleHosted');
    }

    // payment procedure
    public function index()
    {
        $post_data = array();
        $post_data['total_amount'] = Session::get('order')->grand_total; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = Auth::user()->name;
        $post_data['cus_email'] = Auth::user()->email;
        $post_data['cus_add1'] = Auth::user()->address;
        $post_data['cus_city'] = Auth::user()->city;
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = Auth::user()->mobile;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('sslecorders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);


        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('sslecorders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_details = DB::table('sslecorders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $update_product = DB::table('sslecorders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Processing']);


                    $transection = DB::table('sslecorders')->where('transaction_id', $order_details->transaction_id)->first();
                    $user = User::where('email', $transection->email)->first();
                    Auth::login($user);


                    $Working_order = Order::where('user_id', $user->id)->latest()->first();
                    $Working_order->order_status = "Paid";
                    $Working_order->save();

                    $status = 'Paid';
                    $method = 'SSL Ecommerz';



                    Mail::send('email.payment', ['payment' => $transection, 'status' => $status, 'method' => $method], function ($message) use($user){
                        $message->to($user->email)->subject('Payment Confirmation');
                    });



                    echo "<div style='margin: auto; width: 60%; padding: 10px; border-radius: 8px; margin-top: 50px; text-align: center; forn-family: arial; font-size: 20px;'>Payment Successfull ! <br> Payment confirmation sent to you email. <br> <a href='".route('frontend.orderdetails',['id' => Crypt::encryptString($Working_order->id)])."'>click here</a> to go back.";

            }
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            $transection = DB::table('sslecorders')->where('transaction_id', $order_details->transaction_id)->first();
            $user = User::where('email', $transection->email)->first();
            Auth::login($user);

            $Working_order = Order::where('user_id', $user->id)->latest()->first();
            $Working_order->order_status = "Paid";
            $Working_order->save();


            $status = 'Paid';
            $method = 'SSL Ecommerz';


            Mail::send('email.payment', ['payment' => $transection, 'status' => $status, 'method' => $method], function ($message) use($user){
            $message->to($user->email)->subject('Payment Confirmation');
        });
        echo "<div style='margin: auto; width: 60%; padding: 10px; border-radius: 8px; margin-top: 50px; text-align: center; forn-family: arial; font-size: 20px;'>Payment Successfull ! <br> Payment confirmation sent to you email. <br> <a href='".route('frontend.orderdetails',['id' => Crypt::encryptString($Working_order->id)])."'>click here</a> to go back.";
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            return redirect()->route('frontend.cart.index')->with('success_msg', 'Payment Successfull');
        }


    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('sslecorders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('sslecorders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            echo "<div style='margin: auto; width: 60%; padding: 10px; border-radius: 8px; margin-top: 50px; text-align: center; forn-family: arial; font-size: 20px; color: red;'>Payment Failed ! <br> Please go back or <a href='".route('frontend.index')."'>click here</a>";
            echo ("<script>setInterval(()=>{window.location = '".route('frontend.index')."'}, 4000) </script><br>Window will be redirect automatically, Please Wait...</div>");
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('sslecorders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('sslecorders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
                echo "<div style='margin: auto; width: 60%; padding: 10px; border-radius: 8px; margin-top: 50px; text-align: center; forn-family: arial; font-size: 20px; color: red;'>Payment Canceled ! <br> Please go back or <a href='".route('frontend.index')."'>click here</a>";
                echo ("<script>setInterval(()=>{window.location = '".route('frontend.index')."'}, 4000) </script><br>Window will be redirect automatically, Please Wait...</div>");
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }

    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('sslecorders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('sslecorders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                        echo "<div style='margin: auto; width: 60%; padding: 10px; border-radius: 8px; margin-top: 50px; text-align: center; forn-family: arial; font-size: 20px; color: red;'>Payment Failed ! <br> Please go back or <a href='".route('frontend.index')."'>click here</a>";
                        echo ("<script>setInterval(()=>{window.location = '".route('frontend.index')."'}, 4000) </script><br>Window will be redirect automatically, Please Wait...</div>");
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }

}
