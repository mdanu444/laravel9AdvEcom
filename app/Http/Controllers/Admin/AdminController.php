<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    function check(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|max:12|min:5'
        ]);
        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            return redirect()->route('admin.home');
        }
        return redirect()->back()->with('message', 'Credentials not matched.');
    }
    function save(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:admins,email',
            'name' => 'required',
            'phone' => 'required|min:11|max:11',
            'photo' => 'required|image|mimes:png,jpg,jpeg',
            'password' => 'required|max:12|min:5'
        ]);
        $photoName = time() . '.' . $request->file('photo')->getClientOriginalExtension();
        $photo = $request->file('photo')->storeAs('adminPhoto', $photoName, 'public');;
        $admin = new Admin;
        $admin->name = $request->name;
        $admin->photo = $photo;
        $admin->phone = $request->phone;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->save();
        return redirect()->back()->with('message', 'Registration Successfull');
    }

    function changepse(Request $request)
    {
        $request->validate([
            'oldp' => 'required|min:5|max:12',
            'newp' => 'required|min:5|max:12',
            'confirmp' => 'required|same:newp',
        ], [
            'oldp.required' => "The old password feild is required and should be correct",
            'oldp.min'      => "The old password feild is required and should be correct",
            'oldp.max'      => "The old password feild is required and should be correct",
            'newp.required' => "The old password feild is required and should be correct",
            'newp.min'      => "The New password feild is required and should be correct",
            'newp.max'      => "The New password feild is required and should be correct",
            'confirmp.required' => "The Confirm password  should be same as new",
        ]);
        $admin = Admin::find(Auth::guard('admin')->id());
        if (Hash::check($request->oldp, $admin->password)) {
            $admin->password = Hash::make($request->newp);
            $admin->save();
            return redirect()->back()->with('message', 'Password updated Successfully');
        }
        return redirect()->back()->with('message', 'Old password pid not matched.');
    }


    function profileview()
    {
        Session::put('pageTitle', "Profile");
        Session::put('activer', "Update Profile");
        return view('admin.profile.profile-update');
    }

    function profileupdater(Request $request)
    {
        $admin = Admin::find(Auth::guard('admin')->id());
        if ($request->hasFile('photo')) {
            // return $request->file('photo');
            $request->validate([
                'name' => 'required',
                'phone' => 'required|min:11|max:11',
                'photo' => 'required|mimes:jpg,jpeg,png',
            ]);
            if (Storage::delete(($admin->photo))) {
                $photoName = time() . '.' . $request->file('photo')->getClientOriginalExtension();
                $photo = $request->file('photo')->storeAs('adminPhoto', $photoName);
                $admin->name = $request->name;
                $admin->photo = $photo;
                $admin->phone = $request->phone;
                $admin->email = $request->email;
                $admin->save();
            }
            return redirect()->back()->with('message', 'Profile Updated Successfully.');
        } else {
            $request->validate([
                'name' => 'required',
                'phone' => 'required|min:11|max:11',
            ]);
            $admin->name = $request->name;
            $admin->phone = $request->phone;
            $admin->email = $request->email;
            $admin->save();
            return redirect()->back()->with('message', 'Profile Updated Successfully.');
        }
        return redirect()->back()->with('message', 'Profile can not update');
    }
}
