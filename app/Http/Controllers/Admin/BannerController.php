<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Image;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('pageTitle', 'Product Category');
        $data = Banner::all();
        return view('admin.category.banner.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Session::put('pageTitle', 'Product Category');
        return view('admin.category.banner.create');
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
            'image' => 'required|image|mimes:png,jpg,jpeg|dimensions:width=1170,height=480',
            'url' => 'required|url'
        ]);
        $banner = new Banner();
        $banner->title = $request->title;
        $banner->url = $request->url;
        if ($request->hasFile('image')) {
            $image_tmp = $request->file('image');
            $image_ext = $image_tmp->getClientOriginalExtension();
            $file_name = time() . rand(1, 999) . "." . $image_ext;
            Image::make($image_tmp)->save("images/banner/" . $file_name);
            $banner->image = $file_name;
        }
        $banner->save();
        return redirect()->back()->with('message', "Banner Added Successfully!");
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
        Session::put('pageTitle', 'Product Category ');
        $data = Banner::findOrFail($did);
        return view('admin.category.banner.edit', ['item' => $data]);
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
        $banner = Banner::find($did);
        $banner->title = $request->title;
        $banner->url = $request->url;
        if ($request->hasFile('image')) {
            $image_tmp = $request->file('image');
            $image_ext = $image_tmp->getClientOriginalExtension();
            $file_name = time() . rand(1, 999) . "." . $image_ext;
            unlink('images/banner/' . $banner->image);
            Image::make($image_tmp)->save("images/banner/" . $file_name);
            $banner->image = $file_name;
        }
        $banner->save();
        return redirect()->back()->with('message', 'Banner Updated!');
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
        $banner = Banner::find($did);
        unlink('images/banner/' . $banner->image);
        Banner::destroy($did);
        return redirect()->route('admin.banner.index')->with('message', "Banner Deleted Successfull!");
    }
}
