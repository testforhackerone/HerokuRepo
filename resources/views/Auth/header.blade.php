

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{__('Login')}}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}">
    <!-- magnific popup -->
    <link rel="stylesheet" href="{{asset('assets/css/magnific-popup.css')}}">
    <!-- Swiper Slider -->
    <link rel="stylesheet" href="{{asset('assets/vendors/swiper-master/css/swiper.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/iconfont/flaticon.css')}}">
    <!-- font family -->
    <link rel="stylesheet" href="{{asset('assets/css/proxima-nova.css')}}">
    <!-- Site Style -->
    <link rel="stylesheet" href="{{asset('assets/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
    <!-- Modernizr Js -->
    <script src="{{asset('assets/vendors/modernizr-js/modernizr.js')}}"></script>
    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
</head>

<body class="user-body">


<!-- Start user area -->
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card">
                    <div class="card-body">
                        @include('layout.message')
                    </div>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-lg-4 offset-lg-4">
                            <div class="logo">
                                <a href="#">
                                    <img @if(!empty(allsetting('login_logo'))) src ="{{ asset(path_image().allsetting('login_logo')) }}" @else src="{{asset('assets/images/logo2.png')}}" @endif  alt="" class="img-fluid">
                                </a>
                            </div>