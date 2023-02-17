<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\ShippingCharge;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ShippingChargeController extends Controller
{
    public function index(){
        Session::put('pageTitle', 'Product Category');
        Session::put('activer', 'Shipping Charge');
        $shippingCharges = ShippingCharge::with('districts')->get();
        return view('admin.category.shippingcharge.index', ['data' => $shippingCharges]);
    }
    public function store(){
        $districts = District::all();
        foreach ($districts as $district){
            $shippingCharge = new ShippingCharge();
            $shippingCharge->districts_id = $district->id;
            $shippingCharge->weight_0_500g = 100;
            $shippingCharge->weight_501_1000g = 150;
            $shippingCharge->weight_1001_2000g = 200;
            $shippingCharge->weight_2001_5000g = 250;
            $shippingCharge->weight_5001g_above = 300;
            $shippingCharge->save();
        }
    }
    public function edit($id){
        $did = Crypt::decryptString($id);
        Session::put('pageTitle', 'Product Category');
        Session::put('activer', 'Shipping Charge');
        $shippingCharges = ShippingCharge::with('districts')->find($did);
        return view('admin.category.shippingcharge.edit', ['item' => $shippingCharges]);
    }
    public function update(Request $request, $id){
        $request->validate([
            "weight_0_500g" => 'required',
            "weight_501_1000g" => 'required',
            "weight_1001_2000g" => 'required',
            "weight_2001_5000g" => 'required',
            "weight_5001g_above" => 'required',
        ], [
            "weight_0_500g.required" => "Weight 0 to 500g. Field Is Required.",
            "weight_501_1000g.required" => "Weight 501 to 1000g. Field Is Required.",
            "weight_1001_2000g.required" => "Weight 1001 to 2000g. Field Is Required.",
            "weight_2001_5000g.required" => "Weight 2001 to 5000g. Field Is Required.",
            "weight_5001g_above.required" => "Weight 5000g. to Above. Field Is Required.",
        ]);
        $did = Crypt::decryptString($id);
        $shippingCharges = ShippingCharge::with('districts')->find($did);
        $shippingCharges->weight_0_500g = $request->weight_0_500g;
        $shippingCharges->weight_501_1000g = $request->weight_501_1000g;
        $shippingCharges->weight_1001_2000g = $request->weight_1001_2000g;
        $shippingCharges->weight_2001_5000g = $request->weight_2001_5000g;
        $shippingCharges->weight_5001g_above = $request->weight_5001g_above;
        $shippingCharges->save();
        return redirect()->back()->with('success_msg', 'Shipping Charge Updated Successfully !');
    }
}
