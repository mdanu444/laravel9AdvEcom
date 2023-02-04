<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use App\Models\Admin\ProductsAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class ProductsAttributeController extends Controller
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
        $data = ProductsAttribute::where('products_id', $did)->get();
        return view('admin.product.attribute.index', ['product' => $product, 'data' => $data]);
    }


    public function store(Request $request, $product)
    {
        $did = Crypt::decryptString($product);
        $request->validate([
            'size' => 'required',
            'price' => 'required',
            'sku' => 'required',
            'stock' => 'required',
        ]);
        echo "<pre>";
        foreach ($request->size as $key => $value) {
            $size = ProductsAttribute::where('products_id', $did)->where('size', $request->size[$key])->get();
            if (count($size) > 0) {
                return redirect()->back()->with('message', "Size already added !");
            }
            $sku = ProductsAttribute::where('products_id', $did)->where('sku', $request->sku[$key])->get();
            if (count($sku) > 0) {
                return redirect()->back()->with('message', "Sku already added !");
            }
            $ProductsAttribute = new ProductsAttribute;
            $ProductsAttribute->products_id = $did;
            $ProductsAttribute->size = $request->size[$key];
            $ProductsAttribute->sku = $request->sku[$key];
            $ProductsAttribute->price = $request->price[$key];
            $ProductsAttribute->stock = $request->stock[$key];
            $ProductsAttribute->save();
        }
        return redirect()->back()->with('message', "Attribute Added Successfully!");
    }


    public function destroy($product, $id)
    {
        $did = Crypt::decryptString($id);
        ProductsAttribute::destroy($did);
        return redirect()->route('admin.p_attribute.index', $product)->with('message', "Attribute Deleted Successfull!");
    }

    public function update(Request $request)
    {
        return "product";
    }
}
