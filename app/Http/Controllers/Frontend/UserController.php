<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Sms;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Str;

class UserController extends Controller
{
    // showing login and registration page
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('frontend.user.account');
        }
        Session::put('pagetitle', 'Registration');
        $cartitems = Cart::getCartItems();
        $numberOfCartItem = count($cartitems);
        Session::put('numberOfCartItem', $numberOfCartItem);
        return view('frontend.logres');
    }
    public function register(Request $request)
    {
        if (Auth::check()) {
            return redirect()->back();
        }
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|min:11|max:11',
            'password' => 'required|min:5|max:11',
        ]);
        $code = Str::random(6);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->code = $code;
        $user->mobile = $request->mobile;


        // //send sms
        // $msgResult = Sms::sendmessage($request->phone, "Hello ".$request->name." Your Varification code is :". $code);
        // return redirect()->route('frontend.user.varificationview')->with('success_msg', $msgResult['msg']);

        if ($user->save()) {
            // send confirmation email
            $email = $request->email;
            $messageData = ['name' => $request->name, 'mobile' => $request->mobile, 'email' => $email, 'id' => $user->id];
            Mail::send('email.registration', $messageData, function ($message) use ($email) {
                $message->to($email)->subject("Welcome to AdvEcommerce !");
            });
            Cart::makeCartForUser();
            return redirect()->back()->with('success_msg', 'En email has been sent to you email account ' . $user->email . " . Please check your email and verify you account.");
        }
        return redirect()->back()->with('error_msg', 'Something wrong, Please try again.');
    }


    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect()->back()->with('error_msg', 'You are already loged-in.');
        }
        $requestUser = User::where('email', $request->email)->firstOrFail();
        if ($requestUser->status == 1) {
            if (Auth::attempt($request->only('email', 'password'))) {
                Cart::makeCartForUser();
                return redirect()->route('frontend.cart.index');
            }
        } else {
            return redirect()->back()->with('error_msg', 'Please confirm you account, an email has been sent to your email address !.');
        }
        return redirect()->back()->with('error_msg', 'Credential not matched.');
    }
    public function account()
    {
        return view('frontend.myaccount');
    }
    public function logout()
    {
        Cart::cleanUserCart();
        Auth::logout();
        return redirect()->route('frontend.cart.index');
    }
    public function emailunickness(Request $request)
    {
        $userCount = User::where('email', $request->email)->count();
        if ($userCount > 0) {
            return false;
        }
        return true;
    }
    public function updateuser(Request $request)
    {
        $user = User::find(Auth::id());
        $user->fill($request->only('address', 'mobile', 'city', 'state', 'country', 'postcode'))->save();
        return redirect()->back()->with('success_msg', 'Profile Updated');
    }


    // for sms
    // public function varificationview()
    // {
    //     Session::put('pagetitle', 'SMS Varification');
    //     return view('frontend.varificationview');
    // }
    // public function varification(Request $request)
    // {
    //     $userCount = User::where('code', $request->code)->get()->count();
    //     if ($userCount > 0) {
    //         User::where('code', $request->code)->update(['email_verified_at' => now()]);
    //         return redirect()->back()->with('success_msg', 'Varification Successfull !');
    //     }
    //     return redirect()->back()->with('error_msg', 'Varification Failed !');
    // }

    // for email
    public function accountverify(Request $request, $id)
    {
        $did = Crypt::decryptString($id);
        $user = User::findOrFail($did);
        $user->status = 1;
        if ($user->save()) {
            return redirect()->route('frontend.logreg.index')->with('success_msg', "You account successfully activated. Please login");
        }
        return redirect()->route('frontend.logreg.index')->with('error_msg', "Something error, Please try again.");
    }

    public function forgotpassview()
    {
        Session::put('pagetitle', 'Forgot Password');
        return view('frontend.forgotpass');
    }
    public function forgotpass(Request $request)
    {
        $email = $request->email;
        $newpassword = Str::random(6);
        $userCount = User::where('email', $email)->get()->count();
        if($userCount > 0){
            $user = User::where('email', $email)->first();
            if ($user->status == 0) {
                return redirect()->back()->with('error_msg', 'Please confirm your account first !');
            }
            if ($user->status == 1) {
                $user->password = Hash::make($newpassword);
                if ($user->save()) {
                    $messageData = ['name' => $user->name, 'mobile' => $user->mobile, 'password' => $newpassword];
                    Mail::send('email.forgotpass', $messageData, function($message) use($email){
                        $message->to($email)->subject('New Password-AdvEcommerce.');
                    });
                    return redirect()->back()->with('success_msg',"Dear ". $user->name . ', new password has sent to your email.');
                } else {
                    return redirect()->back()->with('error_msg', 'Something Error, Please try again.');
                }
            }
        }
        return redirect()->back()->with('error_msg', 'Email does not exist. Please register first.');
    }
}
