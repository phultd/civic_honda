<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin • @yield('title', 'Dashboard')</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/favicon.png') }}">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&amp;subset=vietnamese" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/admincp_assets/css/cms.css') }}">

    @yield('styles')

    <script type="text/javascript">
    	var csrf = "{{ csrf_token() }}";
		var asset_url = "{{ asset('/') }}";
		var app_env = "{{ App::environment() }}";
    </script>

	@yield('scripts_top')

</head>
<body>

	<div id="cms">

		{{-- navbar --}}
		@include('panel.partials.layout.navbar')
		{{-- sidebar menu --}}
		@include('panel.partials.layout.sidebar')

		{{-- content --}}
		<div id="content-wrapper">
			@include('panel.partials.layout.message')
			@yield('content')
		</div>

	</div>

	<script src="{{ url('/admincp_assets/js/ckeditor/ckeditor.js') }}"></script>
	<script type="text/javascript" src="{{ url('/admincp_assets/js/ckfinder/ckfinder.js') }}"></script>
	<script>
		var connector_path = "{{ url('/ckfinder/connector') }}";
		CKFinder.config( { connectorPath: connector_path } );
	</script>
    <script src="{{ url('/admincp_assets/js/cms.js') }}"></script>

	@yield('scripts_bottom')

</body>

</html>
