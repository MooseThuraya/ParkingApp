@extends('layouts.home')

<title> Packages </title>

@section('content')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h3 class="center-text page-header">Points Packages</h3>
                    @foreach($package_list as $data)
                        @foreach($data as $index)
                            <div class="list-record">
                            <div style="background-image: url({{URL::asset('images/iparkinglogoyellow.svg')}}); background-color: #430086" class="list-img background-img">
                            </div>
                            <div class="list-content">
                                <h3 class="list-number">Package #{{$loop->iteration}}</h3>
                                <p class="list-details">Points Count: {{ $index['points_count'] ?? '' }}</p>
                                <p class="list-details">Price: {{ $index['price'] ?? '' }}</p>
                                </div>
                        </div>
                        @endforeach
                    @endforeach
                </div>

            </div>

        </div>





{{--    </div>--}}

    <script type="text/javascript">
        $(document).ready(function(){
            $('.carousel').carousel({
                interval: 100
            })
        });


    </script>
@endsection
