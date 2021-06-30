@extends('layouts.home')

<title> Home Page </title>

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="center-text page-header">My Appointments</h3>
            @foreach($reservation_list as $index)
                @if($index['status'] == null && \Carbon\Carbon::parse($index['end_datetime'])->isFuture())
                    <div class="list-record">
                        <div style="background-image: url({{URL::asset('images/iparkinglogoyellow.svg')}}); background-color: black" class="list-img background-img">
                        </div>
                        <div class="list-content">
                            <h3 class="list-location-id">Location: {{ $index['en_name']?? '' }}</h3>
                            <p class="list-start-time">Start Time: {{ $index['start_datetime'] ?? '' }}</p>
                            <p class="list-end-time" onclick="d();">End Time: {{ $index['end_datetime'] ?? '' }}</p>
                            <p class="list-button cancel-link"><a class="cancel-link" value="Delete" data-toggle="modal" data-target="#deleteModal" onclick="cancelByID({{ $index['id'] }})">Cancel Appointment</a></p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
<div class="deletePopUp">
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Cancel Appointment</h5>
                    <button type="button" class="close popup-close-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="cancelReservation"  method="POST" action="{{ route('cancelReservation') }}" content="application/json; charset=UTF-8">
                {{ csrf_field() }}
                <!-- Two options: Delete or cancel -->
                    <input id="Reservation_id" name="Reservation_id" hidden>
                    <div class="modal-body">
                        Are you sure you want to cancel this appointment?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="return-button btn btn-sm" data-dismiss="modal">Return</button>
                        <a><button class="cancel-button btn btn-lg" value="Delete" data-toggle="modal" data-target="#deleteModal" type="submit">Cancel Appointment</button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        function cancelByID(resID){
            $('#Reservation_id').val(resID);
        }
    </script>
@endsection
