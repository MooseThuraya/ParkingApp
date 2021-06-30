@extends('layouts.app')

<title>Login</title>

@section('content')
<div class="flex-container">
    <img class="close" src="{{asset('images/union.svg')}}">
    <div class="container">
        <div class=" row justify-content-center">
            <div class="col-md-8">
                    <div class="form-group row justify-content-center">
                        <div class="col-md-12">
                            @if($title)
                            <h3 class="center-text">QR Code sent!</h3>
                            <p class="center-text">Your QR Code has been sent to +966{{ substr($mobile_number,1) ?? 'xxxxxxxxx' }}</p>
                            @else
                                <h3 class="center-text">An Error Occurred</h3>
                                <p class="center-text">Please, try again.</p>
                            @endif
{{--                    <h3 class="center-text">Your QR Code has been sent to +966{{ substr($mobile_number,1) ?? 'xxxxxxxxx' }}</h3>--}}
                        </div>
                    </div>
                <div class="divider">
                </div>
                    <div class="form-group row justify-content-center">
                        <div class="col-md-6">
                            <a style="text-decoration: none" href="{{'/quick-login'}}"><button type="submit" class="button btn btn-lg btn-block">Return</button></a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
