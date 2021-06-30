@extends('layouts.home')

<title> Home Page </title>

@section('content')

{{--    <div class="page-container">--}}

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
{{--                    <div style="background-image: url({{ $banner ?? URL::asset('images/iparkinglogoyellow.svg')}})"; class="hero-image">--}}

{{--                    </div>--}}
                    <div id="carouselExampleIndicators" class="carousel slide banner-height" data-ride="carousel">
{{--                        <ol class="carousel-indicators banner-height">--}}
{{--                    @foreach ($get_banner as $index)--}}
{{--                        @if($loop->index == 0)--}}
{{--                          <li data-target="#carouselExampleIndicators" data-slide-to="{{$loop->index}}" class="active"></li>--}}
{{--                        @else--}}
{{--                          <li data-target="#carouselExampleIndicators" data-slide-to="{{$loop->index}}"></li>--}}
{{--                        @endif--}}
{{--                    @endforeach--}}
{{--                        </ol>--}}
                        <div class="carousel-inner banner">
                        @foreach ($get_banner as $index)
                            @foreach ($index as $value)
                                @if($loop->index == 0)
                                        <div class="carousel-item active">
                                            <img class="d-block w-100 carousel-img" src="{{$value['image']['url']}}" alt="slide {{$loop->index}}">
                                        </div>
                                @else
                                    <div class="carousel-item">
                                        <img class="d-block w-100 carousel-img" src="{{$value['image']['url']}}" alt="slide {{$loop->index}}">
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
{{--                    <div class="results-div">--}}
{{--                        <p class="results">15 Areas</p>--}}
{{--                    </div>--}}
                    @foreach($park_list as $data)
                        @foreach($data as $index)
                            <div class="list-record">
                            <div style="background-image: url({{URL::asset('images/iparkinglogoyellow.svg')}}); " class="list-img background-img">
                            </div>
                            <div class="list-content">
                                <h3 class="list-location">{{ $index['en_name'] ?? '' }}</h3>
{{--                                <p class="list-distance">120 km</p>--}}
                                <p class="list-distance"></p>
                                <p class="list-button link"><a href="{{ route('reservations.create', $index) }}">Book Appointment</a></p>
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
