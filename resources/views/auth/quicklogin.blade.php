@extends('layouts.app')

<title>Login</title>

@section('content')
    {{--<img src="{{asset('images/business.svg')}}">--}}
<div class="flex-container">
    <img class="close" src="{{asset('images/union.svg')}}">
    <div class="container">
        <div class=" row justify-content-center">
            <div class="col-md-8">
                <form method="POST" action="{{ route('sendQR') }}" content="application/json; charset=UTF-8">
                    @csrf
                    <div class="form-group row justify-content-center">
                        <div class="auth-image">
                           <img src="{{asset('images/business.svg')}}" />
                        </div>
                    </div>
                    <div class="form-group row justify-content-center">
                        <div class="col-md-12">
                    <h3 class="center-text">Quick Login to IParking</h3>
                        </div>
                    </div>
                    <div class="form-group row justify-content-center">
                        <div class="col-md-6">
                            <div class="input-img-wrapper">
                                <input style="" class="form-control text-field {{ $errors->has('mobile_number') ? 'input-error' : '' }}" name="mobile_number" id="mobile_number" placeholder="Mobile Number*" value="{{ old('mobile_number', '')}}">
                                <img class="field-icon" src="{{asset('images/phone.svg')}}">
                            </div>
                            @if($errors->has('mobile_number'))
                                <span class="error">{{ $errors->first('mobile_number') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="divider-lg">

                    </div>
                    <div class="form-group row justify-content-center">
                        <div class="col-md-6">
                            <button type="submit" class="button btn btn-lg btn-block">Next</button>
                        </div>
                    </div>
                    <div class="form-group row justify-content-center">
                        <div class="col-md-6">
                            <p class="register-text center-text">
                                Want to join? <a href="{{('/register-page')}}" class="link">Click here to sign up</a>
                            </p>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
