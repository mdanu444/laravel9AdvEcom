<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ProductSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('pageTitle', 'Product Category');
        $data = ProductSection::all();
        return view('admin.category.section.index', ['data' => $data] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Session::put('pageTitle', 'Product Category');
        return view('admin.category.section.create');
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
        ProductSection::create($request->only('title'));
        return redirect()->back()->with('message', "Section Added Successfully!");
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
        Session::put('pageTitle', 'Product Category');
        $data = ProductSection::findOrFail($id);
        return view('admin.category.section.edit', ['item'=> $data]);
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
        $productSection = ProductSection::find($id);
        $productSection->title = $request->title;
        $productSection->save();
        return redirect()->back()->with('message', 'Product Section Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ProductSection::destroy($id);
        return redirect()->route('admin.productsections.index')->with('message', "Section Deleted Successfull!");
    }
}
