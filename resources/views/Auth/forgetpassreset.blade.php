
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{__('Forgot password')}}</title>
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
            <div class="card login-card">
                <div class="card-body login-c-body">
                    @include('layout.message')
                    <div class="row text-center mt-3">
                        <div class="col-lg-4 offset-lg-4">
                            <div class="logo">
                                <a href="#">
                                    <img @if(!empty(allsetting('login_logo'))) src ="{{ asset(path_image().allsetting('login_logo')) }}" @else src="{{asset('assets/images/logo2.png')}}" @endif  alt="" class="img-fluid">
                                </a>
                            </div>
                            <div class="qz-user-title">
                                <h1>{{__('Forgot Password')}}</h1>
                            </div>
                            <div class="form-group">
                                <a href= {{ route('login') }}>
                                    <button id="form_submit" class="btn btn-primary" type="button">{{_('Back')}} <i class="ti-arrow-right"></i></button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End user area -->


<!-- Jquery plugins -->
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<!-- Owl Carousel -->
<script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
<!-- Counterup -->
<script src="{{asset('assets/js/waypoints.min.js')}}"></script>
<script src="{{asset('assets/js/counterup.min.js')}}"></script>
<!-- Slicknav -->
<script src="{{asset('assets/js/metisMenu.min.js')}}"></script>
<!-- magnific popup -->
<script src="{{asset('assets/js/magnific-popup.min.js')}}"></script>
<!-- Swiper Slider -->
<script src="{{asset('assets/vendors/swiper-master/js/swiper.min.js')}}"></script>
<!-- main js -->
<script src="{{asset('assets/js/main.js')}}"></script>
</body>

</html>
