<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('panel.site_title') }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css" rel="stylesheet" />
{{--    <link href="{{asset('css/app.css')}}" rel="stylesheet" />--}}
        <link href="{{asset('css/home.css')}}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css">
    @yield('styles')
</head>

{{--<body class="header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden login-page">--}}
<body>
<div id="mySidenav" class="sidenav">
    <div class="user-info">
        <img class="user-img" src="{{asset('images/userimage.svg')}}">
        <p class="user-name">{{session()->get('user_info')['user']['name']}}</p>
    </div>
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
{{--    <div class="list-element">--}}
    <div class="sidebar-list">
        <a class="sidebar-item" href="{{ route('home.index') }}">
            <div class="list-element {{request()->is("home") ? "list-element-active" : ""}}"></div>
            <i class="material-icons sidebar-icon ">home</i>
            <h3 class="sidebar-text">Home</h3>
        </a>
        {{--    </div>--}}
        <a class="sidebar-item" href="{{route('profile.index') }}">
            <div class="list-element {{request()->is("profile") ? "list-element-active" : ""}}"></div>
            <i class="material-icons sidebar-icon">person</i>
            <h3 class="sidebar-text">Profile</h3>
        </a>
        <a class="sidebar-item" href="{{route('reservations.index') }}">
            <div class="list-element {{request()->is("reservations") ? "list-element-active" : ""}}"></div>
            <i class="material-icons sidebar-icon">directions_car</i>
            <h3 class="sidebar-text">Reservations</h3>
        </a>
        <a class="sidebar-item" href="{{route('logout') }}">
            <div class="list-element"></div>
            <i class="material-icons sidebar-icon">logout</i>
            <h3 class="sidebar-text">Logout</h3>
        </a>
    </div>

    <div class="sidebar-social">
        <i class="fab fa-twitter fa-2x sidebar-social-icon"></i>
        <i class="fab fa-instagram fa-2x sidebar-social-icon"></i>
        <i class="fab fa-facebook fa-2x sidebar-social-icon"></i>
    </div>
</div>

<div id="backdrop" class="backdrop">

</div>
<nav class="top-navbar">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
{{--                <div class="burger-div">--}}
{{--                    <div class="menu-btn">--}}
{{--                        <div class="menu-btn__burger"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <img class="burger" src="{{asset('images/burger.svg')}}">--}}

                <div class="logo-div">
{{--                    <p class="user-name">{{session()->get('profile_info')['user']['user_points']}}</p>--}}
                    <img class="logo" src="{{asset('images/iparkinglogoyellow.svg')}}">
                </div>
                <div style="height: 80px">

                </div>
                <div class="search-div">
                 <span class="burger-icon" onclick="openNav()">&#9776;</span>
                    <span class="material-icons wallet-icon"><span class="material-icons">account_balance_wallet</span></span>
                    <h6 class="points-title">You have <span class="yellow-points-title">{{session()->get('profile_info')['user']['user_points']}}</span> I Parking Points</h6>
                    <h6 class="search-title">LET'S FIND YOU A SPACE</h6>
                    <input style="" class="form-control search-field" placeholder="Search for a parking area">
                    <i class="material-icons nav-icon search-icon">search</i>
                </div>
            </div>
        </div>
    </div>
</nav>



@yield('content')
{{--this is so elements do not hide behind the bottom nav bar--}}

<div class="bottom-navbar-top-margin">

</div>
{{--<div class="bottom-navbar-button">--}}

{{--</div>--}}
<nav class="bottom-navbar">
    <a href="{{ route('home.index') }}" class="nav-link {{request()->is("home") ? "nav-link--active" : ""}}">
        <i class="material-icons nav-icon">home</i>
        <span class="nav-text">Home</span>
    </a>
    <a href="{{ route('reservations.index') }}" class="nav-link {{request()->is("reservations") ? "nav-link--active" : ""}}">
{{--        <div class="appointments-button">--}}
{{--            <i class="material-icons nav-icon appointments-icon">directions_car</i>--}}
{{--        </div>--}}
{{--        <span class="nav-text nav-text-appointments">Appointments</span>--}}
            <i class="material-icons nav-icon">directions_car</i>
        <span class="nav-text">Appointments</span>
    </a>
    <a href="{{ route('packages.index') }}" class="nav-link {{request()->is("packages") ? "nav-link--active" : ""}}">
        <i class="material-icons nav-icon"><span class="material-icons">inventory_2</span></i>
        <span class="nav-text">Packages</span>
    </a>
</nav>

{{--<a href="#"/>--}}
{{--<div class="appointments-button">--}}
{{--    <i class="material-icons nav-icon appointments-icon">directions_car</i>--}}
{{--</div>--}}
{{--</a>--}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{ asset('js/home.js') }}"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>

@yield('scripts')


<script>


    // function openNav() {
    //     document.getElementById("mySidenav").style.maxWidth = "300px";
    //     document.getElementById("mySidenav").style.Width = "80%";
    //     document.getElementById("backdrop").style.zIndex = 60;
    //     document.getElementById("backdrop").style.backgroundColor = "rgba(0,0,0,0.4)";
    // }
    function openNav() {
        if(window.screen.width > window.screen.height){
            document.getElementById("mySidenav").style.width = "300px";
            document.getElementById("backdrop").style.zIndex = 60;
            document.getElementById("backdrop").style.backgroundColor = "rgba(0,0,0,0.4)";
        }else{
            document.getElementById("mySidenav").style.width = "80%";
            document.getElementById("backdrop").style.zIndex = 60;
            document.getElementById("backdrop").style.backgroundColor = "rgba(0,0,0,0.4)";
        }

        // document.getElementById("mySidenav").style.maxWidth = "300px";
        // document.getElementById("mySidenav").style.width = "80%";
        // document.getElementById("backdrop").style.zIndex = 60;
        // document.getElementById("backdrop").style.backgroundColor = "rgba(0,0,0,0.4)";

    }
    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        document.getElementById("backdrop").style.zIndex = -10;
        document.getElementById("backdrop").style.backgroundColor = "rgba(0,0,0,0.0)";
    }

    const menuBtn = document.querySelector('.menu-btn');
    let menuOpen = false;
    menuBtn.addEventListener('click', () => {
        if(!menuOpen) {
            menuBtn.classList.add('open');
            menuOpen = true;
        } else {
            menuBtn.classList.remove('open');
            menuOpen = false;
        }
    });
</script>
</body>

</html>
