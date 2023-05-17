<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title')</title>
    <meta http-equiv="Cache-Control" content="no-transform"/>
    <meta name="keywords" content="@yield('keywords')" />
    <meta name="description" content="@yield('description')" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="applicable-device" content="pc,mobile"/>

    <link rel="shortcut icon" href="{{ asset('logo.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('skin/css/main.css') }}" media="screen"/>
    <link rel="stylesheet" href="{{ asset('skin/css/fontello.css') }}"/>
    <!--[if IE 7]>
    <link rel="stylesheet" href="{{ asset('skin/css/fontello-ie7.css') }}">
    <![endif]-->
    <link rel="stylesheet" href="{{ asset('skin/css/animate.css') }}"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{ asset('skin/js/html5-css3.js') }}"></script>
    <![endif]-->
    <script type="text/javascript" src="{{ asset('skin/js/jquery-1.11.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.lazyload.js') }}"></script>
    <link href="{{ asset('skin/css/prettify.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('skin/js/prettify.js') }}" type="text/javascript"></script>
    <script src="{{ asset('skin/js/common_tpl.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('skin/js/jquery.flexslider-min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('skin/js/wow.js') }}"></script>
    <script>new WOW().init();</script>
    <script type="text/javascript" src="{{ asset('skin/js/leonhere.js') }}"></script>
</head>
<body>

<!--  header  -->
@include(include_name('layouts.header'))

@yield('content')
<!--  footer  -->
@include(include_name('layouts.footer'))

@yield('script')
<script>
    $(document).ready(function(){
        //头部——搜索框
        $(".search-form").children("input").on('keydown', function(e){
            if(e.keyCode === 13){
                e.preventDefault();
                window.location.href = "https://www.3cc0.com/search/"+ $(".search-form").children("input").val();
            };
        });
        $("img.load").lazyload({effect: "fadeIn"});
    });
</script>
</body>
</html>
