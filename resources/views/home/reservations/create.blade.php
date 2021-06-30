@extends('layouts.home')

<title> Reserve </title>

@section('content')
    <div class="flex-form">
        <div class="container">
            <div class=" row justify-content-center">
                <div class="col-md-8">
                    <div class="form-group row justify-content-center">
                        <div class="col-md-12">
                            <h3 class="center-text">Reserve at {{$reservation_id['en_name']}}!</h3>
                        </div>
                    </div>

                    <form id="reservationForm"  method="POST" action="{{ route('reservationDetails') }}" content="application/json; charset=UTF-8">
                        {{ csrf_field() }}

                        <div class="inputs-wrapper">
                            <input class="form-control text-field" name="park_id" id="park_id" value="{{$reservation_id['id']}}" hidden>
                            <input class="form-control text-field" name="en_name" id="en_name" value="{{$reservation_id['en_name']}}" hidden>
                            <div class="form-group row justify-content-center">
                                <div class="col-md-6 validate-input">
                                    <div class="input-img-wrapper">
                                        <select class="form-control selected text-field {{ $errors->has('type') ? 'input-error' : '' }}" onchange="checkReservation()" name="type" id="type" form="reservationForm" value="{{ old('type', '') }}">
                                            <option hidden selected value="">Choose a type*</option>
                                            <option value="VIP">VIP</option>
                                            <option value="NORMAL">Normal</option>
                                            <option value="FREE">Free</option>
                                        </select>
                                        <img class="field-icon city-icon" src="{{asset('images/city.svg')}}">
                                    </div>
                                    @if($errors->has('type'))
                                        <span class="error">{{ $errors->first('type') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row justify-content-center">
                            <div class="col-md-6 validate-input">
                                <div class="input-img-wrapper">
                                <input class="form-control text-field datetime {{ $errors->has('start_datetime') ? 'input-error' : '' }}" onblur="checkReservation(); addEndTime();" name="start_datetime" id="start_datetime" placeholder="Start Time*" value="{{ old('start_datetime', '') }}">
                                <img class="field-icon" src="{{asset('images/lastname.svg')}}">
                                </div>
                                @if($errors->has('start_datetime'))
{{--                                    <span class="error">{{ $errors->first('start_datetime') }}</span>--}}
                                @endif

                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <div class="col-md-6">
                                <div class="input-img-wrapper">
                                <input class="form-control text-field datetime {{ $errors->has('end_datetime') ? 'input-error' : '' }}" onblur="checkReservation()" name="end_datetime" id="end_datetime" placeholder="End Time*" value="{{ old('end_datetime', '') }}">
                                <img class="field-icon" src="{{asset('images/lastname.svg')}}">
                                </div>
                                @if($errors->has('end_datetime'))
                                    <span class="error">{{ $errors->first('end_datetime') }}</span>
                                @endif
                                <span id="start_datetime_error" class="error" hidden>Reservation is not available at these times</span>
                            </div>
                        </div>



                            <div class="form-group row justify-content-center">
                                <div class="col-md-6">
                                    <div class="input-img-wrapper">
                                        <input class="form-control text-field {{ $errors->has('discount_code') ? 'input-error-discount' : '' }}" oninput="checkReservation()" name="discount_code" id="discount_code" placeholder="Discount Code" value="{{ old('discount_code', '') }}">
                                        <img class="field-icon" src="{{asset('images/lastname.svg')}}">
                                    </div>
                                    @if($errors->has('discount_code'))
                                        <span class="error-discount">{{ $errors->first('discount_code') }}</span>
                                    @endif
                                </div>
                            </div>


                        </div>
                        <div class="form-group row justify-content-center">
                            <div class="col-md-6">
                                <button id="submit-btn" onclick="concatNames(); submitForm();" class="button btn btn-lg btn-block disable-btn">Payment Details</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script type="text/javascript">





        $(document).ready(function () {
            $('.datetime').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
                locale: 'en',
                sideBySide: true,
                icons: {
                    up: 'fas fa-chevron-up',
                    down: 'fas fa-chevron-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right'
                }
            })
        })


        function addEndTime(){
            var start_datetime = document.getElementById("start_datetime").value;

            {{--var min_reservation_time = '{{$reservation_id['minimum_time']}}';--}}

            // var min_reservation_time = min_reservation_time.replace(":", "-");

            // var min_reservation_time_test = new Date(min_reservation_time.replace(/-/g,"/"));
            // var min_reservation_time_test = new Date(min_reservation_time);
            // alert(min_reservation_time_test);
            // alert(min_reservation_time_test.getMinutes());
            var endDate = new Date(start_datetime.replace(/-/g,"/"));
            // alert(date_test)
            // alert(date_test.getMinutes());
            var hms = '{{$reservation_id['minimum_time']}}';
            var a = hms.split(':'); // split it at the colons

            // minutes are worth 60 seconds. Hours are worth 60 minutes.
            var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);

            {{--            {{$time_add = \Carbon\Carbon::parse()}}--}}
            endDate.setMinutes( endDate.getMinutes() + (seconds/60) );

            let current_datetime = new Date()
            let formatted_date = endDate.getFullYear() + "-" + appendLeadingZeroes(endDate.getMonth() + 1) + "-" + appendLeadingZeroes(endDate.getDate()) + " " + appendLeadingZeroes(endDate.getHours()) + ":" + appendLeadingZeroes(endDate.getMinutes()) + ":" + appendLeadingZeroes(endDate.getSeconds())
            $('#end_datetime').val(formatted_date);

        }
        function appendLeadingZeroes(n){
            if(n <= 9){
                return "0" + n;
            }
            return n
        }

        function checkReservation() {

            // "type" => $type,
            // "park_id"=> $park_id ,
            // "start_datetime"=> $request->start_datetime,
            // "end_datetime" => $request->end_datetime,
            // "discount_code" => $request->discount_code,
            // "payment_id"=> -1,
            // alert($('#discount_code').val())

            if($('#start_datetime').val() != "" && $('#end_datetime').val() != "" && $('#type').val() != ""){
                // alert('im passed if')
                var reservationData = {
                    type: $('#type'),
                    park_id: $('#park_id'),
                    start_datetime: $('#start_datetime'),
                    end_datetime:   $('#end_datetime'),
                    discount_code: $('#discount_code'),
                };
                {{--$.ajax({--}}
                {{--    async: true,--}}
                {{--    type: 'POST',--}}
                {{--    url: '{{route('checkReservation')}}',--}}
                {{--    data: JSON.stringify(reservationData),--}}
                {{--    dataType: 'JSON',--}}
                {{--    contentType: 'application/json;charset=utf-8',--}}
                {{--    success: function (data) {--}}
                {{--        if (data) {--}}
                {{--            alert('im successful');--}}
                {{--        }--}}
                {{--    },--}}
                {{--    error: function () {--}}
                {{--        alert("There was a problem with checking times.")--}}
                {{--    }--}}
                {{--})--}}


                $.ajax({
                    url: "{{route('checkReservation')}}",
                    type: "POST",
                    data: {
                        type: $('#type').val(),
                        park_id: $('#park_id').val(),
                        start_datetime: $('#start_datetime').val(),
                        end_datetime:   $('#end_datetime').val(),
                        discount_code: $('#discount_code').val(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        // alert(data.status);
                        if (data.status == false) {
                            throwError(false);
                        }else{
                            throwError(true);
                        }
                    },
                    error: function () {
                        alert('There was a problem with checking times');
                    }
                })

            }

        }
        function throwError(status){
            // alert('in throwError')
            if(!status){
                $("#start_datetime").addClass("input-error");
                $("#end_datetime").addClass("input-error");
                // $("#start_datetime_error").attr('hidden','true');
                // document.getElementById("start_datetime_error").setAttribute("hidden", false);
                document.getElementById("start_datetime_error").removeAttribute('hidden')
                $("#submit-btn").addClass("disable-btn");

            }else{
                $("#start_datetime").removeClass("input-error");
                $("#end_datetime").removeClass("input-error");
                // $("#start_datetime_error").attr('hidden', 'false');
                document.getElementById("start_datetime_error").setAttribute("hidden", true);
                $("#submit-btn").removeClass("disable-btn");
            }
        }

        const myForm = document.getElementById('registerForm');
        function submitForm(){
            $('#registerForm').submit();
        }

        function concatNames(){
            $('#user_identifier').val($('#firstname').val() + '_' + $('#mobile_number').val());
            $('#name').val($('#firstname').val() + ' ' + $('#lastname').val());
        }

    </script>
@endsection
