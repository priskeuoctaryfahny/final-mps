<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr" data-navigation-type="default" data-navbar-horizontal-shape="default">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>{{ $sets->web_title ? $sets->web_title : config('app.name') }} - {{ $slot }}</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ $sets->web_favicon ? Storage::url($sets->web_favicon) : asset('backend/assets/img/default/nope.jpg') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ $sets->web_favicon ? Storage::url($sets->web_favicon) : asset('backend/assets/img/default/nope.jpg') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ $sets->web_favicon ? Storage::url($sets->web_favicon) : asset('backend/assets/img/default/nope.jpg') }}">
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ $sets->web_favicon ? Storage::url($sets->web_favicon) : asset('backend/assets/img/default/nope.jpg') }}">
    <link rel="manifest" href="{{ asset('backend') }}/assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="{{ asset('backend') }}/assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('backend') }}/vendors/simplebar/simplebar.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/config.js"></script>


    @stack('header')



    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ asset('backend') }}/vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link href="{{ asset('backend') }}/assets/css/theme-rtl.min.css" type="text/css" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('backend') }}/assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
    <link href="{{ asset('backend') }}/assets/css/user-rtl.min.css" type="text/css" rel="stylesheet"
        id="user-style-rtl">
    <link href="{{ asset('backend') }}/assets/css/user.min.css" type="text/css" rel="stylesheet"
        id="user-style-default">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@latest/build/toastr.min.css">
    <script>
        var phoenixIsRTL = window.config.config.phoenixIsRTL;
        if (phoenixIsRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>
    <style>
        #loadingOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 1055;
        }
    </style>
</head>


<body>
    <div id="loadingOverlay"></div>
    <main class="main" id="top">
