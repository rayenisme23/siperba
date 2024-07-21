<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light-theme">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | PT. Indoneptune Net</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ URL::asset('build/images/logo-indoneptune.png') }}" type="image/png">

    @include('layouts.head-css')
</head>

<body class="{{ isset($bodyClass) ? $bodyClass : '' }}">
    @include('sweetalert::alert')
    @yield('content')

    @include('layouts.common-scripts')
</body>

</html>
