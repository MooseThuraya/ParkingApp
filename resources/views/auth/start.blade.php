@extends('layouts.app')

<title>Start Page</title>

@section('content')
    {{--<img src="{{asset('images/business.svg')}}">--}}
{{--<div style="background-color: #FFD900" class="flex-container">--}}
    <div style="background-color:  #053361" class="flex-container">
    <img class="close" src="{{asset('images/union.svg')}}">
    <div class="container">
        <div class=" row justify-content-center">
            <div class="col-md-8">
                    <div class="form-group row justify-content-center">
{{--                        <div class="start-image">--}}
{{--                           <img src="{{asset('images/iparkinglogonavy.svg')}}" />--}}
{{--                        </div>--}}
                        <div class="start-image">
                            <img src="{{asset('images/iparkinglogowhite.svg')}}" />
                        </div>
                    </div>
                    <div class="center-text">
{{--                        <h3 class="center-text">Welcome to IParking!</h3>--}}
                        <h3 style="color: white" class="center-text">Welcome to <span class="iparking-text">IParking!</span></h3>
                    </div>

                    <div class="form-group row justify-content-center">
                        <div class="col-md-6">
                            <a style="text-decoration: none" href="{{'/login-page'}}"><button type="submit" class="start-button btn btn-lg btn-block">REGISTER OR LOG IN</button></a>
                            <div class="divider-10">
                            </div>
                            <a style="text-decoration: none" href="{{'/quick-login'}}"><button type="submit" class="return-button btn btn-lg btn-block">QUICK LOG IN</button></a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
