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
    public function category(Request $request, $cat_link)
    {

        Session::put('pagetitle', 'listing');
        $category = ProductCategory::where('url', $cat_link)->first();
        $subcategoryProducts = Product::where(['product_categories_id' => $category->id, 'status' => 1]);



        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($request->sort) && $request->sort != "") {
            $filters = $request->filter;
            $filters = json_decode($filters);
            foreach ($filters as $key => $filter) {
                if (count($filter) > 0) {
                    $subcategoryProducts = $subcategoryProducts->whereIn($key, $filter);
                }
            }
            if ($request->sort == 'by-heighest-price') {
                $subcategoryProducts = $subcategoryProducts->orderBy('price', 'desc');
            }
            if ($request->sort == 'by-lowest-price') {
                $subcategoryProducts = $subcategoryProducts->orderBy('price', 'asc');
            }
            if ($request->sort == 'latest') {
                $subcategoryProducts = $subcategoryProducts->orderBy('id', 'desc');
            }
            $subcategoryProducts = $subcategoryProducts->paginate(6);
            $html = view('frontend.ajax_listing')->with('products', $subcategoryProducts)->render();
            return response()->json(array('html' => $html));
        }





        $subcategoryProducts = $subcategoryProducts->paginate(6);
        $numberofproducts = count(Product::where(['product_categories_id' => $category->id, 'status' => 1])->get());
        return view('frontend.listing', ['category' => $category, 'products' => $subcategoryProducts, 'numberofproducts' => $numberofproducts, 'url' => url('c/' . $cat_link)]);
    }
    public function subcat(Request $request, $sub_link)
    {

        Session::put('pagetitle', 'listing');


        $subcategory = ProductSubCategory::where(['url' => $sub_link, 'status' => 1])->first();

        $subcategoryProducts = Product::where(['product_sub_categories_id' => $subcategory->id, 'status' => 1]);

        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($request->sort) && $request->sort != "") {
            if ($request->sort == 'by-heighest-price') {
                $subcategoryProducts = $subcategoryProducts->orderBy('price', 'desc');
            } elseif ($request->sort == 'by-lowest-price') {
                $subcategoryProducts = $subcategoryProducts->orderBy('price', 'asc');
            } elseif ($request->sort == 'latest') {
                $subcategoryProducts = $subcategoryProducts->orderBy('id', 'desc');
            }

            $subcategoryProducts = $subcategoryProducts->paginate(6);
            $html = view('frontend.ajax_listing')->with('products', $subcategoryProducts)->render();
            return response()->json(array('html' => $html));
        }



        Session::put('pagetitle', $subcategory->title);
        $category = $subcategory->product_categories;

        $subcategoryProducts = $subcategoryProducts->paginate(6);
        $numberofproducts = count(Product::where(['product_sub_categories_id' => $subcategory->id, 'status' => 1])->get());

        return view('frontend.listing', ['category' => $category, 'subcategory' => $subcategory, 'products' => $subcategoryProducts, 'numberofproducts' => $numberofproducts, 'url' => url('s/' . $sub_link)]);
    }
}
