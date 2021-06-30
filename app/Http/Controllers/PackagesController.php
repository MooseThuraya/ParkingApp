<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PackagesController extends Controller
{
    public function index()
    {
        $package_list = Http::withToken(session()->get('user_info')['access_token'])->get('173.212.205.167/api/v1/packages')->json();
//        dd($package_list);
        return view('home.packages.index', compact('package_list'));
    }
}
