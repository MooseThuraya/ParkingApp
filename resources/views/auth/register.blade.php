@extends('layouts.app')

<title> Register </title>

@section('content')
    <div class=" flex-container">
        <img class="close" src="{{asset('images/union.svg')}}">
    <div class="container">
        <div class=" row justify-content-center">
            <div class="col-md-8">
                <div class="form-group row justify-content-center">
                    <div class="col-md-6">
                        <h3>Sign up to IParking</h3>
                    </div>
                </div>
                    <form id="registerForm" method="POST" action="{{ route('register') }}" content="application/json; charset=UTF-8">
                        {{ csrf_field() }}
                            <div class="form-group row justify-content-center">
                                <div class="col-md-6">
                                    <div class="input-img-wrapper">
                                        <input class="form-control text-field {{ $errors->has('first_name') ? 'input-error' : '' }}" name="first_name" id="first_name" placeholder="First Name*"  value="{{ old('first_name', '') }}">
                                        <img class="field-icon" src="{{asset('images/firstname.svg')}}">
                                    </div>
                                        @if($errors->has('first_name'))
                                            <span class="error">{{ $errors->first('first_name') }}</span>
                                        @endif
                                </div>
                            </div>


                            <div class="form-group row justify-content-center">
                                <div class="col-md-6">
                                    <div class="input-img-wrapper">
                                    <input class="form-control text-field {{ $errors->has('last_name') ? 'input-error' : '' }}" name="last_name" id="last_name" placeholder="Last Name*" value="{{ old('last_name', '') }}">
                                    <img class="field-icon" src="{{asset('images/lastname.svg')}}">
                                    </div>
                                    @if($errors->has('last_name'))
                                        <span class="error">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>
                            </div>
                        <input class="form-control text-field " name="name" id="name" hidden>
{{--                        <input class="form-control text-field" name="user_identifier" id="user_identifier" hidden>--}}
{{--                        <input class="form-control text-field" name="password" id="password" value="password" hidden>--}}
                            <div class="form-group row justify-content-center">
                                <div class="col-md-6 validate-input" data-validate="Invalid email address">
                                    <div class="input-img-wrapper">
                                    <input class="form-control text-field {{ $errors->has('email') ? 'input-error' : '' }}" name="email" id="email" placeholder="Email" value="{{ old('email', '') }}">
                                    <img class="field-icon" src="{{asset('images/email.svg')}}">
                                    </div>
                                    @if($errors->has('email'))
                                        <span class="error">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="col-md-6 validate-input">
                                    <div class="input-img-wrapper">
                                    <input class="form-control text-field {{ $errors->has('mobile_number') ? 'input-error' : '' }}" name="mobile_number" id="mobile_number" placeholder="Phone Number*" value="{{ old('mobile_number', '') }}">
                                    <img class="field-icon" src="{{asset('images/phone.svg')}}">
                                    </div>
                                    @if($errors->has('mobile_number'))
                                        <span class="error">{{ $errors->first('mobile_number') }}</span>
                                    @endif
                                </div>
                            </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-6 validate-input">
                                <div class="input-img-wrapper">
                                <select class="form-control selected text-field {{ $errors->has('city') ? 'input-error' : '' }}" name="city" id="city" form="registerForm" value="{{ old('city', '') }}">
                                    <option hidden selected value="">City*</option>
                                    @foreach($city_list as $data)
                                        @foreach($data as $index)
                                            <option value="{{ $index['en_name'] ?? '' }}">{{ $index['en_name'] ?? '' }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                                <img class="field-icon city-icon" src="{{asset('images/city.svg')}}">
                                </div>
                                @if($errors->has('city'))
                                    <span class="error">{{ $errors->first('city') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-6">
                                    <input type="checkbox" id="check" name="check" hidden>
                                    <label for="check" class="checkmark  {{ $errors->has('check') ? 'input-error' : '' }}"></label>
                                    <p class="register-text check-text {{ $errors->has('check') ? 'error' : '' }}">
                                        By signing up, you agree to our <a href="#" ><span class="link">Terms</span></a> and <a href="#"><span class="link">Privacy Policy.</span></a>
                                    </p>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-6">
                                <button onclick="concatNames(); submitForm();" class="button btn btn-lg btn-block">Next</button>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-6">
                                <p class="register-text">
                                    Already have an account? <a href="{{('/login-page')}}" class="link">Click here to log in</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script type="text/javascript">
    // const myForm = document.getElementById('registerForm');

    // myForm.addEventListener('submit', function (e){
    //     e.preventDefault(); //prevent navigating away when submitting the form
    //
    //     const formData = new FormData(this);
    //
    //     const searchParams = new URLSearchParams();
    //
    //     for(const pair of formData){
    //                             //key, value
    //         searchParams.append(pair[0], pair[1]);
    //     }
    //
    //     fetch('http://173.212.205.167/api/v1/register', {
    //         method: 'POST',
    //         body: searchParams
    //
    //     }), headers:{
    //         "Content-Type":"application/json; charset=UTF-8"
    //     }
    // .then(function (response){
    //         console.log(response.text());
    //         return response.text();
    //     }).then(function (text){
    //         console.log(text);
    //     }).catch(function (error){
    //         console.error(error);
    //     })
    //
    // });

    function submitForm(){
        $('#registerForm').submit();
    }

    function concatNames(){
        $('#name').val($('#first_name').val() + ' ' + $('#last_name').val());
    }

    </script>
@endsection
