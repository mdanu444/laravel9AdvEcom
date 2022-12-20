<?php

namespace App\Http\Controllers;

use App\Models\Admin\ProductCategory;
use App\Models\Admin\ProductSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Image;

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
        Session::put('activer', 'Product Category');
        $data = ProductCategory::all();
        return view('admin.category.category.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Session::put('pageTitle', 'Product Category');
        Session::put('activer', 'Product Category');
        $sections = ProductSection::all();
        return view('admin.category.category.create', ['sections' => $sections]);
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
            'url' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'discount' => 'integer',
            'description' => 'required',
        ]);


        $productCategory = new ProductCategory;

        $image_tmp = $request->file('image');
        if ($image_tmp->isValid()) {
            $image_extention = $image_tmp->getClientOriginalExtension();
            $image_name = rand(111, 999999) . "." . $image_extention;
            $image_path = 'images/category_image/' . $image_name;
            $productCategory->image = $image_path;
            // return ($image_path);
            Image::make($image_tmp)->save($image_path);
        }

        $productCategory->title = $request->title;
        $productCategory->discount = $request->discount;
        $productCategory->description = $request->description;
        $productCategory->meta_title = $request->meta_title;
        $productCategory->meta_description = $request->meta_description;
        $productCategory->meta_keywords = $request->meta_keywords;
        $productCategory->url = $request->url;
        $productCategory->status = 1;
        $productCategory->product_sections_id = $request->product_sections_id;
        $productCategory->save();

        return redirect()->back()->with('message', "Category Added Successfully!");
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
        Session::put('activer', 'Product Category');
        $data = ProductCategory::findOrFail($did);
        $section = ProductSection::all();
        return view('admin.category.category.edit', ['item' => $data, 'sections' => $section]);
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
        $did = Crypt::decryptString($id);
        $ProductCategory = ProductCategory::findOrfail($did);
        if (!$request->hasFile('image')) {
            // dd($request->all());
            $ProductCategory->title = $request->title;
            $ProductCategory->discount = $request->discount;
            $ProductCategory->description = $request->description;
            $ProductCategory->meta_title = $request->meta_title;
            $ProductCategory->meta_description = $request->meta_description;
            $ProductCategory->meta_keywords = $request->meta_keywords;
            $ProductCategory->url = $request->url;
            $ProductCategory->product_sections_id = $request->product_sections_id;
            $ProductCategory->save();
        }
        if ($request->hasFile('image')) {
            unlink($ProductCategory->image);
            $image_tmp = $request->file('image');
            if ($image_tmp->isValid()) {
                $image_extention = $image_tmp->getClientOriginalExtension();
                $image_name = rand(111, 999999) . "." . $image_extention;
                $image_path = 'images/category_image/' . $image_name;
                $ProductCategory->image = $image_path;
                // return ($image_path);
                Image::make($image_tmp)->save($image_path);
            }
            // dd($request->all());
            $ProductCategory->title = $request->title;
            $ProductCategory->discount = $request->discount;
            $ProductCategory->description = $request->description;
            $ProductCategory->meta_title = $request->meta_title;
            $ProductCategory->meta_description = $request->meta_description;
            $ProductCategory->meta_keywords = $request->meta_keywords;
            $ProductCategory->url = $request->url;
            $ProductCategory->product_sections_id = $request->product_sections_id;
            $ProductCategory->save();
        }
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
        $did = Crypt::decryptString($id);
        $ProductCategory = ProductCategory::find($did);
        unlink($ProductCategory->image);
        ProductCategory::destroy($did);
        return redirect()->route('admin.productcategory.index')->with('message', "Category Deleted Successfull!");
    }
}
