<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('bootstrap-4.0.0/js/jquery-3.2.1.slim.min.js') }}"></script> --}}
    <!-- jQuery -->
    <script src="{{ asset('AdminLTE-3.1.0/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('web fonts/google-fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('web fonts/fontawesome-pro-5.12.0-web/css/all.min.css') }}">
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    {{-- <link href="{{ asset('bootstrap-4.0.0/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('MDB5-STANDARD-UI-KIT-Free-3.10.1/css/mdb.min.css') }}" rel="stylesheet">
    <link href="{{ asset('MDBootstrap-5-v2.0.0/css/mdb.min.css') }}" rel="stylesheet">
    <style>
        /* .main-navbar-transition {
            background-color: red !important;
            border-bottom: 4px solid green;
            transition: background-color 1s, border-bottom 0.5s;
        } */
        .main-navbar {
            border-bottom: 4px solid green;
        }
        /* .nav-item > a {
            color: red
        } */
        .nav-item.active {
            font-weight: bold;
            color: green;
        }
        .navbar-toggler {
            border: none
        }
        .navbar-toggler:focus {
            outline: none
        }

        .background-image-container {
            width: 100%;
            position: fixed;
            opacity: 10%;
            z-index: -1000;
            left: 0;f
            top: 0;
        }
        #loader {
            width: 100%;
            position: fixed;
            margin-top: 150px;
            /* left: 0; */
            top: 1;
            z-index: 9999999;
            background-color: transparent;
        }
    </style>
    @yield('style')
</head>
<body>
    <nav class="main-navbar navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('images/logo.png') }}" width="30" height="30" class="d-inline-block align-top" alt="">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="aboutUsDropdownMenu" data-mdb-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            About Us
                        </a>
                        <div class="dropdown-menu" aria-labelledby="aboutUsDropdownMenu">
                            <a class="dropdown-item" href="{{ route('website.vision_mission') }}">Vision/Mission</a>
                            <a class="dropdown-item" href="{{ route('website.bsf_hymn') }}">BSF Hymn</a>
                            <a class="dropdown-item" href="{{ route('website.history') }}">History</a>
                            <a class="dropdown-item" href="{{ route('website.achievements') }}">Achievements</a>
                            <a class="dropdown-item" href="{{ route('website.contact_us') }}">Contact us</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="administrationDropdownMenu" data-mdb-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Administration
                        </a>
                        <div class="dropdown-menu" aria-labelledby="administrationDropdownMenu">
                            <a class="dropdown-item" href="{{ route('website.campus_officials') }}">Campus Officials</a>
                            <a class="dropdown-item" href="{{ route('website.ssg_officials') }}">SSG Officials</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="newsDropdownMenu" data-mdb-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            News
                        </a>
                        <div class="dropdown-menu" aria-labelledby="newsDropdownMenu">
                            <a class="dropdown-item" href="{{ route('website.campus_news') }}">Campus News</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="servicesDropdownMenu" data-mdb-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Services
                        </a>
                        <div class="dropdown-menu" aria-labelledby="servicesDropdownMenu">
                            <a class="dropdown-item" href="{{ route('website.courses') }}">Courses Offered</a>
                            <a class="dropdown-item" href="{{ route('website.enrollment_procedure') }}">Enrollment Procedure</a>
                            <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="mt-5 pt-2 content">
        <div class="text-center">
            @include('partials.loader')
        </div>
        @if(url()->current() != route('website.vision_mission'))
        <div class="background-image-container text-center mt-5 pt-5">
            <img class="background-image" src="{{ asset('images/logo.png') }}">
        </div>
        @endif
        @yield('content')
    </section>
    <footer class="text-center text-lg-start bg-light text-muted pt-1" style="border-top: 4px solid green">
        <section class="">
            <div class="container text-center text-md-start mt-5">
                <div class="row mt-3">
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold mb-4">
                            About Us
                        </h6>
                        <p>
                            <a href="{{ route('website.vision_mission') }}" class="text-reset">Vision/Mission</a>
                        </p>
                        <p>
                            <a href="{{ route('website.bsf_hymn') }}" class="text-reset">BSF Hymn</a>
                        </p>
                        <p>
                            <a href="{{ route('website.history') }}" class="text-reset">History</a>
                        </p>
                        <p>
                            <a href="{{ route('website.achievements') }}" class="text-reset">Achievements</a>
                        </p>
                        <p>
                            <a href="{{ route('website.contact_us') }}" class="text-reset">Contact Us</a>
                        </p>
                    </div>
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold mb-4">
                            Administration
                        </h6>
                        <p>
                            <a href="{{ route('website.campus_officials') }}" class="text-reset">Campus Officials</a>
                        </p>
                        <p>
                            <a href="{{ route('website.ssg_officials') }}" class="text-reset">SSG Officials</a>
                        </p>
                    </div>
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold mb-4">
                            News
                        </h6>
                        <p>
                            <a href="{{ route('website.campus_news') }}" class="text-reset">Campus News</a>
                        </p>
                    </div>
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold mb-4">
                            Services
                        </h6>
                        <p>
                            <a href="{{ route('website.courses') }}" class="text-reset">Courses Offered</a>
                        </p>
                        <p>
                            <a href="{{ route('website.enrollment_procedure') }}" class="text-reset">Enrollment Procedure</a>
                        </p>
                        <p>
                            <a href="{{ route('login') }}" class="text-reset">Login</a>
                        </p>
                    </div>
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        <h6 class="text-uppercase fw-bold mb-4">
                            Contact
                        </h6>
                        <p>
                            <i class="fas fa-location me-3"></i> San Isidro Norte, Binmaley, Pangasinan
                        </p>
                        <p>
                            <i class="fas fa-envelope me-3"></i>
                            binmaleysof@gmail.com
                        </p>
                        <p>
                            <i class="fas fa-phone me-3"></i> (075) 540 0288
                        </p>
                        <p>
                            <i class="fab fa-facebook-f"></i> 
                            <a href="https://www.facebook.com/BinmaleySchoolOfFisheries" class="me-4 text-reset" target="_blank">Binmaley School of Fisheries</a>
                        </p>
                        
                    </div>
                </div>
            </div>
        </section>
    
        <!-- Copyright -->
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2021 Copyright:
        <a class="text-reset fw-bold" href="{{ config('app.url') }}">Binmaley School of Fisheries</a>
        </div>
        <!-- Copyright -->
    </footer>
    <!-- Footer -->
    {{-- <script src="{{ asset('bootstrap-4.0.0/js/bootstrap.bundle.min.js') }}"></script> --}}
    <script src="{{ asset('MDB5-STANDARD-UI-KIT-Free-3.10.1/js/mdb.min.js') }}"></script>
    <script src="{{ asset('MDBootstrap-5-v2.0.0/js/mdb.min.js') }}"></script>
    <script>
        // loader
        $(window).on('beforeunload', function(){
           $('#loader').fadeIn();
        });
        $(window).on('load', function(){
           $('#loader').fadeOut();
        });

        // animate navbar on scroll
        $(window).scroll(function() {
            if ($(document).scrollTop() > 100) {
                $('nav').addClass('main-navbar-transition');
            } else {
                $('nav').removeClass('main-navbar-transition');
            }
        });
    </script>
    @yield('script')
</body>
</html>
