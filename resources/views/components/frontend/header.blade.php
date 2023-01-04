<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @if (Session::has('pagetitle'))
            {{ Session::get('pagetitle') }}
        @elseif(!Session::has('pagetitle'))
            {{ 'Page Title' }}
        @endif
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="{{ asset('frontend/themes/js/jquery.js') }}" type="text/javascript"></script>

    <!-- Front style -->
    <link id="callCss" rel="stylesheet" href={{ asset('frontend/themes/css/front.min.css') }} media="screen" />
    <link href={{ asset('frontend/themes/css/base.css') }} rel="stylesheet" media="screen" />
    <!-- Front style responsive -->
    <link href={{ asset('frontend/themes/css/front-responsive.min.css') }} rel="stylesheet" />
    <link href={{ asset('frontend/themes/css/font-awesome.css') }} rel="stylesheet" type="text/css">
    <!-- Google-code-prettify -->
    <link href={{ asset('frontend/themes/js/google-code-prettify/prettify.css') }} rel="stylesheet" />
    <!-- fav and touch icons -->

    <link rel="shortcut icon" href={{ asset('frontend/themes/images/ico/favicon.ico') }}>
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href={{ asset('frontend/themes/images/ico/apple-touch-icon-144-precomposed.png') }}>
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href={{ asset('frontend/themes/images/ico/apple-touch-icon-114-precomposed.png') }}>
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href={{ asset('frontend/themes/images/ico/apple-touch-icon-72-precomposed.png') }}>
    <link rel="apple-touch-icon-precomposed"
        href={{ asset('frontend/themes/images/ico/apple-touch-icon-57-precomposed.png') }}>
    <style type="text/css" id="enject"></style>
</head>
