<?php

namespace App\Http\Controllers;

use Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //login temporary
        $user_info = Http::post('173.212.205.167/api/v1/login',[
            'email' => 'zonday@gmail.com',
            'password' => 'password'
        ])->json();
        session()->put('user_info', $user_info);
        $profile_info = Http::withToken($user_info['access_token'])->get('173.212.205.167/api/v1/profile')->json();
        session()->put('profile_info', $profile_info);
        $banner ='';
        $get_banner = Http::withToken(session()->get('user_info')['access_token'])->get('173.212.205.167/api/v1/banners')->json();

//        foreach ($get_banner as $index){
//            foreach ($index as $value){
//                $banner = $value['image']['url'];
//            }
//        }

        $park_list = Http::withToken(session()->get('user_info')['access_token'])->get('173.212.205.167/api/v1/parks')->json();
        $user_token = session()->get('user_info')['access_token'];
        $profile_info = Http::withToken(session()->get('user_info')['access_token'])->get('173.212.205.167/api/v1/profile')->json();
        session()->put('profile_info', $profile_info);
//        dd($banner);

        return view('home.homepage', compact('park_list', 'user_token', 'get_banner'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
