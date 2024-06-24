<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Brand;
use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\ProductSection;
use App\Models\Admin\ProductSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('pageTitle', 'Product');
        Session::put('activer', 'Product List');
        $data = Product::all();
        return view('admin.product.product.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Session::put('pageTitle', 'Product');
        Session::put('activer', 'Product List');
        $sections = ProductSection::all();
        $brands = Brand::all();
        return view('admin.product.product.create', ['sections' => $sections, 'brands' => $brands]);
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
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'discount' => 'integer',
            'description' => 'required',
            'featured' => 'required',
            'brands_id' => 'required',
            'code' => 'required',
            'color' => 'required',
            'price' => 'required',
            'weight' => 'required',
            'unit' => 'required',
            'wash_care' => 'required',
            'product_sections_id' => 'required',
            'product_categories_id' => 'required',
            'product_sub_categories_id' => 'required',
        ], [
            'product_sections_id.required' => 'Please Select Section',
            'product_categories_id.required' => 'Please Select Category',
            'product_sub_categories_id.required' => 'Please Select Sub Category',
        ]);


        $product = new Product;
        $product->title = $request->title;
        $product->discount = $request->discount != null ? $request->discount : 0;
        $product->description = $request->description;
        $product->meta_title = $request->meta_title != null ? $request->meta_title : 0;
        $product->meta_description = $request->meta_description != null ? $request->meta_description : 0;
        $product->meta_keywords = $request->meta_keywords != null ? $request->meta_keywords : 0;
        $product->brands_id = Crypt::decryptString($request->brands_id);
        $product->code = $request->code;
        $product->color = $request->color;
        $product->unit = $request->unit != null ? $request->unit : 'Peice';
        $product->weight = $request->weight != null ? $request->weight : 'Unknown';
        $product->price = $request->price;
        $product->featured = $request->featured;
        $product->wash_care = $request->wash_care != null ? $request->wash_care : 0;
        $product->fabric = $request->fabric;
        $product->pattern = $request->pattern;
        $product->sleeve = $request->sleeve;
        $product->fit = $request->fit;
        $product->occassion = $request->occassion;
        $product->status = 1;
        $product->product_sections_id = Crypt::decryptString($request->product_sections_id);
        $product->product_categories_id = Crypt::decryptString($request->product_categories_id);
        $product->product_sub_categories_id = Crypt::decryptString($request->product_sub_categories_id);



        if ($request->hasFile('image')) {
            $image_tmp = $request->file('image');
            $image_tmp->isValid();
            $image_extention = $image_tmp->getClientOriginalExtension();
            $image_name = rand(1, 999) . time() . "." . $image_extention;
            $lg_image_path = 'images/product_image/larg/' . $image_name;
            $md_image_path = 'images/product_image/medium/' . $image_name;
            $sm_image_path = 'images/product_image/small/' . $image_name;
            $product->image = $image_name;
            // return ($image_path);
            Image::make($image_tmp)->save($lg_image_path);
            Image::make($image_tmp)->resize(520, 600)->save($md_image_path);
            Image::make($image_tmp)->resize(260, 300)->save($sm_image_path);
        }
        $product->video = 0;
        if ($request->hasFile('video')) {
            $video_tmp = $request->file('video');
            $video_extention = $video_tmp->getClientOriginalExtension();
            $video_name = rand(111, 999999) . "." . $video_extention;
            $video_path = 'video/product_video/';
            $product->video = $video_name;
            // return ($image_path);
            $video_tmp->move($video_path, $video_name);
        }


        $product->save();

        return redirect()->back()->with('message', "Product Added Successfully!");
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
        Session::put('pageTitle', 'Product');
        Session::put('activer', 'Product List');
        $data = Product::findOrFail($did);
        $section = ProductSection::all();
        $category = ProductCategory::where('product_sections_id', $data->product_sections_id)->get();
        $subcategory = ProductSubCategory::where('product_categories_id', $data->product_categories_id)->get();
        $brands = Brand::all();
        return view('admin.product.product.edit', ['data' => $data, 'sections' => $section, 'category' => $category, 'subcategory' => $subcategory, 'brands' => $brands]);
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
            'title' => 'required',
            'discount' => 'integer',
            'description' => 'required',
            'featured' => 'required',
            'brands_id' => 'required',
            'code' => 'required',
            'color' => 'required',
            'price' => 'required',
            'weight' => 'required',
            'unit' => 'required',
            'wash_care' => 'required',
            'product_sections_id' => 'required',
            'product_categories_id' => 'required',
            'product_sub_categories_id' => 'required',
        ], [
            'product_sections_id.required' => 'Please Select Section',
            'product_categories_id.required' => 'Please Select Category',
            'product_sub_categories_id.required' => 'Please Select Sub Category',
        ]);

        $did = Crypt::decryptString($id);
        $product = Product::findOrfail($did);
        $product->title = $request->title;
        $product->discount = $request->discount;
        $product->description = $request->description;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->meta_keywords = $request->meta_keywords;
        $product->brands_id = Crypt::decryptString($request->brands_id);
        $product->code = $request->code;
        $product->color = $request->color;
        $product->unit = $request->unit;
        $product->weight = $request->weight;
        $product->price = $request->price;
        $product->featured = $request->featured;
        $product->wash_care = $request->wash_care;
        $product->fabric = $request->fabric;
        $product->pattern = $request->pattern;
        $product->sleeve = $request->sleeve;
        $product->fit = $request->fit;
        $product->occassion = $request->occassion;
        $product->product_sections_id = Crypt::decryptString($request->product_sections_id);
        $product->product_categories_id = Crypt::decryptString($request->product_categories_id);
        $product->product_sub_categories_id = Crypt::decryptString($request->product_sub_categories_id);



        if ($request->hasFile('image')) {
            $image_tmp = $request->file('image');
            $image_tmp->isValid();
            $image_extention = $image_tmp->getClientOriginalExtension();
            $image_name = rand(1, 999) . time() . "." . $image_extention;
            $lg_image_path = 'images/product_image/larg/' . $image_name;
            $md_image_path = 'images/product_image/medium/' . $image_name;
            $sm_image_path = 'images/product_image/small/' . $image_name;
            $product->image = $image_name;
            // return ($image_path);
            Image::make($image_tmp)->save($lg_image_path);
            Image::make($image_tmp)->resize(520, 600)->save($md_image_path);
            Image::make($image_tmp)->resize(260, 300)->save($sm_image_path);
        } else {
            $product->image = $product->image;
        }

        if ($request->hasFile('video')) {
            $video_tmp = $request->file('video');
            $video_extention = $video_tmp->getClientOriginalExtension();
            $video_name = rand(111, 999999) . "." . $video_extention;
            $video_path = 'video/product_video/';
            $product->video = $video_name;
            // return ($image_path);
            $video_tmp->move($video_path, $video_name);
        } else {
            $product->video = $product->video;
        }


        $product->save();

        return redirect()->back()->with('message', "Product Updated Successfully!");
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
        $Product = Product::find($did);
        $lg_image_path = 'images/product_image/larg/' . $Product->image;
        $md_image_path = 'images/product_image/medium/' . $Product->image;
        $sm_image_path = 'images/product_image/small/' . $Product->image;
        $video = 'video/product_video/' . $Product->video;
        // return ($image_path);
        unlink($lg_image_path);
        unlink($md_image_path);
        unlink($sm_image_path);
        unlink($video);
        Product::destroy($did);
        return redirect()->route('admin.product.index')->with('message', "Product Deleted Successfull!");
    }

    function getsubcategorybysection(Request $request)
    {
        $id = Crypt::decryptString($request->id);
        $categories = ProductSubCategory::where('product_categories_id', $id)->get();
        $html = view('admin.product.product.subcategories', ['categories' => $categories])->render();

        return response(['html' => $html]);
    }
}
