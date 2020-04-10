<nav class="navbar fixed-top navbar-light bg-white">
	<div class="btn-toolbar">
		<button type="button" class="btn btn-sm btn-primary sidebar-toggle" title="Toggle sidebar">
			<i class="fa fa-bars"></i>
		</button>
		<a href="{{ url('/') }}" target="_blank" class="btn btn-sm btn-primary ml-2 px-4" title="Visit site">
			<i class="fa fa-home"></i>
		</a>
	</div>
	<div class="text-center">
		<i class="fa fa-map-marker mr-2"></i>@yield('title', 'Dashboard')
	</div>
	<form action="{{ route('admincp.logout') }}" method="post">
		Hello, <strong>{{ Auth::user()->name }}</strong>
		@csrf
		<button class="btn btn-sm btn-primary ml-3" title="Log out"><i class="fa fa-sign-out"></i></button>
	</form>
</nav>
