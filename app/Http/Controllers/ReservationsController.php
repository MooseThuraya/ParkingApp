<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Ramsey\Uuid\Type\Integer;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\Console\Input\Input;

class ReservationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $server_ip = 'server_ip'
        $reservation_list = Http::withToken(session()->get('user_info')['access_token'])->get($server_ip.'/api/v1/user-reservations')->json();
        $park_list = Http::withToken(session()->get('user_info')['access_token'])->get($server_ip.'/api/v1/parks')->json();

        $park_list = collect($park_list['data']);

        foreach($reservation_list as $i => $index) {
           $en_name = $park_list->where('id', $index['park_id'])->pluck('en_name')[0];
           $index['en_name'] = $en_name;
           $reservation_list[$i] =$index;
        }


    return view('home.reservations.index', compact('reservation_list'));

    }
    public function checkReservation(Request $request)
    {
        $server_ip = 'server_ip'
        Debugbar::info('just got in checkReservation');
        //store access token
        $access_token = session()->get('user_info')['access_token'];

        //check if discount code is null, enter default value
        if($request->discount_code == null){
            $request->discount_code = "NONE";
        }
        $is_reservation_available = Http::withToken($access_token)->post($server_ip.'/api/v1/reservations_check',
            [
                "type" => $request->type,
                "park_id"=> $request->park_id ,
                "start_datetime"=> $request->start_datetime,
                "end_datetime" => $request->end_datetime,
                "discount_code" => $request->discount_code,
                "payment_id"=> -1,
            ]
        )->json();

        if(!$is_reservation_available['status']){
            Debugbar::info('im status false');
            $status = false;
            return response()->json(array('status'=> $status));

        }
        $status = true;
//            return view('home.reservations.create', compact('status'));
        return response()->json(array('status'=> $status));

    }
    public function reservationDetails(Request $request)
    {
        $discountIsNull = false;
        //check if discount code is null, enter default value
        if($request->discount_code == null){
            $request->discount_code = "none";
            $discountIsNull = true;
        }

        //this level of data validation is to ensure that the api requests do not crash
        Validator::make($request->all(), [
            'type' => 'Required',
            'start_datetime' => ['required', 'date'],
            'end_datetime' => ['required', 'date']
        ])->validate();

        $reservation_details = $request;
        $access_token = session()->get('user_info')['access_token'];
        $park_id = (int)$request->park_id;
        $type = strtoupper($request->type);
        $server_ip = 'server_ip'
        $is_reservation_available = Http::withToken($access_token)->post($server_ip.'/api/v1/reservations_check',
            [
                "type" => $type,
                "park_id"=> $park_id ,
                "start_datetime"=> $request->start_datetime,
                "end_datetime" => $request->end_datetime,
                "discount_code" => $request->discount_code,
                "payment_id"=> -1,
            ]
        )->json();

        if(!$is_reservation_available['status']){

            //this level of data validation is to ensure that the user knows that is the problem
            Validator::make($request->all(), [
                'start_datetime' => ['Required', function($attribute, $value, $fail){
                        $fail('Reservation is not available at these times');
                }],
                'end_datetime' => ['Required', function($attribute, $value, $fail){
                        $fail(' ');
                }]
            ])->validate();
        }

        $reservation_price = Http::withToken($access_token)->post($server_ip.'/api/v1/reservations_price',
            [
                "type" => $type,
                "park_id"=> $park_id ,
                "start_datetime"=> $request->start_datetime,
                "end_datetime" => $request->end_datetime,
                "discount_code" => $request->discount_code,
                "payment_id"=> -1,
            ]
        )->json();

        $total_before_discount = $reservation_price['price'];
        $total_after_discount = $reservation_price['price_discounted'];
        session()->put('total_before_discount', $total_before_discount);
        session()->put('total_after_discount', $total_after_discount);
        $profile_info = Http::withToken($access_token)->get($server_ip.'/api/v1/profile')->json();

        foreach ($profile_info as $value){
           $user_points =  $value['user_points'];
        }

        if($user_points >= $total_after_discount){
            $payment_status = true;
        }else{
            $payment_status = false;
        }

        //Requests now complete, we can empty value again if it was null
        if(!$discountIsNull){
            //this level of data validation is to ensure that the api requests received valid data
            Validator::make($request->all(), [
                'discount_code' => [ function($attribute, $value, $fail){
                    $total_before_discount = session()->get('total_before_discount');
                    $total_after_discount = session()->get('total_after_discount');

                    if($total_before_discount === $total_after_discount){
                        $fail('Discount code not valid');
                    }

                }]
            ])->validate();
        }

        //merge price with reservation details
        $reservation_details->merge(['total_after_discount' => $total_after_discount]);

        return view('home.reservations.show', compact('user_points', 'payment_status','total_before_discount', 'total_after_discount', 'reservation_details'));
    }
    public function reserve(Request $request)
    {   $server_ip = 'server_ip'
        //check if discount code is null, enter default value
        if($request->discount_code == null){
            $request->discount_code = "none";
        }

        $total_after_discount_string = session()->get('total_after_discount');
        $total_after_discount = (int)$total_after_discount_string;
        $access_token = session()->get('user_info')['access_token'];
        $add_payment = Http::withToken($access_token)->post($server_ip.'/api/v1/payment_add',
        [
            'points_count' => $total_after_discount,
            'transaction_status' => 'SUCCESS',
            'transaction_type' => 'POINTS',
            'transaction_number' => ''
        ]
        )->json();

        $park_id = (int)$request->park_id;
        $payment_id = (int)$add_payment['payment_id'];
        $type = strtoupper($request->type);
        $discount_code = strtoupper($request->discount_code);
            $add_reservation = Http::withToken($access_token)->post($server_ip.'/api/v1/reservations_add',
                [
                    "type" => $type,
                    "park_id"=> $park_id,
                    "start_datetime"=> (string)$request->start_datetime,
                    "end_datetime" => (string)$request->end_datetime,
                    "discount_code" => strtoupper($request->discount_code),
                    "payment_id"=> $payment_id,
                ]
            )->json();
            //refresh points value
            $profile_info = Http::withToken($access_token)->get($server_ip.'/api/v1/profile')->json();
            session()->put('profile_info', $profile_info);
//        dd($add_reservation);

//            dd($add_reservation);
            if(Arr::has($add_reservation, 'id')){
                $title= "The Payment was a Success";
                $message ="The reservation was a success! You may return to home.";
                return view('home.reservations.result', compact('title', 'message'));
            }


        return view('home.reservations.result');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $reservation_id)
    {
//        dd($reservation_id->request['2']);
//        foreach(array_keys($reservation_id->request) as $id){
//            dd($id);
//        }

        return view('home.reservations.create', compact('reservation_id'));
    }
    public function cancelReservation(Request $reservation_id)
    {   
        $server_ip = 'server_ip'
        //dd($reservation_id['Reservation_id']);
        //$request = $reservation_id->request;
        //$reservation_id = $request->get('id');
//        dd($reservation_id);
//        foreach($reservation_id->request as $value){
//            dd($value);
//        }
        $access_token = session()->get('user_info')['access_token'];
        $cancel_reservation = Http::withToken($access_token)->post($server_ip.'/api/v1/reservations_cancel', [
            'id' => $reservation_id['Reservation_id']
        ])->json();
        $profile_info = Http::withToken($access_token)->get($server_ip.'/api/v1/profile')->json();
        session()->put('profile_info', $profile_info);
        return redirect('/reservations');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $park_id)
    {

        //$payment_id = 2;

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
