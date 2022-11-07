<?php

namespace App\Http\Controllers;

use App\Models\Admin\ProductCategory;
use App\Models\Admin\ProductSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('pageTitle', 'Product Category');
        $data = ProductCategory::all();
        return view('admin.category.category.index', ['data' => $data] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Session::put('pageTitle', 'Product Category');
        $sections = ProductSection::all();
        return view('admin.category.category.create', ['sections'=> $sections]);
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
            'product_sections_id' => 'required|integer'
        ]);
        ProductCategory::create($request->only('title', 'product_sections_id'));
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
        $data = ProductCategory::findOrFail($id);
        $section = ProductSection::all();
        return view('admin.category.category.edit', ['item'=> $data, 'sections' => $section]);
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
        $ProductCategory = ProductCategory::find($id);
        $ProductCategory->title = $request->title;
        $ProductCategory->product_sections_id = $request->product_sections;
        $ProductCategory->save();
        return redirect()->back()->with('message', 'Product Category Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ProductCategory::destroy($id);
        return redirect()->route('admin.productcategory.index')->with('message', "Section Deleted Successfull!");
    }
}
