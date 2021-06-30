<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{

    public function startPage()
    {
//            Session::flush();
        return view('auth.start');
    }

    public function login()
        {
//            Session::flush();
            return view('auth.login');
        }
    public function quickLogin()
    {
//            Session::flush();
        return view('auth.quicklogin');
    }

    public function registerPage()
    {
//        Session::flush();
        $city_list =  Http::get('173.212.205.167/api/v1/cities')->json();
        //dd($city_list);
        return view('auth.register', compact('city_list'));
    }
    public function requestOtp(Request $request)
    {
        $mobile_number = $request->resend_number;
        $user_info = Http::withToken(session()->get('user_info')['access_token'])->get('173.212.205.167/api/v1/request-otp')->json();

        return view('auth.otp', compact('mobile_number'));
    }

    public function verifyAccountLogin(Request $request)
    {
        $access_token = session()->get('user_info')['access_token'];

        $user_info = Http::asForm()->post('173.212.205.167/api/v1/login-otp', [
            'mobile_number' => $request->mobile_number
        ])->json();

        $mobile_number = substr($request->mobile_number,1);
        //we need another otp page so that we use requestOtp and VerifyAccountOtp
        return view('auth.otp', compact('mobile_number'));
    }

    public function loginWithOtp(Request $request)
    {

        $this->validate($request, [
            'mobile_number' => 'Required|regex:/^([0-9\s\-\+\(\)]*)$/|numeric'
        ]);

        $user_info = Http::asForm()->post('173.212.205.167/api/v1/login-otp', [
            'mobile_number' => $request->mobile_number
        ])->json();
        //dd($user_info);
        $mobile_number = $request->mobile_number;
        //we need another otp page so that we use requestOtp and VerifyAccountOtp
        return view('auth.otp', compact('mobile_number'));

    }

    public function sendQR(Request $request)
    {

        $this->validate($request, [
            'mobile_number' => 'Required|regex:/^([0-9\s\-\+\(\)]*)$/|numeric'
        ]);
        //perform api call
//        $user_info = Http::asForm()->post('173.212.205.167/api/v1/login-otp', [
//            'mobile_number' => $request->mobile_number
//        ])->json();
//        //dd($user_info);
        //if response if false get in
        if(1){
//            Validator::make($request->all(), [
//                'mobile_number' => ['Required', function($attribute, $value, $fail){
//                    $fail('Reservation is not available at these times');
//
//                }]
//            ])->validate();

//            session()->put('title', 'false');

            $mobile_number ='';
            $title = false;
            return view('auth.qrsent', compact('mobile_number', 'title'));
        }
        //else successful
        $mobile_number = $request->mobile_number;
        $title = true;
        return view('auth.qrsent', compact('mobile_number', 'title'));

    }

    public function verifyOtpLogin(Request $request)
    {
        $mobile_number = $request->mobile_number;

        $access_token = session()->get('user_info')['access_token'];

//        $request->mobile_number =$request->mobile_number;
        $this->validate($request, [
            'mobile_number' => 'Required|regex:/^([0-9\s\-\+\(\)]*)$/|numeric',
        ]);

        $user_info = Http::asForm()->post('173.212.205.167/api/v1/verify-otp-login', [
            'mobile_number' => $request->mobile_number,
            'otp' => $request->otp
        ])->json();

        $profile_info = Http::withToken($user_info['access_token'])->get('173.212.205.167/api/v1/profile')->json();
        session()->put('profile_info', $profile_info);

        $get_banner = Http::withToken($user_info['access_token'])->get('173.212.205.167/api/v1/banners')->json();

        if(array_key_exists("access_token",$user_info)){
            $park_list = Http::withToken($user_info['access_token'])->get('173.212.205.167/api/v1/parks')->json();
            $user_token = $user_info['access_token'];
            return view('home.homepage',compact('park_list', 'user_token', 'get_banner'));
            //return redirect('/reservations');
        }
        //Redirect::back()->with('message','Operation Successful !');
//        return redirect()->back();
        $user_info['access_token'] = $access_token;
        return view('auth.otp', compact('mobile_number', 'user_info'));

        //proceed to login
//        return view('auth.login');
    }
    public function register(Request $request)
    {

//        $this->validate($request, [
//            'first_name' => ['Required', function($attribute, $value, $fail){
//
//            }],
//            'last_name' => 'Required',
//            'email' => 'email',
//            'mobile_number' => 'Required|regex:/^([0-9\s\-\+\(\)]*)$/|numeric',
//            'city' => 'Required',
//            'check' => 'Required',
//        ]);
       $validator =  Validator::make($request->all(), [
            'first_name' => 'Required',
            'last_name' => 'Required',
            'email' => 'email',
            'mobile_number' => 'Required|regex:/^([0-9\s\-\+\(\)]*)$/|numeric',
            'city' => 'Required',
            'check' => 'Required',
        ])->validate();

//        if($validator->fails()) {
//            return redirect()->route('auth.register', [])->withErrors($validator);
//        }

        $user_info = Http::asForm()->post('173.212.205.167/api/v1/register', [
            'email' => $request->email,
            'name' => $request->name,
            'mobile_number' => $request->mobile_number
        ])->json();
//        dd($user_info);

        $mobile_number = $request->mobile_number;
        session()->put('user_info', $user_info);
//      dd(session()->get('user_info')['access_token']);
        return view('auth.otp', compact('mobile_number'));


    }
    public function logout()
    {
        Session::flush();
        return view('auth.login');
    }

}
