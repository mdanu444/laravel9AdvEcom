<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use App\Models\Admin\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Image;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($product)
    {
        Session::put('pageTitle', 'Product');
        $did = Crypt::decryptString($product);
        $product = Product::findOrFail($did);
        $data = ProductImage::where('products_id', $did)->get();
        return view('admin.product.image.index', ['product' => $product, 'data' => $data] );
    }


    public function store(Request $request, $product)
    {
        $did = Crypt::decryptString($product);
        $request->validate([
            'images' => 'required',
        ]);
        echo "<pre>";
        foreach ($request->file('images') as $key => $image) {
            $numberofimages = ProductImage::where('products_id', $did)->get();
            if($numberofimages->count() > 9){
                return redirect()->back()->with('message', "Cant add more then 10 Image!");
            }
            $image_tmp = $image;
            $image_extention = $image_tmp->getclientoriginalextension();
            $image_name = rand(11,999).time().".".$image_extention;
            Image::make($image_tmp)->save('images/product_image/alternative/'.$image_name);
            $ProductsAttribute = new ProductImage;
            $ProductsAttribute->title = $image_name;
            $ProductsAttribute->products_id = $did;
            $ProductsAttribute->save();
        }
        return redirect()->back()->with('message', "Product Image Added Successfully!");
    }


    public function destroy($product, $id)
    {   
        $did = Crypt::decryptString($id);
        $product_image = ProductImage::findOrfail($did);
        unlink('images/product_image/alternative/'.$product_image->title);
        ProductImage::destroy($did);
        return redirect()->route('admin.p_image.index', $product)->with('message', "Image Deleted Successfull!");
    }
}