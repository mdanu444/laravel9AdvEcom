<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Coupon;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\ProductSection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Str;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('pageTitle', 'Product Category');
        Session::put('activer', 'Product Coupon');
        $data = Coupon::all();
        return view('admin.category.Coupon.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Session::put('pageTitle', 'Product Category');
        Session::put('activer', 'Product Coupon');
        $sections = ProductSection::with('product_categories')->with('product_sub_categories')->get();
        $users = User::get();
        // return $sections[2]->product_categories[0]->product_sub_categories;
        return view('admin.category.Coupon.create', ['sections' => $sections, 'users'=> $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'option' => 'required',
            'coupon_type' => "required",
            'categories' => 'required',
            'users' => 'required',
            'expiry_date' => 'required',
            'amount_type' => 'required',
            'amount' => "required|integer",
        ]);

        if($request->option == 'manual'){
            $code = $request->code;
        }
        if($request->option == 'automatic'){
            $code = Str::random(8);
        }

        $categories = "";
        $sub_categories = "";
        foreach($request->categories as $data){
            $singledata = explode("-", $data);
            if($singledata[0] == 's'){
                $sub_categories .= $singledata[1].",";
            }
            if($singledata[0] == 'c'){
                $categories .= $singledata[1].",";
            }
        }



        $users = implode(',', $request->users);

        $date = date('Y-m-d H:i:s',strtotime($request->expiry_date));
        $coupon = new Coupon();
        $coupon->option = $request->option;
        $coupon->code = $code;
        $coupon->categories = $categories;
        $coupon->subcategories = $sub_categories;
        $coupon->users = $users;
        $coupon->coupon_type = $request->coupon_type;
        $coupon->amount_type = $request->amount_type;
        $coupon->amount = $request->amount;
        $coupon->expiry_date = $date;
        $coupon->status = 1;
        if($coupon->save()){
            return redirect()->back()->with('message', "Coupon created Successfully!");
        }
        return redirect()->back()->with('message', "Coupon could not create, please try again !");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $did = Crypt::decryptString($id);
        Session::put('pageTitle', 'Product Category');
        Session::put('activer', 'Product Coupon');
        $data = Coupon::findOrFail($did);
        $sections = ProductSection::with('product_categories')->with('product_sub_categories')->get();
        $users = User::get();
        return view('admin.category.Coupon.edit', ['item' => $data, 'sections' => $sections, 'users' => $users]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'option' => 'required',
            'coupon_type' => "required",
            'categories' => 'required',
            'users' => 'required',
            'expiry_date' => 'required',
            'amount_type' => 'required',
            'amount' => "required|integer",
        ]);

        if($request->option == 'manual'){
            $code = $request->code;
        }
        if($request->option == 'automatic'){
            $code = Str::random(8);
        }

        $categories = "";
        $sub_categories = "";
        foreach($request->categories as $data){
            $singledata = explode("-", $data);
            if($singledata[0] == 's'){
                $sub_categories .= $singledata[1].",";
            }
            if($singledata[0] == 'c'){
                $categories .= $singledata[1].",";
            }
        }



        $users = implode(',', $request->users);

        $date = date('Y-m-d H:i:s',strtotime($request->expiry_date));
        $did = Crypt::decryptString($id);
        $coupon = Coupon::find($did);
        $coupon->option = $request->option;
        $coupon->code = $code;
        $coupon->categories = $categories;
        $coupon->subcategories = $sub_categories;
        $coupon->users = $users;
        $coupon->coupon_type = $request->coupon_type;
        $coupon->amount_type = $request->amount_type;
        $coupon->amount = $request->amount;
        $coupon->expiry_date = $date;
        $coupon->status = 1;
        if($coupon->save()){
            return redirect()->back()->with('message', "Coupon Updated Successfully!");
        }
        return redirect()->back()->with('message', "Coupon could not update, please try again !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $did = Crypt::decryptString($id);
        Coupon::destroy($did);
        return redirect()->route('admin.coupons.index')->with('message', "Section Deleted Successfull!");
    }
}
