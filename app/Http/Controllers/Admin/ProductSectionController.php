<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ProductSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;

class ProductSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('pageTitle', 'Product Category');
        Session::put('activer', 'Product Section');
        $data = ProductSection::all();
        return view('admin.category.section.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Session::put('pageTitle', 'Product Category');
        Session::put('activer', 'Product Section');
        return view('admin.category.section.create');
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
        ]);
        ProductSection::create($request->only('title'));
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
        $did = Crypt::decryptString($id);
        Session::put('pageTitle', 'Product Category');
        Session::put('activer', 'Product Section');
        $data = ProductSection::findOrFail($did);
        return view('admin.category.section.edit', ['item' => $data]);
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
        $productSection = ProductSection::find($did);
        $productSection->title = $request->title;
        $productSection->save();
        return redirect()->back()->with('message', 'Product Section Updated!');
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
        ProductSection::destroy($did);
        return redirect()->route('admin.productsections.index')->with('message', "Section Deleted Successfull!");
    }
}
