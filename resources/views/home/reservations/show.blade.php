@extends('layouts.home')

<title> Reserve </title>

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 style="text-align: center; margin-top: 50px">Make a payment</h3>
                <br>
                        <form id="reservationForm"  method="POST" action="{{ route('reserve', $reservation_details) }}" content="application/json; charset=UTF-8">
{{--                        {{dd($reservation_details)}}--}}
                            {{ csrf_field() }}
                    <div class="payment-card">
                            <div class="payment-card-details-1">
                                <h5>Reservation Details</h5>
                                <table class="detail-content ">

                                    <tr>
                                        <td>
                                            <h6  class="list-location">Reservation id:</h6>
                                        </td>
                                        <td class="detail-content-col">
                                            <h6  class="reservation-data"> {{  $reservation_details->park_id ?? 'none' }}</h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h6  class="list-location">Location name:</h6>
                                        </td>
                                        <td class="detail-content-col">
                                            <h6  class="reservation-data"> {{  $reservation_details->en_name ?? 'none' }}</h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h6 class="list-location">Start time:</h6>
                                        </td>
                                        <td class="detail-content-col">
                                            <h6 class="reservation-data"> {{  $reservation_details->start_datetime ?? 'none' }}</h6>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <h6 class="list-location">End time:</h6>
                                        </td>
                                        <td class="detail-content-col">
                                            <h6 class="reservation-data"> {{  $reservation_details->end_datetime ?? 'none' }}</h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h6 class="list-location">Park Type:</h6>
                                        </td>
                                        <td class="detail-content-col">
                                            <h6 class="reservation-data"> {{  $reservation_details->type ?? 'none' }}</h6>
                                        </td>
                                    </tr>
                                    <tr id="discount-row">
                                        <td>
                                            <h6 class="list-location">Discount:</h6>
                                        </td>
                                        <td class="detail-content-col">
                                            <h6 class="reservation-data"> {{  $reservation_details->discount_code ?? 'none' }}</h6>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="payment-card-details-2">
                            <h5 class="">Payment Details</h5>
                            <table class="detail-content">
                                <tr>
                                    <td>
                                        <h6 class="list-location"> Account Balance: </h6>
                                    </td>
                                    <td class="detail-content-col">
                                        <h6 class="reservation-data">{{  $user_points ?? 'none' }} Points</h6>
                                    </td>
                                </tr>

                                <tr id="before-discount-row">
                                    <td>
                                        <h6 class="list-location">Before Discount:</h6>
                                    </td>
                                    <td class="detail-content-col">
                                        <h6 class="reservation-data">{{  $total_before_discount ?? 'none' }} Points</h6>
                                    </td>
                                </tr>

                                <tr class="ts-total-row">
                                    <td>
                                        <h6 class="list-location grand-total">Grand Total: </h6>
                                    </td>
                                    <td class="detail-content-col">
                                        <h6 class="reservation-data grand-total" id="total">{{$total_after_discount ?? ''}} Points</h6>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        </div>
                            <p id="error-message" class="error-message">* Insufficient Funds</p>
                            <br>
                        <div class="form-group row justify-content-center">
                            <div class="col-md-6">
{{--                                {{ route('reserve', array(['total_after_discount' => $total_after_discount])) }}--}}
                                <button id="submit-btn" onclick="concatNames(); submitForm();" class="button btn btn-lg btn-block disable-btn"><span class="float-left">Pay</span><span id="total-btn" class="float-right">{{  $total_after_discount ?? 'none' }} Points</span></button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        statusCss();
        grandTotal();
        function statusCss(){
            if({{$total_before_discount}} == {{$total_after_discount}}){
                document.getElementById("before-discount-row").setAttribute("hidden", true);
                document.getElementById("discount-row").setAttribute("hidden", true);
            }

            //check if sufficient funds
            if({{$user_points}} >= {{$total_after_discount}}){
                document.getElementById("total").style.color = "green";
                document.getElementById("submit-btn").classList.remove("disable-btn");
                document.getElementById("error-message").setAttribute("hidden", true);
            }else{
                document.getElementById("total").style.color = "red";
            }
        }

        {{--function grandTotal (){--}}
        {{--    var grandTotal = {{$user_points}} - {{$total_after_discount}};--}}
        {{--    document.getElementById("total-value").innerHTML = {{$total_after_discount}};--}}
        {{--}--}}

    </script>
@endsection
