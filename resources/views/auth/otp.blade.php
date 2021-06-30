@extends('layouts.app')

<title> Otp </title>

@section('content')
    <div class=" flex-container">
        <img class="close" src="{{asset('images/union.svg')}}">
            <div class="container">
                <div class=" row justify-content-center">
                    <div class="col-md-8">
                        <h3 style="text-align: center">Enter your code</h3>
                        <p class="center-text no-bottom-margin">We’ve sent a 4-digit code to +966{{ substr($mobile_number,1) ?? 'xxxxxxxxx' }}</p>
                        <p class="center-text"><a href="#">Edit Number</a></p>

                                    <div class="form-group row justify-content-center">
                                        <div class="center-div">
                                            <input id="otp-field-1" class="otp-field {{ $errors->has('city') ? 'input-error' : '' }}" width="10px" maxlength="1" onkeyup="selectedField(this); moveCursor(this,'otp-field-2');checkOtpLength();">
                                            <input id="otp-field-2" class="otp-field {{ $errors->has('city') ? 'input-error' : '' }}" width="10px" maxlength="1" onkeyup="selectedField(this);moveCursor(this,'otp-field-3');checkOtpLength();">
                                            <input id="otp-field-3" class="otp-field {{ $errors->has('city') ? 'input-error' : '' }}" width="10px" maxlength="1" onkeyup="selectedField(this);moveCursor(this,'otp-field-4');checkOtpLength();">
                                            <input id="otp-field-4" class="otp-field {{ $errors->has('city') ? 'input-error' : '' }}" width="10px" maxlength="1" onkeyup="selectedField(this);checkOtpLength();">
                                        </div>
                                    </div>
                        <div class="divider">
                            <p id="resend-text" class="center-text">Resend code in: <span style="color: #6D747A" id="countdown" class="countdown"></span></p>
                            <form id="resendForm" method="POST" action="{{ route('loginWithOtp') }}" content="application/json; charset=UTF-8">
                                {{ csrf_field() }}
                                <input id="mobile_number" name="mobile_number" class="form-control" width="100px" maxlength="4" value="{{ $mobile_number }}" hidden>
                                <p id="resend-code" onclick="resetTimer(); submitResendForm();" class="center-text light-link" hidden><a href="">Resend code</a></p>
{{--                                <button id="resend-code" onclick="resetTimer(); submitResendForm();" class="center-text light-link" hidden>resend</button>--}}
                            </form>
{{--                            <p class="center-text error"><a href="{{ Session::get('message') }}">Resend code</a></p>--}}
                        </div>
{{--                                                            {{ route('reservations.create', $index['id']) }} --}}
                        <form id="otpForm" method="POST" action="{{ route('verifyOtpLogin') }}" content="application/json; charset=UTF-8">
                            {{ csrf_field() }}
                            <input id="mobile_number" name="mobile_number" class="form-control" width="100px" maxlength="4" value="{{ $mobile_number }}" hidden>
                            <input id="otp" name="otp" class="form-control" width="100px" maxlength="4" hidden>
                            <div class="form-group row justify-content-center">
                                <div class="col-md-6">
                                    <button id="login-btn" onclick="submitDigits(); submitForm()" class="btn btn-lg btn-block disable-btn">Sign In</button>
                                </div>
                            </div>

                        </form>
                        </div>
                    </div>
                </div>
    </div>
    </div>

    <script type="text/javascript">
            $('#resend-text').addClass('disabled');
            // $('#login-btn').removeClass('disable-btn');
            timer();
            function timer(){
                var seconds
                    ,countDiv = document.getElementById('countdown')
                    ,secondPass
                    ,countdown;

                //seconds = prompt("enter time by seconds");
                seconds = 59;
                countdown = setInterval(function(){
                    "use strict";

                    secondPass();
                }, 1000);

                function secondPass(){
                    "use strict";
                    var minute = Math.floor(seconds / 60),
                        remSeconds = seconds % 60;


                    if(seconds < 10){
                        remSeconds = "0" + remSeconds;
                    }


                    // if(remSeconds < 10){
                    //     remSeconds = "0" + remSeconds;
                    // }

                    if(minute < 10){
                        minute = "0" + minute;
                    }
                    countDiv.innerHTML = minute + " : " + remSeconds;

                    if(seconds > 0){
                        seconds--;
                    }
                    else{
                        clearInterval(countdown)
                        // countDiv.innerHTML = "OTP has expired";
                        $('#resend-text').attr('hidden', 'true');
                        $('#resend-code').removeAttr('hidden', 'true');
                    }
                }
            }
        function checkOtpLength(){

           if($('#otp-field-1').val() == null || $('#otp-field-2').val() == null || $('#otp-field-3').val() == null || $('#otp-field-4').val() == null){
               $('#login-btn').removeClass('button');
               $('#login-btn').addClass('disable-btn');
           }
           if($('#otp-field-1').val() != null || $('#otp-field-2').val() != null || $('#otp-field-3').val() != null || $('#otp-field-4').val() != null){

               $('#login-btn').removeClass('disable-btn');
               $('#login-btn').addClass('button');

           }
        }
        function resetTimer(){
            $('#resend-text').removeAttr('hidden', 'true');
            $('#resend-code').attr('hidden', 'true');
            seconds = 59;
            timer();
        }

        function submitForm(){
            //alert($('#otp').val())
            //Check if submitted field is not a number
            if(isNaN($('#otp').val())){
                alert('error');
            }
            $('#otpForm').submit();
        }

        function submitResendForm(){
            $('#resendForm').submit();
        }

        function submitDigits(){
            var digit1 = document.getElementById("otp-field-1").value;
            var digit2 = document.getElementById("otp-field-2").value;
            var digit3 = document.getElementById("otp-field-3").value;
            var digit4 = document.getElementById("otp-field-4").value;
            document.getElementById("otp").value = digit1 + digit2 + digit3 + digit4;
        }

        function selectedField(fromTextBox){

            //remove input if its not a not a number
            if(isNaN(fromTextBox.value)){
                document.getElementById(fromTextBox.id).value = "";
            }
        }

        function moveCursor(fromTextBox, toTextBox)
        {
            // Get the count of characters in fromTextBox
            var length = fromTextBox.value.length;
            // Get the value of maxLength attribute from the fromTextBox
            var maxLength = fromTextBox.getAttribute("maxlength");
            if (length == maxLength)
            {
                // If the number of charactes typed in the fromText is
                // equal to the maxLength attribute then set focus on
                // the next textbox
                document.getElementById(toTextBox).focus();
            }
    }


    </script>

@endsection
