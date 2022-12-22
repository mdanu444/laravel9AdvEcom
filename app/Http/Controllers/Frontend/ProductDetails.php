<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\ProductImage;
use App\Models\Admin\ProductsAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductDetails extends Controller
{
    public function index($id)
    {
        Session::put('pagetitle', 'Detail');
        $product = Product::where('status', 1)->findOrFail($id);
        if ($product->product_sub_categories_id == 0) {
            $url = 'c/' . $product->product_categories->url;
            $url_status = 'category_url';
            $related_product = Product::where('product_categories_id', $product->product_categories_id)->where('status', 1)->whereNotIn('id', [$id])->inRandomOrder()->limit(3)->get();
        } else {
            $url = 's/' . $product->product_sub_categories->url;
            $url_status = 'sub_category_url';
            $related_product = Product::where('product_sub_categories_id', $product->product_sub_categories_id)->where('status', 1)->whereNotIn('id', [$id])->inRandomOrder()->limit(3)->get();
        }

        $images = ProductImage::where('products_id', $product->id)->get();
        return view('frontend.detail', ['url' => $url, 'url_status' => $url_status, 'product' => $product, 'images' => $images, 'related_product' => $related_product]);
    }

    public function getpricebysize(Request $request)
    {
        if ($request->size != "") {
            $attributeprice = ProductsAttribute::find($request->size);
            return ['price' => $attributeprice->price];
        } else {
            return ['price' => 0];
        }
    }
}
