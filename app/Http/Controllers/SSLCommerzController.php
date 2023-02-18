<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use DGvai\SSLCommerz\SSLCommerz;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class SSLCommerzController extends Controller
{
    public function index($id)
    {
        $did = Crypt::decryptString($id);
        $order = Order::findOrFail($did);
        Session::put('order', $order);
        return view('frontend.SSLCommerz.index');
    }
    public function order()
    {
        $sslc = new SSLCommerz();
        $sslc->amount(20)
            ->trxid('DEMOTRX123')
            ->product('Demo Product Name')
            ->customer('Customer Name','custemail@email.com');
        return $sslc->make_payment();

        /**
         *
         *  USE:  $sslc->make_payment(true) FOR CHECKOUT INTEGRATION
         *
         * */
    }

    public function success(Request $request)
    {

        $validate = SSLCommerz::validate_payment($request);
        if($validate)
        {
            $bankID = $request->bank_tran_id;   //  KEEP THIS bank_tran_id FOR REFUNDING ISSUE
            ////...
            //  Do the rest database saving works
            //  take a look at dd($request->all()) to see what you need
            ///...
        }
    }

    public function failure(Request $request)
    {
        //...
        //  do the database works
        //  also same goes for cancel()
        //  for IPN() you can leave it untouched or can follow
        //  official documentation about IPN from SSLCommerz Panel
        //...
    }
    public function refund($bankID)
    {
        /**
         * SSLCommerz::refund($bank_trans_id, $amount [,$reason])
         */

        $refund = SSLCommerz::refund($bankID,$refund_amount);

        if($refund->status)
        {
            /**
             * States:
             * success : Refund request is initiated successfully
             * failed : Refund request is failed to initiate
             * processing : The refund has been initiated already
            */

            $state  = $refund->refund_state;

            /**
             * RefID will be used for post-refund status checking
            */

            $refID  = $refund->ref_id;

            /**
             *  To get all the outputs
            */

            dd($refund->output);
        }
        else
        {
            return $refund->message;
        }
    }

    public function check_refund_status($refID)
    {
        $refund = SSLCommerz::query_refund($refID);

        if($refund->status)
        {
            /**
             * States:
             * refunded : Refund request has been proceeded successfully
             * processing : Refund request is under processing
             * cancelled : Refund request has been proceeded successfully
            */

            $state  = $refund->refund_state;

            /**
             * RefID will be used for post-refund status checking
            */

            $refID  = $refund->ref_id;

            /**
             *  To get all the outputs
            */

            dd($refund->output);
        }
        else
        {
            return $refund->message;
        }
    }
    public function get_transaction_status($trxID)
    {
        $query = SSLCommerz::query_transaction($trxID);

        if($query->status)
        {
            dd($query->output);
        }
        else
        {
            $query->message;
        }
    }
}
