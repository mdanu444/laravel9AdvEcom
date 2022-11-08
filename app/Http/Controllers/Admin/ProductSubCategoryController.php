<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\ProductSection;
use App\Models\Admin\ProductSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('pageTitle', 'Product Category');
        $data = ProductSubCategory::all();
        return view('admin.category.subcategory.index', ['data' => $data] );
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
        return view('admin.category.subcategory.create', ['sections'=> $sections]);
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
            'product_sections_id' => 'required|integer',
            'product_categories_id' => 'required|integer',
        ]);
        ProductCategory::create($request->only('title', 'product_sections_id', 'product_categories_id'));
        return redirect()->back()->with('message', "Sub Category Added Successfully!");
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
        $categories = ProductCategory::all();
        return view('admin.category.subcategory.edit', ['item'=> $data, 'sections' => $section, 'categories' => $categories]);
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
        $ProductSubCategory = ProductSubCategory::find($id);
        $ProductSubCategory->title = $request->title;
        $ProductSubCategory->product_sections_id = $request->product_sections;
        $ProductSubCategory->product_categories_id = $request->product_categories;
        $ProductSubCategory->save();
        return redirect()->back()->with('message', 'Product Sub Category Updated!');
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
        return redirect()->route('admin.productsubcategory.index')->with('message', "Section Deleted Successfull!");
    }

    public function getcategorybysection(Request $request){
        $id = $request->section;
        $categories = ProductCategory::where('product_sections_id', $id)->get();

        $returnHTML = view('admin.category.subcategory.categories')->with('categories', $categories)->render();
        return response()->json(['success'=> true, 'html'=>$returnHTML]);

    }
}
