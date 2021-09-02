

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{__('Registration')}}</title>
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
                    <div class="row text-center">
                        <div class="col-lg-8 offset-lg-2">
                            <div class="logo">
                                <a href="#">
                                    <img @if(!empty(allsetting('login_logo'))) src ="{{ asset(path_image().allsetting('login_logo')) }}" @else src="{{asset('assets/images/logo2.png')}}" @endif  alt="" class="img-fluid">
                                </a>
                            </div>
                            <div class="qz-user-title">
                                <h1>{{__('Sign Up')}}</h1>
                            </div>
                            <h5>
                                @if(isset(allsetting()['signup_text']) && (!empty(allsetting('signup_text'))))
                                    {{allsetting('signup_text')}}
                                @else
                                    {{__('Hello there, Sign up and Join with Us')}}
                                @endif
                            </h5>
                                <span class="text-left">
                                    @include('layout.message')
                                </span>

                            {{ Form::open(['route' => 'userSave']) }}
                            {{csrf_field()}}
                            <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" placeholder="Username">
                                            <div class="qz-input-icon">
                                                <span class="flaticon-user-1"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control" placeholder="Email">
                                            <div class="qz-input-icon">
                                                <span class="flaticon-mail"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control" placeholder="Password">
                                            <div class="qz-input-icon">
                                                <span class="flaticon-lock"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                                            <div class="qz-input-icon">
                                                <span class="flaticon-lock"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="text" name="phone" class="form-control" placeholder="Phone">
                                            <div class="qz-input-icon">
                                                <span class="flaticon-phone-call"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">{{__('Sign Up')}}</button>
                                        </div>
                                    </div>
                                </div>
                            {{ Form::close() }}

                            <div class="qz-user-footer">
                                <h4>{{__('Already have an account ?')}} <a href="{{route('login')}}">{{__('Sign In')}}</a> </h4>
                                {{--<p>--}}
                                {{--Or sign in with--}}
                                {{--<a href="#" class="qz-fb"><i class="fa fa-facebook"></i></a>--}}
                                {{--<a href="#" class="qz-ing"><i class="fa fa-instagram"></i></a>--}}
                                {{--<a href="#" class="qz-gp"><i class="fa fa-google-plus"></i></a>--}}
                                {{--</p>--}}
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
