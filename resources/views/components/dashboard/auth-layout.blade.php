<!doctype html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>{{ $title }}</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/dashboard') }}/images/favicon.ico">

    <!-- preloader css -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/css/preloader.min.css" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/dashboard') }}/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/dashboard') }}/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/dashboard') }}/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

     <!-- Scripts -->
     {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}

</head>
<body>
   
    {{ $slot }}

</body>
</html>
