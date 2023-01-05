<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\ProductSection;
use App\Models\Admin\ProductSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Image;

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
        Session::put('activer', 'Product Sub Category');
        $data = ProductSubCategory::all();
        return view('admin.category.subcategory.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Session::put('pageTitle', 'Product Category');
        Session::put('activer', 'Product Sub Category');
        $sections = ProductSection::all();
        $category = ProductCategory::all();
        return view('admin.category.subcategory.create', ['sections' => $sections, 'category' => $category]);
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
            'url' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'discount' => 'integer',
            'description' => 'required',
        ]);


        $productSubCategory = new ProductSubCategory;

        $image_tmp = $request->file('image');
        if ($image_tmp->isValid()) {
            $image_extention = $image_tmp->getClientOriginalExtension();
            $image_name = rand(111, 999999) . "." . $image_extention;
            $image_path = 'images/subcategory_image/' . $image_name;
            $productSubCategory->image = $image_path;
            // return ($image_path);
            Image::make($image_tmp)->save($image_path);
        }

        $productSubCategory->title = $request->title;
        $productSubCategory->discount = $request->discount;
        $productSubCategory->description = $request->description;
        $productSubCategory->meta_title = $request->meta_title;
        $productSubCategory->meta_description = $request->meta_description;
        $productSubCategory->meta_keywords = $request->meta_keywords;
        $productSubCategory->url = $request->url;
        $productSubCategory->status = 1;
        $productSubCategory->product_sections_id = Crypt::decryptString($request->product_sections_id);
        $productSubCategory->product_categories_id = Crypt::decryptString($request->product_categories_id);
        $productSubCategory->save();

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
        $did = Crypt::decryptString($id);
        Session::put('pageTitle', 'Product Category');
        Session::put('activer', 'Product Sub Category');
        $data = ProductSubCategory::findOrFail($did);
        $section = ProductSection::all();
        $category = ProductCategory::where('product_sections_id', $data->product_sections_id)->get();
        return view('admin.category.subcategory.edit', ['item' => $data, 'sections' => $section, 'category' => $category]);
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
        $ProductSubCategory = ProductSubCategory::findOrfail($did);
        if (!$request->hasFile('image')) {
            $ProductSubCategory->title = $request->title;
            $ProductSubCategory->discount = $request->discount;
            $ProductSubCategory->description = $request->description;
            $ProductSubCategory->meta_title = $request->meta_title;
            $ProductSubCategory->meta_description = $request->meta_description;
            $ProductSubCategory->meta_keywords = $request->meta_keywords;
            $ProductSubCategory->url = $request->url;
            $ProductSubCategory->product_sections_id = Crypt::decryptString($request->product_sections_id);
            $ProductSubCategory->product_categories_id = Crypt::decryptString($request->product_categories_id);
            $ProductSubCategory->save();
        }
        if ($request->hasFile('image')) {
            unlink($ProductSubCategory->image);
            $image_tmp = $request->file('image');
            if ($image_tmp->isValid()) {
                $image_extention = $image_tmp->getClientOriginalExtension();
                $image_name = rand(111, 999999) . "." . $image_extention;
                $image_path = 'images/subcategory_image/' . $image_name;
                $ProductSubCategory->image = $image_path;
                // return ($image_path);
                Image::make($image_tmp)->save($image_path);
            }
            // dd($request->all());
            $ProductSubCategory->title = $request->title;
            $ProductSubCategory->discount = $request->discount;
            $ProductSubCategory->description = $request->description;
            $ProductSubCategory->meta_title = $request->meta_title;
            $ProductSubCategory->meta_description = $request->meta_description;
            $ProductSubCategory->meta_keywords = $request->meta_keywords;
            $ProductSubCategory->url = $request->url;
            $ProductSubCategory->product_sections_id = Crypt::decryptString($request->product_sections_id);
            $ProductSubCategory->product_categories_id = Crypt::decryptString($request->product_categories_id);
            $ProductSubCategory->save();
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
        $ProductSubCategory = ProductSubCategory::find($did);
        unlink($ProductSubCategory->image);
        ProductSubCategory::destroy($did);
        return redirect()->route('admin.productsubcategory.index')->with('message', "Sub Category Deleted Successfull!");
    }

    function getcategorybysection(Request $request)
    {
        $id = Crypt::decryptString($request->id);
        $categories = ProductCategory::where('product_sections_id', $id)->get();
        $html = view('admin.category.subcategory.categories', ['categories' => $categories])->render();

        return response(['html' => $html]);
    }
}
