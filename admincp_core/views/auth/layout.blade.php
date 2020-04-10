<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/favicon.png') }}">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('/admincp_assets/css/auth.css') }}">
</head>
<body>
    @yield('content')
    <script src="{{ asset('/admincp_assets/js/auth.js') }}"></script>
</body>
</html>
