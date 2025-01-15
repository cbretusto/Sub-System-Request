@php
    $isLogin = false;
    if(isset($_SESSION['rapidx_user_id'])){
        $isLogin = true;
    }
@endphp

@if($isLogin)
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>Sub-System Request| @yield('title')</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="shortcut icon" type="image/png" href="">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <!-- CSS LINKS -->
            @include('shared.css_links.css_links')
        </head>
        <body class="layout-fixed bg-body-tertiary">
            <img src="{{ asset('public/images/no_access.jpg') }}" style="height:100%; width:100%;">

            <!-- JS LINKS -->
            @include('shared.js_links.js_links')
            @yield('js_content')
        </body>
    </html>
@else
    <script type="text/javascript">
        window.location = "../RapidX/";
    </script>
@endif
