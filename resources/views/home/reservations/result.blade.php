@extends('layouts.home')

<title> Reserve </title>

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 style="text-align: center; margin-top: 50px">{{$title ?? "A an error occurred"}}</h3>
                <p style="text-align: center;">{{$message ?? "You have been refunded due to an error in the operation! Please, try again later"}}</p>
                <br>

            </div>
        </div>
    </div>


    <script type="text/javascript">

    </script>
@endsection
