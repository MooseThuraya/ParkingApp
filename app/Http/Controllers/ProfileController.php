<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    public function index()
    {

        $profile_info = Http::withToken(session()->get('user_info')['access_token'])->get('173.212.205.167/api/v1/profile')->json();
        $splitName = explode(' ', $profile_info['user']['name'], 2);
        $profile_info['user']['first_name'] = $splitName[0];
        $profile_info['user']['last_name'] = $splitName[1];

//        dd(session()->get('user_info'));

        return view('home.profile.index', compact('profile_info'));
    }
}
