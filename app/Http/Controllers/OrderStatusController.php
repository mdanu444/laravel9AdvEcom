<?php

namespace App\Http\Controllers;

use App\Models\Admin\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class OrderStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('pageTitle', 'Product Category');
        Session::put('activer', 'Order Status');
        $data = OrderStatus::all();
        return view('admin.category.orderStatus.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Session::put('pageTitle', 'Product Category');
        Session::put('activer', 'Order Status');
        return view('admin.category.orderStatus.create');
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
            'title' => 'required',
        ]);
        OrderStatus::create($request->only('title'));
        return redirect()->back()->with('message', "Order Status Added Successfully!");
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
        Session::put('activer', 'Order Status');
        $data = orderStatus::findOrFail($did);
        return view('admin.category.orderStatus.edit', ['item' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatusOrder(Request $request)
    {
        $ids = explode(",", $request->ids);
        $numbers = explode(",", $request->numbers);

        foreach ($numbers as $key => $number) {
            if (!empty($ids[$key])) {
                $status = OrderStatus::find($ids[$key]);
                $status->order_number = $number;
                $status->save();
            }
        }
        return ['status' => true, 'data' => 'Updated Successfully'];
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
        OrderStatus::destroy($did);
        return redirect()->route('admin.order_status.index')->with('message', "Order Status Deleted Successfull!");
    }
}
