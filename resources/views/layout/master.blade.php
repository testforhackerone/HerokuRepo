<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/png" href="@if(!empty(allsetting('favicon'))) {{ asset(path_image().allsetting('favicon')) }} @endif "/>
    <title>@yield('title','Quiz App | iTech')</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}">
    <!-- Slicknav -->
    <link rel="stylesheet" href="{{asset('assets/css/metisMenu.min.css')}}">
    <!-- magnific popup -->
    <link rel="stylesheet" href="{{asset('assets/css/magnific-popup.css')}}">
    <!-- Swiper Slider -->
    <link rel="stylesheet" href="{{asset('assets/vendors/swiper-master/css/swiper.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/iconfont/flaticon.css')}}">
    <!-- Start data table -->
    <link rel="stylesheet" href="{{asset('assets/DataTables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/DataTables/css/responsive.dataTables.min.css')}}">
    {{-- editor--}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" rel="stylesheet">
    <!-- font family -->
    <link rel="stylesheet" href="{{asset('assets/css/proxima-nova.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/scrollbar.css')}}">
    <!-- Modernizr Js -->
    <script src="{{asset('assets/vendors/modernizr-js/modernizr.js')}}"></script>
    <!--for image drag and drop-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/dropify/css/dropify.min.css')}}">
    <!-- Site Style -->
    <link rel="stylesheet" href="{{asset('assets/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
</head>

<body>
<!-- <div class="loader-wraper">
    <img src="{{asset('assets/images/loader.gif')}}" alt="">
</div> -->

<!-- Start wrapper -->
<div class="qz-wrapper">
@yield('left-sidebar')
<!-- Start main content -->
    <div class="qz-main-content">
        @yield('header')
        @yield('main-body')
    </div>
    <!-- End main content -->
</div>
<!-- End wrapper -->




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
<!-- magnific popup -->
<script src="{{asset('assets/js/magnific-popup.min.js')}}"></script>
<!-- Swiper Slider -->
<script src="{{asset('assets/vendors/swiper-master/js/swiper.min.js')}}"></script>
<!-- Start data table -->
<script src="{{asset('assets/DataTables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/DataTables/js/dataTables.responsive.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.scrollbar/0.2.11/jquery.scrollbar.min.js"></script>
{{--Bootstrap editor--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.js"></script>
<!--drag and drop js-->
<script src="{{asset('assets/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('assets/dropify/js/form-file-uploads.js')}}"></script>
<!-- main js -->
<script src="{{asset('assets/js/main.js')}}"></script>
<script>
    $('#btEditor').summernote({height: 400});
    $('#btEditor2').summernote({height: 400});
</script>
@yield('script')

</body>
</html>