<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Upazila;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;

class AddressAjaxController extends Controller
{
    public function districts(Request $request){
        if(!empty($request->id)){
            $did = Crypt::decryptString($request->id);
            $data = District::where('division_id', $did)->get();
            $view = view('frontend.address_ajax.district', ['data' =>$data])->render();
            return ['html' => $view, 'status' => true];
        }
        return ['status' => false, 'msg' => 'Something wrong, Please try again.'];
    }
    public function upazilas(Request $request){
        if(!empty($request->id)){
            $did = Crypt::decryptString($request->id);
            $data = Upazila::where('district_id', $did)->get();
            $view = view('frontend.address_ajax.upaliza', ['data' => $data])->render();
            return ['html' => $view, 'status' => true];
        }
        return ['status' => false, 'msg' => 'Something wrong, Please try again.'];
    }
}
