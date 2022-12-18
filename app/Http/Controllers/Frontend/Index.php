<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\ProductSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Index extends Controller
{
    public function index()
    {
        Session::put('pagetitle', 'home');
        $numberofproduct = count(Product::all());
        $featured_products = Product::where('featured', 1)->where('status', 1)->get()->toArray();
        $featured_products = array_chunk($featured_products, 4);
        $collection = Product::where('status', 1)->orderBy('id', 'DESC')->limit(6)->get();
        return view('frontend.welcome', ['featured_products' => $featured_products, 'numberofproduct' => $numberofproduct, 'collection' => $collection,]);
    }
    public function category($cat_link)
    {
        $category = ProductCategory::where('url', $cat_link)->first();
        Session::put('pagetitle', $category->title);



        $categoryProducts = Product::where(['product_categories_id' => $category->id, 'status' => 1])->paginate(3);

        if (isset($_GET['sort']) && $_GET['sort'] == 'by-heighest-price') {
            $categoryProducts = Product::where(['product_categories_id' => $category->id, 'status' => 1])->orderBy('price', 'desc')->paginate(3);
        }
        if (isset($_GET['sort']) && $_GET['sort'] == 'by-lowest-price') {
            $categoryProducts = Product::where(['product_categories_id' => $category->id, 'status' => 1])->orderBy('price', 'asc')->paginate(3);
        }
        if (isset($_GET['sort']) && $_GET['sort'] == 'latest') {
            $categoryProducts = Product::where(['product_categories_id' => $category->id, 'status' => 1])->orderBy('id', 'desc')->paginate(3);
        }





        $numberofproducts = count(Product::where(['product_categories_id' => $category->id, 'status' => 1])->get());
        return view('frontend.listing', ['category' => $category, 'products' => $categoryProducts, 'numberofproducts' => $numberofproducts]);
    }
    public function subcat($sub_link)
    {
        $subcategory = ProductSubCategory::where(['url' => $sub_link, 'status' => 1])->first();
        Session::put('pagetitle', $subcategory->title);
        $category = $subcategory->product_categories;
        $subcategoryProducts = Product::where(['product_sub_categories_id' => $subcategory->id, 'status' => 1])->paginate(3);
        $numberofproducts = count(Product::where(['product_sub_categories_id' => $subcategory->id, 'status' => 1])->get());
        return view('frontend.listing', ['category' => $category, 'subcategory' => $subcategory, 'products' => $subcategoryProducts, 'numberofproducts' => $numberofproducts]);
    }
}
